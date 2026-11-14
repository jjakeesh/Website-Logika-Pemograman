<?php
require __DIR__ . '/../config.php';

$u = user_login();
if (!$u) json_out(['ok' => false, 'pesan' => 'Belum login.'], 401);
if (empty($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    json_out(['ok' => false, 'pesan' => 'File gagal diunggah.'], 400);
}

$f = $_FILES['foto'];
if ($f['size'] > 2 * 1024 * 1024) json_out(['ok' => false, 'pesan' => 'Ukuran foto maksimal 2 MB.'], 400);

$mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
$ext  = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'][$mime] ?? null;
if (!$ext) json_out(['ok' => false, 'pesan' => 'Format harus JPG, PNG, WEBP, atau GIF.'], 400);

$dir = __DIR__ . '/../uploads/';
if (!is_dir($dir)) mkdir($dir, 0775, true);

$nama = 'user' . $u['id'] . '_' . time() . '.' . $ext;
if (!move_uploaded_file($f['tmp_name'], $dir . $nama)) json_out(['ok' => false, 'pesan' => 'Gagal menyimpan file.'], 500);

// hapus foto lama
if ($u['foto'] && is_file(__DIR__ . '/../' . $u['foto'])) @unlink(__DIR__ . '/../' . $u['foto']);

$path = 'uploads/' . $nama;
db()->prepare('UPDATE users SET foto = ? WHERE id = ?')->execute([$path, $u['id']]);
json_out(['ok' => true, 'foto' => $path]);
