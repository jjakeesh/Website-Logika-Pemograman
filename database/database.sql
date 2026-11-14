-- Database untuk project LOGIKA PEMROGRAMAN - Login dan Biodata (Kelompok 3)
-- Cara import: phpMyAdmin > tab Import > pilih file ini > Go

CREATE DATABASE IF NOT EXISTS logika_login
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE logika_login;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama        VARCHAR(100) NOT NULL,
  email       VARCHAR(120) NOT NULL,
  password    VARCHAR(255) NOT NULL,          -- disimpan dalam bentuk hash (bcrypt)
  kelas       VARCHAR(30)  NOT NULL,
  mata_kuliah VARCHAR(100) NOT NULL,
  peran       VARCHAR(50)  NOT NULL DEFAULT 'Mahasiswa',
  foto        VARCHAR(255) DEFAULT NULL,      -- path file foto profil
  created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB;

-- Akun demo: email kelompok3@gmail.com | password 12345678
INSERT INTO users (nama, email, password, kelas, mata_kuliah, peran) VALUES
('Muzaqi Noval Ilham', 'kelompok3@gmail.com',
 '$2b$12$LyXZUgl6cNq5F9/UBeE3G.C95q3UF7dmLMSid7c6sVNM9Kl1ys06.',
 'J253P', 'Logika Pemrograman', 'Mahasiswa');
