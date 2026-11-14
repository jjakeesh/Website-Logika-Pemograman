<?php
// Pengaturan koneksi database (default XAMPP: user root, password kosong)
const DB_HOST = 'localhost';
const DB_NAME = 'logika_login';
const DB_USER = 'root';
const DB_PASS = '';

session_start();

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER, DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    }
    return $pdo;
}

function json_out(array $data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

function user_publik(array $u): array {
    return [
        'nama'        => $u['nama'],
        'email'       => $u['email'],
        'kelas'       => $u['kelas'],
        'mata_kuliah' => $u['mata_kuliah'],
        'peran'       => $u['peran'],
        'foto'        => $u['foto'],
    ];
}

function user_login(): ?array {
    if (empty($_SESSION['user_id'])) return null;
    $st = db()->prepare('SELECT * FROM users WHERE id = ?');
    $st->execute([$_SESSION['user_id']]);
    return $st->fetch() ?: null;
}
