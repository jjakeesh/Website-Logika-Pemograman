<?php
require __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_out(['ok' => false], 405);

$in    = json_decode(file_get_contents('php://input'), true) ?? [];
$email = strtolower(trim($in['email'] ?? ''));
$pass  = $in['password'] ?? '';

try {
    $st = db()->prepare('SELECT * FROM users WHERE email = ?');
    $st->execute([$email]);
    $u = $st->fetch();
} catch (PDOException $e) {
    json_out(['ok' => false, 'pesan' => 'Database belum siap. Pastikan MySQL aktif dan database sudah di-import.'], 500);
}

if (!$u || !password_verify($pass, $u['password'])) {
    json_out(['ok' => false, 'pesan' => 'Email atau kata sandi salah. Periksa lagi lalu coba masuk.'], 401);
}

session_regenerate_id(true);
$_SESSION['user_id'] = $u['id'];
json_out(['ok' => true, 'user' => user_publik($u)]);
