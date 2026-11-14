<?php
require __DIR__ . '/../config.php';
try { $u = user_login(); } catch (PDOException $e) { $u = null; }
if (!$u) json_out(['ok' => false], 401);
json_out(['ok' => true, 'user' => user_publik($u)]);
