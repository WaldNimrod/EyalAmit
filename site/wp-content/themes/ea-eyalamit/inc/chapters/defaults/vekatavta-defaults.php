<?php
/**
 * Chapters /books/vekatavta/ (וכתבת — book detail) — seeded content defaults.
 *
 * S006 R1-19 · מקור: content 13.8.26/וכתבת/vekatavta.md
 * VKT-03/04/05 GO BUILD. SECTION 13 DEV NOTES not rendered.
 * VKT-01/02 media not in this build — hero cover kept; gallery image slots not rendered.
 * Purchase CTAs = Mendele URL from the md. Price and third-party checkout chrome dropped.
 * היקוקומורי / היקוקמורי kept as in the md.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 06 שורה 219 · 252 במסמך */
	'meta_pages' => 252,

	/* S006 R1-19 VKT-03/04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 01 */
	'phero' => array(
		/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 01 שורה 10 · H1 בלי em, בלי chap */
		'title'     => 'וכתבת',
		/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 01 שורות 12–13 · שתי שורות, בלי נקודה מחברת */
		'sub'       => '46 סיפורים אמיתיים מחייו של אייל עמית
ספר אישי, מעורר השראה, שנע דרך אהבה, מסעות, הורות, אובדן, שינוי וצמיחה.',
		/* S006 R1-19 VKT-01 KEEP — media waits for Eyal; existing cover not changed in this GO BUILD */
		'media'     => 'assets/images/vekatavt-cover.jpg',
		'media_alt' => 'אייל עמית — וכתבת',
		/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 01 שורה 15 · בלי מחיר */
		'cta_label' => 'לרכישת הספר',
		/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 01 שורה 15 */
		'cta_url'   => 'https://www.mendele.co.il/product/vekatavta/',
		/* S006 R1-19 VKT-04 · DEV NOTES SECTION 01: קישור חיצוני בלשונית חדשה (cta_slug → target=_blank) */
		'cta_slug'  => 'vekatavta',
	),

	'sections' => array(

		/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 02 · שורות 27–39 · ל+וכתבת */
		array(
			'part' => 'prose',
			'args' => array(
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 02 · H2 */
				'title' => 'תקציר הספר',
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 02 */
				'body'  => '<p><strong>ספר אישי מאוד, חי מאוד, ומלא קול.</strong></p><p><strong>וכתבת</strong> הוא ספר שמאגד 46 סיפורים אמיתיים מחייו של אייל עמית - סיפורים על אהבה, זוגיות, הורות, קריירה, מסעות, בריאות, כסף, אומץ, אובדן, שינוי וצמיחה. הספר נע בין רגעים מצחיקים, מפתיעים, כואבים ומעוררי השראה, ונוגע בשאלות של חיים, בחירה, משמעות והיכולת להמשיך לנוע גם דרך תקופות קשות.</p><p>אוטוביוגרפיה, אבל לא כזו שמסופרת בצורה כבדה או פורמלית. הספר מתקדם דרך תחנות ואירועים בחיים, ולכן הוא מרגיש גם אישי מאוד וגם חי מאוד - כאילו החיים עצמם נפרשים דרך רצף של רגעים, התנסויות וסיפורים.</p><p>מה שמייחד את הספר הזה הוא לא רק מה מסופר בו, אלא איך. זהו ספר בסגנון <strong>ספוקן סטוריז</strong> - ז\'אנר שאייל פיתח, ואחר כך גם המשיך לבמה דרך סיפורים שנולדו מתוך הספר הזה. הקול כאן ישיר, אנושי, חד, לפעמים מצחיק מאוד, לפעמים כואב, ותמיד כזה שמרגיש קרוב.</p><p>זה גם ספר שאפשר לקבל ממנו הרבה השראה. מתחת לסיפורים עצמם נמצאת תנועה עמוקה יותר - ההבנה שמתוך המקומות הכי קשים אפשר לצמוח, לגדול, להשתנות, ולפעמים אפילו למצוא חיים חדשים דווקא מתוך השבר.</p><p>ייחודי במיוחד ל<strong>וכתבת</strong> הוא גם האלמנט של <strong>סריקת ה-QR</strong>: בסיום כל סיפור יש קוד QR ייחודי, שמוביל לעמוד נסתר באתר עם המשך לסיפור, וידאו או תמונה שקשורים אליו, וגם אפשרות להגיב ולשאול את אייל שאלות.</p><p>זה ספר שיכול לדבר גם למי שאוהב סיפורים קצרים, גם למי שמחפש עומק רגשי, וגם למי שרוצה לקרוא משהו אמיתי, זורם, לא צפוי, ומלא חיים.</p>',
			),
		),

		/* S006 גל 7 · כפתור רכישה גם מתחת לתקציר */
		array(
			'part' => 'cta',
			'args' => array(
				'cta_label' => 'לרכישת הספר',
				'cta_url'   => 'https://www.mendele.co.il/product/vekatavta/',
				'cta_slug'  => 'vekatavta',
			),
		),

		/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 03 · שורות 56–164 · שבירת שורות · היקוקומורי/היקוקמורי */
		array(
			'part' => 'prose',
			'args' => array(
				'collapsible'   => true,
				'preview_lines' => 4,
				'toggle_label'  => 'להמשך קריאה',
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 03 · H2 */
				'title' => 'קטע מתוך הספר',
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 03 */
				'body'  => '<p>10 דברים שלא ידעתם עלי: 1. את ענת הכרתי על החוף בסיני. היא<br>סטודנטית בטכניון ואני חייל בצבא קבע. כן, ב-1998 זה היה עוד<br>אפשרי. אישור ממפקד הבסיס, חתימה מהשלישות, מהקב"טיה ומעוד כמה פלאפלים<br>בקרייה והופ, אתה מוצא עצמך במונית פג\'ו 504 עם רוח חמה בפרצוף.<br>בילינו מלא על החוף, אבל רק אחרי שהקאתי עליה, עליה! ממש ממש<br>עליה, על כל הגוף שלה, ורק אחרי שסיפרתי לה את הסוד הגדול<br>והנורא בחיי, הבנתי שאני מאוהב בה עד העצמות ושהיא האישה של<br>חיי. לענת זה לקח קצת יותר זמן, בכל זאת, את לא מתאהבת<br>כל כך מהר בגבר שמקיא עליך. ומה היה הסוד הנורא? או.</p><p>2. הפעם הראשונה בחיי שעליתי על מטוס היתה בגיל 24. הטיול<br>הגדול אחרי הצבא לדרום אמריקה. כשהכרתי את ענת, בסך הכל<br>חודשיים לפני, כבר היו לי כרטיסים ביד. נפרדנו בדמעות ועליתי על<br>המטוס. כששאלתי את הדיילת של בריטיש איירווייס כמה עולה קולה,<br>היא חייכה אלי כמו אל סתום ואמרה לי שזה בסדר. סתום<br>אכן הייתי.</p><p>3. בברזיל, ריו דה ג\'נירו, חוף קופה קבאנה, באוטובוס ציבורי מספר<br>434 מלא באנשים, כנופיית שודדים הצמידה לי אקדח לתוך הראש. זו<br>היתה הפעם הראשונה אך בהחלט לא האחרונה שפגשתי את המוות<br>ממרחק כזה. השארו עמי.</p><p>4. בבוליביה, במכרות הכסף של פוטוסי, בגובה 4000 מטר מעל<br>פני הים ובעומק של כמה עשרות מטרים מתחת לפני הקרקע,<br>צינור אוויר בלחץ גבוה שתכלס מאפשר לכורים לנשום, התפוצץ לנו<br>מול העיניים והעיף אותנו קיבינימט. אלמלא המדריך שתפס ומשך<br>אותי בשנייה האחרונה, קרונית ברזל עמוסה עפר במשקל של שני<br>טון היתה דורסת אותי למוות, לא משאירה ממני זכר.</p><p>5. בצפון פרו, 3000 מטר מעל פני הים, קרוב לעיר הוואראז,<br>באתר טיפוס מצוקי קרח, המדריך המקומי שעלה ללא כבלי אבטחה<br>החליק ונפל ממצוק בגובה 30 מטר. כמו שק תפוחי אדמה, בום,<br>התפוצץ על השלג הדחוס למטה. במשך 3 שעות חילצנו אותו<br>בשלג עמוק על אלונקה מאולתרת מקרשים שמצאנו. הסיוט האמיתי<br>התחיל רק כשהגענו למגרש החנייה וגילינו שהאוטובוס שלנו הבריז<br>ואנחנו האחרונים באתר. חושך, מינוס 10 מעלות, הנעליים, הבגדים,<br>הפליזים – הכל רטוב ספוג, ובאותם ימים אין טלפונים סלולריים.<br>בנס יצאנו משם בחיים.</p><p>6. אכלתי קוף. גם אני עדיין מתקשה להאמין ואפילו לכתוב את<br>זה, אבל אכלתי קוף. בכפר מבודד בג\'ונגל, 5 ימים של שיט<br>בערוצי הנחל הנידחים של האמזונס. אני לא יודע איזה קוף זה<br>היה, אבל לפי גודל כף היד שלו, זה היה וואחד קוף. זה<br>נשמע נורא, אני יודע. נורא נורא נורא! אבל נקלעתי לסיטואציה,<br>וכבר סיכמנו שהייתי סתום, וראש השבט, שנראה כמו קוף בעצמו,<br>ושלא מסוגל אפילו להבין מה ההבדל בין קוף, תרנגולת, כבשה,<br>פרה, לטאה, או כל יצור חי אחר שאפשר לאכול, היה מאוד<br>נעלב אם הייתי מסרב. בלית ברירה נתתי ביס, בזרוע, בין המרפק<br>לכתף. ספויילר: אם תהיתם לרגע מה הטעם – זה נורא. נורא<br>נורא נורא! לא שניסיתי, אבל זה ממש כמו לאכול בן אדם.<br>נורא! אל תנסו את זה. לא בבית ולא בשום מקום אחר. נורא.</p><p>***ספויילר קטן נוסף למגזר הטבעוני הזועם. כמו שאומרים למרוקאים דבר<br>ראשון על הבוקר, קודם כל תרגעו. אחרי שתקראו הסיפור במלואו<br>וסיפורים נוספים בספר תבינו שהכל טוב ולא סתם פרסמתי את<br>הסיפור הזה. המסר שעובר מאוד ברור. נרגעתם? יופי.</p><p>7. בקוסטה ריקה הכרתי וטיילתי שבוע עם היקוקומורי. אם מעולם<br>לא שמעתם את המילה הזו, אל תרגישו לא בנוח. היקוקמורי<br>זו תופעה שיחודית רק ליפן, ובשנים האחרונות גם במדינות מפותחות<br>אחרות כמו ניו זילנד ושוודיה. מדובר בנערים לרוב, נערות פחות,<br>שלא עומדים בלחץ ובאווירה התחרותית היפנית הנוקשה, ובמקום להתאבד<br>פשוט מסתגרים בחדר שלהם ולא יוצאים ממנו לתקופה ארוכה. זה<br>גם יכול להגיע לחמש, שש, שבע שנים. כל היום משחקים<br>בסוני פליי סטיישן וגולשים באינטרנט ומתחפרים עוד ועוד בתוך עצמם.<br>ההורים שלהם מעבירים להם אוכל מתחת לדלת. אין שום תקשורת<br>עם בני הבית. ביום הם ישנים ובלילה הם ערים. בידוד<br>מוחלט מהעולם החיצון. במקום לשבור את הדלת, לתת לילד שתי<br>סטירות ולהטיס אותו לקבל עזרה נפשית, ההורים היפנים מתביישים<br>ומסתירים את העניין. בתרבות היפנית הורים לבן היקוקומורי יעדיפו<br>לשתף פעולה עם הנער ולהניח לו לנפשו עד שיסכים לצאת<br>מרצונו. רק שהשכנים לא ידעו או יגלו. בן היקוקומורי זו<br>בושה גדולה ביפן. נשמע לכם הזייה? בואו קבלו את הזייה<br>האמיתית: נכון לשנת 1999, השנה שבה פגשתי את איסאו ה-"אקס-היקוקומורי"<br>שהספיק לשבת בחדר "רק" שלוש שנים לפני שיצא לדרכים,<br>יש ביפן מעל למיליון היקוקומורים. קולטים את המספר? מיליון!!!! ומה<br>קורה היום עם איסאו? או 2#.</p><p>8. חודשיים אחרי שחזרתי מדרום אמריקה, אבא שלי נהרג בתאונת<br>דרכים מחרידה. הוא ועוד 16 איש. טיול של החברה להגנת<br>הטבע, אוטובוס ה"פנויים פנויות" שנפל לתהום סמוך לצומת גולני.<br>באותו ערב שבו נסענו לפורייה לזיהוי גופה, הייתי עד לתאונת<br>דרכים אחרת. חבורת נערים שיכורים שנהגו בפראות, איבדו שליטה<br>והתהפכו ב-200קמ"ש. הדם של אחד הנערים כיסה אותי עד<br>הכתפיים בזמן שטיפלתי בו על הכביש. עד היום אני לא יודע<br>אם הוא חי או מת.</p><p>9. דווקא בוואראנסי, דווקא ב"עיר המתים" ההודית המטלטלת, המחרידה<br>והמדהימה הזו, השלמתי עם המוות של אבא שלי. השלמתי עם<br>קונספט המוות בכלל. אני יודע שזה עשוי להישמע פה מוזר,<br>אבל רק מאותו רגע התחלתי לחיות באמת.</p><p>10. כן, לענת לקח קצת יותר זמן להתאהב בי חזרה, אבל<br>שנה אחרי, בטיול שלנו להודו, ממש אחרי וואראנסי, כשהגענו לפושקר,<br>לאגם הקדוש, בחוף הסאן סט, בזמן השקיעה, זאת היתה היא<br>ששלפה טבעת והציעה לי נישואין. לקח לי הרבה זמן להאמין<br>למראה עיני ולמשמע אזני, אבל בסוף, כשהשתכנעתי שזה אמיתי,<br>אמרתי כן. אגב, שלא יעלו לכם פה רעיונות לראש, למרות<br>הסוף הטוב, זה עדיין רעיון ממש ממש גרוע להקיא על<br>בחורה שמוצאת חן בעיניכם.</p><p>11. נכון, אמרתי 10 דברים, אבל אם הגעתם עד לפה זה<br>אומר שמה שקראתם מעניין אתכם ושלא תתנגדו לקרוא עוד.<br>אתם עדיין פה? נפלא. 10 הדברים האלה שזה עתה קראתם,<br>הם למעשה 10 הסיפורים הראשונים (מתוך 46) בספר האחרון<br>שלי - #וכתבת. 46 סיפורים אמיתיים מחיי. 252 עמודים שיטוסו<br>לכם במהירות האור! אם אהבתם מה שקראתם פה, נראה לי<br>שתאהבו גם את הספר אתם כבר יודעים היכן ניתן להשיג<br>אותו 😉 תודה שקראתם אייל עמית</p>',
			),
		),

		/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 04 · שורות 170–197 · פרוזה בלי split */
		array(
			'part' => 'prose',
			'args' => array(
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 04 · H2 */
				'title' => 'על הספר',
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 04 */
				'body'  => '<p>אייל עמית הוא סופר, בלוגר, מוציא לאור ומספר סיפורים.<br>אבל זה לא הכל.</p><p>במקביל לכתיבה, אייל הוא גם מורה ומטפל לנשימה באמצעות דיג\'רידו,<br>ובמשך למעלה משני עשורים חוקר את הקשר בין נשימה, גוף ותודעה.</p><p>"וכתבת" הוא הספר השלישי שלו, והוא מביא איתו קול ישיר,<br>אנושי וכנה, שמלווה את הכתיבה שלו לאורך השנים.</p><p>הספר מבוסס על סיפורים אמיתיים לגמרי מחייו,<br>ונכתב מתוך חוויות אמיתיות ומתוך רצון לגעת בדברים כמו שהם.</p><p>אל הספר הזה לוקטו הפוסטים החזקים ביותר מתוך הבלוג שאייל כתב במשך שנתיים.<br>הסיפורים המשמעותיים ביותר נאספו, נערכו ואוגדו לכדי ספר אחד.</p><p>הסיפורים כתובים בז\'אנר הספוקן סטוריז -<br>הקורא מרגיש כאילו מישהו מדבר איתו, בגובה העיניים, באופן ישיר וחי.</p><p>מתוך אותם סיפורים גם נולד מופע הסיפורים<br>“עכשיו!!! תופעת יחיד”<br>שאיתו הופיע אייל על הבמה במשך כ־8 שנים.</p><p>הספר מלא תובנות, חוכמת חיים וניסיון חיים.<br>מתחת לסיפורים עצמם נמצאת הבנה עמוקה יותר -<br>שגם מתוך משברים אפשר לגדול, לצמוח וללמוד.</p><p>זהו ספר שנשאר עם הקורא,<br>וכל מי שקורא אותו - לוקח ממנו משהו.</p>',
			),
		),

		/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 05 · שורות 203–205 טקסט בלבד · מדיה VKT-02 לא בבנייה, בלי סלוט ריק */
		array(
			'part' => 'gallery',
			'args' => array(
				'title' => 'גלריה',
				'items' => array(
					array( 'image' => 'assets/images/chapters/vekatavta/veka-04.jpg', 'alt' => 'הדמיית כריכת הספר וכתבת על רקע רכב' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-05.jpg', 'alt' => 'פריסת כריכת הספר וכתבת עם רשימת סיפורים בגב הספר' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-06.jpg', 'alt' => 'כתבת עיתון על אייל עמית עם תמונתו בתנוחת הופעה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-07.jpg', 'alt' => 'כתבת עיתון עם תמונת השחקן שי אביבי בישיבה בחוץ' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-09.jpg', 'alt' => 'פינת נגינה ביתית עם דיג\'רידו ופסנתר חשמלי' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-10.jpg', 'alt' => 'דלפק צ\'ק-אין בשדה תעופה עם דרכונים, כרטיסי טיסה והדמיית כריכת הספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-100.jpg', 'alt' => 'גבר יושב מול מתלה דיג\'רידואים עם מחשב נייד ועליו מדבקת וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-101.jpg', 'alt' => 'קובץ הדפסה של כריכת הספר וכתבת עם גב וכריכה אחורית' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-11.jpg', 'alt' => 'תמרור עצור עם סמל כף יד ומדבקת ונשמת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-12.jpg', 'alt' => 'גבר עם שיער מקורזל יושב בחוץ עם מחשב נייד ועליו מדבקת וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-13.jpg', 'alt' => 'שני גברים מחייכים בשוק, מחזיקים מדבקות ונשמת וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-14.jpg', 'alt' => 'מדבקות בעברית וכרטיס עם תמונת הספר וכתבת על גזע עץ בין צמחים' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-15.jpg', 'alt' => 'ארבעה אנשים מחייכים בשוק, מחזיקים מדבקות עם כיתוב בעברית' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-16.jpg', 'alt' => 'גבר ואישה מחייכים מחזיקים לוח עץ עם מדבקת וחייכת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-17.jpg', 'alt' => 'אישה מצמידה מדבקת ונשמת לשפתיה מול קיר במבוק, לצידה אישה עם מדבקה על ראשה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-18.jpg', 'alt' => 'רחוב עם דוכני שוק, אופניים ומדבקה על עמוד חסימה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-20.jpg', 'alt' => 'עלי גפן על קרש חיתוך ומדבקה עם הכיתוב וגלגלת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-21.jpg', 'alt' => 'גבר מקבל תספורת במספרה וקורא את הספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-22.jpg', 'alt' => 'רכב עם מדבקת וסלחת ליד הפנס האחורי' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-23.jpg', 'alt' => 'שמשה אחורית של רכב עם מדבקת וצחקת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-24.jpg', 'alt' => 'שלוש נשים מחייכות בבר, מחזיקות מדבקות עם כיתוב בעברית' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-25.jpg', 'alt' => 'ארבעה אנשים צוחקים באוהל בערב, אחד מחזיק תמונת כריכת הספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-26.jpg', 'alt' => 'גבר מחייך בראי קטן ברכב, לצידו מדבקת וחייכת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-27.jpg', 'alt' => 'שלושה אנשים מחייכים בסלפי מתחת לעץ, אישה מחזיקה מחברות והספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-28.jpg', 'alt' => 'הספר וכתבת מונח על שולחן עץ, לצד כלי אוכל ופסלון תרנגול' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-29.jpg', 'alt' => 'שתי צעירות ליד עמדת בלו באס בפרדס חנה, עם פתקי משפטים מהספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-30.jpg', 'alt' => 'שלט עם משפטים מהספר וכתבת תלוי על קיר בשירותים' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-31.jpg', 'alt' => 'מכונות ממתקים ופתק עם הכיתוב ואכלת, בכניסה לחנות' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-32.jpg', 'alt' => 'תלמידי בית ספר בבלייזר ועניבת פסים, אחד מהם מחזיק כרטיס עם הכיתוב וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-33.jpg', 'alt' => 'כיתוב ביד באבק על השמשה האחורית של טנדר לבן, בשטח חקלאי' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-34.jpg', 'alt' => 'חלקו האחורי של רכב מסחרי לבן מכוסה מדבקות עם משפטים מהספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-35.jpg', 'alt' => 'ברמן מחייך ומצביע על מדבקת וניגנת מאחורי דלפק הבר' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-36.jpg', 'alt' => 'אישה ונערה מצטלמות בסלפי ליד רכב עם מדבקת וצחקת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-37.jpg', 'alt' => 'גבר יושב בגינה ומנגן בדידג\'רידו, עם מדבקה דבוקה על כלי הנגינה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-38.jpg', 'alt' => 'אישה וגבר מחזיקים כל אחד פתק עם מילה מהספר וכתבת, בתוך בר' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-39.jpg', 'alt' => 'אייל עמית מחזיק פתק עם משפט מהספר וכתבת, בערב חברתי בחוץ' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-40.jpg', 'alt' => 'ארבע נשים יושבות בערב חוץ, כל אחת מחזיקה פתק עם מילה מהספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-41.jpg', 'alt' => 'תינוק זוחל על רצפת אריחים, עם פתק מחובר לגב' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-42.jpg', 'alt' => 'שלושה גברים מחייכים בערב חוץ, מחזיקים פתקים עם מילים מהספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-43.jpg', 'alt' => 'אישה צוחקת ומחזיקה פתק עם המילה וצחקת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-44.jpg', 'alt' => 'גבר מחזיק כוס שתייה ופתק עם המילה ונשמת, בערב בחוץ' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-45.jpg', 'alt' => 'שתי נשים מחזיקות פתקי מילים מהספר וכתבת, בערב באירוע עם תאורה צבעונית' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-46.jpg', 'alt' => 'שלושה גברים מחייכים בערב חוץ, מחזיקים פתקים עם משפטים מהספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-47.jpg', 'alt' => 'שני צעירים וצעירה מחזיקים פתקי מילים סמוך לפניהם, בערב בבית קפה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-48.jpg', 'alt' => 'תקליטן עם כובע ואוזניות עומד ליד מחשב נייד עם מדבקת וניגנת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-49.jpg', 'alt' => 'שני גברים ושתי נשים עומדים בערב חוץ, כל אחד מחזיק פתק עם מילה מהספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-50.jpg', 'alt' => 'נערה ושתי נשים מחייכות בערב חוץ, מחזיקות פתקי מילים מהספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-51.jpg', 'alt' => 'נשים מחזיקות פתקי מילים מהספר וכתבת סמוך לפניהן, בערב בין אנשים' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-52.jpg', 'alt' => 'יד מחזיקה פתק עם הכיתוב וכתבת, אירוע חוצות בלילה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-53.jpg', 'alt' => 'גבר מנשק אישה על הלחי, היא מחזיקה מכשיר עם מדבקה בעברית' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-54.jpg' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-55.jpg', 'alt' => 'שתי נשים מחייכות מחזיקות פתקי מילים, ליד דלת עץ מעוטרת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-56.jpg', 'alt' => 'תקריב יד חותמת בעט על ספר, לצד ערימת ספרים' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-57.jpg', 'alt' => 'גבר רכון מעל ערימות ספרים על שולחן, בתוך אוהל בלילה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-58.jpg', 'alt' => 'שישה אנשים מחייכים מחזיקים פתקי מילים, בפאב עם תמונות דיוקן על הקיר' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-59.jpg', 'alt' => 'מבט מלמעלה על ידיים ממיינות פתקי מילים על שולחן עגול' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-60.jpg', 'alt' => 'גבר מחייך מחזיק פתק ליד ראשו, קהל רוקד תחת אוהל פתוח' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-61.jpg', 'alt' => 'קומקום אמייל כחול וכוס תה, לצד כיס טבק גלגול עם פתק' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-62.jpg', 'alt' => 'גבר ושתי נשים מחייכים בסלפי מתחת למטריה אדומה בלילה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-63.jpg', 'alt' => 'גבר קירח מחייך מחזיק פתק מעל מצחו, פאב הומה ברקע' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-64.jpg', 'alt' => 'גיטרה על מעמד בפינת חדר, פתק מונח לצדה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-65.jpg', 'alt' => 'שתי נשים וגבר יושבים בחוץ בלילה מול גדר קנים, מחזיקים פתקים' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-66.jpg', 'alt' => 'שלושה גברים מחייכים יושבים בחוץ בלילה, מחזיקים פתקי מילים' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-67.jpg', 'alt' => 'גבר מחייך עם אגודל למעלה מחזיק פתק, בחוץ בלילה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-68.jpg', 'alt' => 'גבר ואישה מחזיקים יחד צרור פתקי מילים, בחוץ בלילה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-69.jpg' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-70.jpg', 'alt' => 'גבר מפעיל ציוד תקליטן בחוץ בלילה, ירח מלא בשמיים' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-71.jpg', 'alt' => 'שתי נשים מחייכות יושבות על שטיח צבעוני, מסיבת חוץ בלילה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-72.jpg', 'alt' => 'שני גברים בסלפי צמוד, אחד מהם מחזיק את הספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-73.jpg', 'alt' => 'גבר ושלוש נשים מחייכים במסיבת חוץ בערב, מחזיקים כוסות שתייה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-74.jpg', 'alt' => 'גבר ואישה מחייכים בסלפי במסיבת חוץ, עמדת תקליטן ברקע' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-75.jpg', 'alt' => 'שולחן עם ערימות ספרים וחבילות פתקי מילים, שלט מחיר בכתב יד' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-76.jpg' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-77.jpg', 'alt' => 'שלושה גברים מצלמים סלפי בחוץ ומחזיקים כרטיסי מילים מהספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-78.jpg', 'alt' => 'חצר בלילה עם שולחן, כיסאות ושלט והקשבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-79.jpg', 'alt' => 'תקריב מטושטש של דף זכויות היוצרים בספר וכתבת, ברקע דמויות במטבח' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-80.jpg', 'alt' => 'לוח מודעות עם כרזות אירועים ומודעת הספר וכתבת, ומתחתיו שולחן עם כלים חד-פעמיים' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-81.jpg', 'alt' => 'כרטיסי פרסומת לספר וכתבת ושלט מחירון על כיסא קש, לצד ספל אמייל' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-82.jpg', 'alt' => 'כרטיסי מילים מהספר וכתבת ועלי כותרת סגולים מפוזרים על שולחן עץ' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-83.jpg', 'alt' => 'קערת דובדבנים טריים לצד עותק הספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-84.jpg', 'alt' => 'כובע קש, תיק פרחוני והספר וכתבת על כיסאות אדומים באולם' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-86.jpg', 'alt' => 'לוחית רישוי של רכב ניסאן עם מדבקת וחלמת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-87.jpg', 'alt' => 'כלב פרוותי עם פתק על הגב עומד ליד ארגזי ירקות בשוק' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-88.jpg', 'alt' => 'עותק הספר וכתבת מונח על מעקה עץ מול נוף כפרי פתוח' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-89.jpg', 'alt' => 'כרטיסי מילים מהספר וכתבת סביב עותק הספר על שמיכה' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-90.jpg' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-91.jpg', 'alt' => 'יד מחזיקה את כריכת הספר וכתבת מול רכב שטח כסוף בדרך כפרית' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-92.jpg', 'alt' => 'דלת זכוכית עם מדבקת פרפר ושלט וצחקת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-93.jpg', 'alt' => 'קופסת עור פתוחה עם סיגריה מגולגלת, נייר גלגול ומדבקת וגלגלת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-94.jpg' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-95.jpg', 'alt' => 'מדבקת וכתבת על מעקה עץ מול חוף ים טרופי' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-96.jpg', 'alt' => 'מכסה מחשב נייד עם מדבקות ציוד תקליטנות ומדבקת מילה מהספר וכתבת' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-97.jpg', 'alt' => 'אייל עמית מדבר בטלפון ליד מסך מחשב, מדבקת והקשבת על ארגז עץ' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-98.jpg', 'alt' => 'מדבקת והודעת ומדבקת חיה מצוירת על שמשה אחורית של רכב' ),
					array( 'image' => 'assets/images/chapters/vekatavta/veka-99.jpg' ),
				),
			),
		),

		/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 06 · שורות 211–220 · מודפסת בלי href · דיגיטלית מנדלה */
		array(
			'part' => 'prose',
			'args' => array(
				/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 06 · H2 */
				'title' => 'רכישת הספר',
				/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 06 */
				'body'  => '<p>"וכתבת" זמין לרכישה בשתי גרסאות:</p><p>גרסה מודפסת<br>(לפרטים והזמנה - צרו קשר)</p><p>גרסה דיגיטלית:<br><a class="tlink" href="https://www.mendele.co.il/product/vekatavta/" target="_blank" rel="noopener noreferrer">לרכישת הספר בגרסה דיגיטלית</a></p><p>ספר של 252 עמודים,<br>46 סיפורים אמיתיים מחייו של אייל עמית.</p>',
			),
		),

		/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 07 · שורות 226–240 · רשימה כתובה, בלי reveals/H3 */
		array(
			'part' => 'prose',
			'args' => array(
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 07 · H2 */
				'title' => 'למי הספר מתאים',
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 07 */
				'body'  => '<p>הספר הזה מתאים למי שאוהב סיפורים אמיתיים.</p><p>למי שמחפש משהו לקרוא שירגיש קרוב, אנושי, לא מתאמץ.</p><p>למי שמתחבר לכתיבה בגובה העיניים,<br>ולקול שמדבר ישירות, בלי פילטרים.</p><p>למי שעובר תקופה של שינוי,<br>או מחפש פרספקטיבה אחרת על החיים.</p><p>זה גם ספר מצוין לטיסות ולחופשות,<br>כי כל סיפור עומד בפני עצמו ואפשר לקרוא בקצב שלך.</p><p>ולמי שפשוט רוצה לפתוח ספר,<br>ולמצוא את עצמו בין השורות.</p>',
			),
		),

		/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 08 · שורות 246–266 */
		array(
			'part' => 'prose',
			'args' => array(
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 08 · H2 */
				'title' => 'על אייל עמית',
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 08 */
				'body'  => '<p>אייל עמית הוא מטפל ומורה לנשימה באמצעות דיג\'רידו<br>ומפתח שיטת cbDIDG</p><p><a class="tlink" href="/eyal-amit/">לעמוד אייל עמית</a></p><p>אייל עמית כותב מתוך החיים.</p><p>לא מתוך תיאוריה, לא מתוך רעיונות מופשטים,<br>אלא מתוך חוויות אמיתיות שהוא עבר בעצמו.</p><p>הכתיבה שלו התחילה מתוך רגע אחד מאוד קונקרטי.<br>שוד בברזיל, אקדח שמוצמד לראש, טראומה של ממש.</p><p>שלושה ימים הוא לא יצא מהחדר במלון.<br>היה לבד, ובלי דרך אחרת לפרוק את מה שקרה, התחיל לכתוב.</p><p>זה היה סוג של תרפיה.<br>כך נולד הסיפור הראשון - הסיפור על השוד שפותח את הספר.</p><p>אחרי הסיפור הזה נולדו עוד ועוד סיפורים,<br>שנכתבו לאורך השנים והפכו בסופו של דבר לספרים, בלוג עם עוקבים רבים ולמופע סיפורים מצליח שרץ קרוב לשמונה שנים בבית ציוני אמריקה, בצוותא ובקאמרי.</p><p>"וכתבת" - מלשון "ואהבת".<br>כתיבה שמגיעה מתוך החיים, בגובה העיניים ונשארת קרובה אליהם.</p>',
			),
		),

		/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 09 · שורות 272–273 · שתי השורות, בלי H2 */
		array(
			'part' => 'prose',
			'args' => array(
				/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 09 */
				'body'  => '<p>אם הגעת עד כאן,<br>כנראה שזה לא סתם.</p>',
			),
		),

		/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 09 שורה 275 · כפתור מנדלה */
		array(
			'part' => 'cta',
			'args' => array(
				/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 09 שורה 275 */
				'cta_label' => 'לרכישת הספר',
				/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 09 שורה 275 */
				'cta_url'   => 'https://www.mendele.co.il/product/vekatavta/',
				/* S006 R1-19 VKT-04 · DEV NOTES: קישור חיצוני בלשונית חדשה */
				'cta_slug'  => 'vekatavta',
			),
		),

		/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 שורות 281–300 · faq-inline */
		array(
			'part' => 'faq-inline',
			'args' => array(
				/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
				'title' => 'שאלות ותשובות',
				'items' => array(
					array(
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'q' => 'האם צריך לקרוא את הספר ברצף?',
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'a' => '<p>לא. הספר בנוי מסיפורים קצרים, וכל סיפור עומד בפני עצמו. אפשר לפתוח בכל עמוד.</p>',
					),
					array(
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'q' => 'האם כל הסיפורים אמיתיים?',
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'a' => '<p>כן. כל הסיפורים מבוססים על אירועים אמיתיים מחייו של אייל.</p>',
					),
					array(
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'q' => 'כמה סיפורים יש בספר?',
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'a' => '<p>46 סיפורים קצרים.</p>',
					),
					array(
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'q' => 'כמה עמודים יש בספר?',
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'a' => '<p>252 עמודים.</p>',
					),
					array(
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'q' => 'האם הספר מתאים גם לקריאה קצרה?',
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'a' => '<p>כן. בגלל המבנה שלו, הוא מתאים מאוד לקריאה בטיסות, חופשות או בין רגעים במהלך היום.</p>',
					),
					array(
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'q' => 'מה זה ספוקן סטוריז?',
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'a' => '<p>זה סגנון כתיבה שבו הסיפור מרגיש כאילו הוא מסופר בעל פה. הקריאה זורמת, ישירה ואישית.</p>',
					),
					array(
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'q' => 'יש גם תוכן נוסף מעבר לספר?',
						/* S006 R1-19 VKT-05 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 10 */
						'a' => '<p>כן. בסיום כל סיפור יש קוד QR שמוביל להמשך, וידאו או תוכן נוסף.</p>',
					),
				),
			),
		),

		/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 11 · שורה 306 בלבד */
		array(
			'part' => 'prose',
			'args' => array(
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 11 · H2 */
				'title' => 'כתבות מהעיתונות',
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 11 */
				'body'  => '<p>כתבות וראיונות על אייל עמית והספר (יתווספו בהמשך).</p>',
			),
		),

		/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 12 · שורות 312–316 · בלי H2 */
		array(
			'part' => 'prose',
			'args' => array(
				/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 12 */
				'body'  => '<p>אם הגעת עד כאן,<br>כנראה שמשהו מתוך הסיפורים כבר נגע בך.</p><p>"וכתבת" הוא לא ספר שקוראים ושוכחים,<br>אלא כזה שנשאר איתך גם אחרי שסוגרים אותו.</p>',
			),
		),

		/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 12 שורה 318 · כפתור מנדלה */
		array(
			'part' => 'cta',
			'args' => array(
				/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 12 שורה 318 */
				'cta_label' => 'לרכישת הספר',
				/* S006 R1-19 VKT-04 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 12 שורה 318 */
				'cta_url'   => 'https://www.mendele.co.il/product/vekatavta/',
				/* S006 R1-19 VKT-04 · DEV NOTES: קישור חיצוני בלשונית חדשה */
				'cta_slug'  => 'vekatavta',
			),
		),

		/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 14 · שורות 347–354 · בלי קופסת מדיה */
		array(
			'part' => 'prose',
			'args' => array(
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 14 · H2 */
				'title' => 'עוד רגעים מהדרך',
				/* S006 R1-19 VKT-03 · מקור: content 13.8.26/וכתבת/vekatavta.md · SECTION 14 */
				'body'  => '<p>הסיפורים לא נעצרו עם הספר.</p><p>גם אחרי ש"וכתבת" יצא לאור,<br>הכתיבה ממשיכה ללוות את הדרך.</p><p>רגעים חדשים, תובנות, סיפורים קטנים מהחיים -<br>חלקם ממשיכים להיכתב,<br>חלקם כבר מחכים להיאסף.</p>',
			),
		),

	),
);
