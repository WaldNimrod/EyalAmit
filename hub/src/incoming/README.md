# incoming — שמירת JSON בשרת (אופציונלי)

**שלב א׳:** אייל מייצא JSON מהדפדפן ושולח במייל — אין חובה בשרת.

**שלב ב׳ (אופציונלי):** בשרת בלבד, צרו קובץ **`save-feedback.php`** עם התוכן למטה (לא לקומיט עם סודות).

1. צרו בשרת קובץ `.ea-hub-token` עם שורה אחת — טוקן אקראי (לא ב־Git).
2. הגדירו ב־PHP את הנתיב לתיקיית `incoming/` עם הרשאות כתיבה.
3. שלחו `POST` עם גוף JSON וכותרת `X-EA-HUB-TOKEN: <אותו טוקן>`.

**אזהרה:** endpoint אופציונלי חשוף לרשת אם אין HTTPS ואימות חזק; **אין** להסתמך על Basic Auth על כל ה־Hub לצורך חסימת צפייה — לפי נוהל Hub v1.1 צפיית התוכן ציבורית. אם מפעילים POST זה, השתמשו בטוקן סודי, HTTPS, והגבלת גישה ברמת שרת **ממוקדת** לנתיב ה־endpoint בלבד (לא לעמודי ה־HTML הציבוריים).

---

## ייחוס — תוכן `save-feedback.php` (שרת בלבד)

```php
<?php
/**
 * Eyal hub — optional server-side JSON save (deploy as save-feedback.php on server only).
 *
 * 1. Create .ea-hub-token (one line, secret) NEXT TO this file on the server — NOT in git
 * 2. Ensure incoming/ subdir is writable by PHP
 */
header('Content-Type: application/json; charset=utf-8');

$tokenFile = __DIR__ . '/.ea-hub-token';
$incomingDir = __DIR__ . '/incoming';
if (!is_readable($tokenFile)) {
    http_response_code(503);
    echo json_encode(['ok' => false, 'error' => 'token_not_configured']);
    exit;
}
$expected = trim(file_get_contents($tokenFile));
$got = $_SERVER['HTTP_X_EA_HUB_TOKEN'] ?? '';
if (!hash_equals($expected, $got)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'forbidden']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data) || ($data['exportType'] ?? '') !== 'eyal-feedback') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'invalid_body']);
    exit;
}

if (!is_dir($incomingDir)) {
    mkdir($incomingDir, 0750, true);
}
$name = 'feedback-' . gmdate('Y-m-d\THis\Z') . '-' . bin2hex(random_bytes(4)) . '.json';
$path = $incomingDir . '/' . $name;
if (file_put_contents($path, $raw) === false) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'write_failed']);
    exit;
}

echo json_encode(['ok' => true, 'saved' => $name]);
```
