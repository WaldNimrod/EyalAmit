const base = 'http://eyalamit-co-il-2026.s887.upress.link';
const paths = Array.from({ length: 19 }, (_, i) =>
  `/wp-content/uploads/2026/06/mukesh-dhiman-rishikesh-${String(i + 1).padStart(2, '0')}.jpeg`
);
const results = [];
for (const p of paths) {
  const r = await fetch(base + p, { method: 'HEAD' });
  results.push({ p, status: r.status, ct: r.headers.get('content-type') });
}
const bad = results.filter((x) => x.status !== 200);
console.log(JSON.stringify({ total: results.length, badCount: bad.length, results, bad }, null, 2));
