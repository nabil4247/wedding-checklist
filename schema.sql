CREATE DATABASE IF NOT EXISTS wedding_checklist
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;
USE wedding_checklist;

CREATE TABLE IF NOT EXISTS checklists (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  detail TEXT,
  category ENUM('pra','pernikahan','pasca') NOT NULL,
  subevent ENUM('akad','resepsi') NOT NULL,
  phase ENUM('sebelum','saat','sesudah') NOT NULL,
  location ENUM('masjid','cafe') NOT NULL,
  due_date DATETIME NULL,
  assigned_to VARCHAR(100) NULL,
  priority ENUM('low','normal','high','urgent') NOT NULL DEFAULT 'normal',
  status ENUM('todo','in_progress','done') NOT NULL DEFAULT 'todo',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_category (category),
  KEY idx_subevent (subevent),
  KEY idx_phase (phase),
  KEY idx_status (status),
  KEY idx_due_date (due_date)
) ENGINE=InnoDB;

INSERT INTO checklists (title, detail, category, subevent, phase, location, due_date, assigned_to, priority, status)
VALUES
('Cek dokumen KUA', 'Pastikan berkas lengkap: N1-N4, fotokopi KTP, KK, pas foto.', 'pra', 'akad', 'sebelum', 'masjid', DATE_ADD(NOW(), INTERVAL 7 DAY), 'Sekretaris', 'high', 'todo'),
('Koordinasi MC islami', 'Brief rundown akad & resepsi, doa pembuka/penutup.', 'pra', 'resepsi', 'sebelum', 'cafe', DATE_ADD(NOW(), INTERVAL 5 DAY), 'MC', 'normal', 'todo'),
('Set sound system masjid', 'Cek mic imam, mic wali, recorder dokumentasi.', 'pernikahan', 'akad', 'sebelum', 'masjid', DATE_ADD(NOW(), INTERVAL 1 DAY), 'Teknis', 'urgent', 'in_progress'),
('Doa pembuka resepsi', 'Siapkan ustadz/MC untuk doa pembuka.', 'pernikahan', 'resepsi', 'saat', 'cafe', NULL, 'MC', 'normal', 'todo'),
('Bersih-bersih masjid', 'Rapikan kembali karpet & area akad.', 'pasca', 'akad', 'sesudah', 'masjid', NULL, 'Logistik', 'normal', 'todo');
