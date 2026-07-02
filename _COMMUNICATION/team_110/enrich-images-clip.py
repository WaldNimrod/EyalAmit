#!/usr/bin/env python3
"""Tag DOK-WEB images using CLIP (via HuggingFace transformers).

Output: hub/dist/files/team40/image-clip-tags.json
  { "DOK-AJPS8301": ["טבע", "אנשים", ...], ... }

Run: python3 _COMMUNICATION/team_110/enrich-images-clip.py
"""
import json, os
from PIL import Image

PROJ    = "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026"
DOK     = f"{PROJ}/docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/DOK-WEB"
CAT_J   = f"{PROJ}/_COMMUNICATION/team_110/build/catalogs/ea-dok-web/catalog-images.json"
OUT_JSON = f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/image-clip-tags.json"
SCORE_THRESH = 0.18   # minimum CLIP probability to accept a concept

# English prompts → Hebrew tags
# Each entry is (english_prompt, hebrew_tag)
# Group by category; the top-scoring concept per category wins
CONCEPT_GROUPS = {
    'scene': [
        ("a photo of a garden with plants and greenery",   "גן"),
        ("a desert landscape or dry terrain",              "מדבר"),
        ("a photo of nature with trees and forest",        "טבע"),
        ("an indoor room or interior space",               "פנים"),
        ("an urban street or city",                        "עיר"),
        ("the ocean sea or beach",                         "ים"),
        ("mountains or rocky landscape",                   "הרים"),
    ],
    'people': [
        ("a photo of a person or human being",             "אנשים"),
        ("a group of people or crowd",                     "קבוצה"),
        ("a child or children",                            "ילדים"),
        ("a close up portrait of a face",                  "פורטרט"),
    ],
    'activity': [
        ("a person playing a musical instrument",          "נגינה"),
        ("meditation yoga or spiritual practice",          "מדיטציה"),
        ("therapy healing or wellness session",            "ריפוי"),
        ("teaching workshop or lecture",                   "הדרכה"),
        ("a book or publication",                          "ספר"),
        ("holding a phone or filming video",               "צילום"),
    ],
    'instrument': [
        ("a long wooden wind instrument didgeridoo",       "דיגרידו"),
        ("singing bowls for sound healing",                "קערות שירה"),
        ("a guitar or stringed instrument",                "גיטרה"),
    ],
    'mood': [
        ("a happy joyful moment or celebration",           "שמחה"),
        ("a peaceful calm or relaxing scene",              "רגיעה"),
        ("a spiritual or mystical atmosphere",             "רוחניות"),
    ],
}


def load_model():
    import torch
    from transformers import CLIPProcessor, CLIPModel
    device = 'mps' if torch.backends.mps.is_available() else 'cpu'
    print(f"Loading CLIP model on {device}…")
    model = CLIPModel.from_pretrained("openai/clip-vit-base-patch32").to(device)
    processor = CLIPProcessor.from_pretrained("openai/clip-vit-base-patch32")
    return model, processor, device


def tag_image(img_path: str, model, processor, device) -> list:
    import torch

    try:
        img = Image.open(img_path).convert('RGB')
    except Exception:
        return []

    tags = []
    with torch.no_grad():
        for group_name, concepts in CONCEPT_GROUPS.items():
            texts = [c[0] for c in concepts]
            labels = [c[1] for c in concepts]

            inputs = processor(
                text=texts,
                images=img,
                return_tensors='pt',
                padding=True,
            )
            inputs = {k: v.to(device) for k, v in inputs.items()}

            outputs = model(**inputs)
            probs = outputs.logits_per_image.softmax(dim=1)[0]

            # Pick the top concept in this group if it passes threshold
            best_i = probs.argmax().item()
            best_p = probs[best_i].item()
            if best_p >= SCORE_THRESH:
                tags.append(labels[best_i])

    return tags


def main():
    import torch

    model, processor, device = load_model()

    # Load existing results to resume
    existing = {}
    if os.path.exists(OUT_JSON):
        with open(OUT_JSON, encoding='utf-8') as f:
            existing = json.load(f)
        print(f"Resuming — {len(existing)} already done")

    with open(CAT_J, encoding='utf-8') as f:
        entries = json.load(f)

    todo = [e for e in entries if e['id'] not in existing]
    total = len(todo)
    print(f"To process: {total} / {len(entries)}")

    for i, entry in enumerate(todo, 1):
        img_id = entry['id']
        sm_path = os.path.join(DOK, entry['sm'])
        tags = tag_image(sm_path, model, processor, device)
        existing[img_id] = tags

        if i % 50 == 0 or i == total:
            with open(OUT_JSON, 'w', encoding='utf-8') as f:
                json.dump(existing, f, ensure_ascii=False, indent=2)
            print(f"  {i}/{total}  saved")

    with open(OUT_JSON, 'w', encoding='utf-8') as f:
        json.dump(existing, f, ensure_ascii=False, separators=(',', ':'))
    print(f"\nDone. {len(existing)} images tagged → {OUT_JSON}")


if __name__ == '__main__':
    main()
