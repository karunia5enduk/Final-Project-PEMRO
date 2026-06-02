CREATE DATABASE IF NOT EXISTS electroevent_hub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE electroevent_hub;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS gallery;
DROP TABLE IF EXISTS news;
DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  nim VARCHAR(30) DEFAULT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  study_program ENUM('Teknik Elektro','Teknik Informatika') DEFAULT NULL,
  phone VARCHAR(30) DEFAULT NULL,
  role ENUM('admin','member') NOT NULL DEFAULT 'member',
  photo VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  title VARCHAR(180) NOT NULL,
  slug VARCHAR(200) NOT NULL UNIQUE,
  description TEXT NOT NULL,
  study_program ENUM('Teknik Elektro','Teknik Informatika') NOT NULL,
  event_type ENUM('offline','online','hybrid') NOT NULL DEFAULT 'offline',
  event_date DATE NOT NULL,
  event_time TIME NOT NULL,
  location VARCHAR(180) NOT NULL,
  quota INT NOT NULL DEFAULT 50,
  poster VARCHAR(255) DEFAULT NULL,
  status ENUM('draft','open','closed','done') NOT NULL DEFAULT 'open',
  created_by INT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_events_category FOREIGN KEY (category_id) REFERENCES categories(id) ON UPDATE CASCADE,
  CONSTRAINT fk_events_user FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE registrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  event_id INT NOT NULL,
  status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'approved',
  notes VARCHAR(255) DEFAULT NULL,
  registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_user_event (user_id, event_id),
  CONSTRAINT fk_reg_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_reg_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE news (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  slug VARCHAR(200) NOT NULL UNIQUE,
  content TEXT NOT NULL,
  image VARCHAR(255) DEFAULT NULL,
  author_id INT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_news_author FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT DEFAULT NULL,
  title VARCHAR(160) NOT NULL,
  image VARCHAR(255) NOT NULL,
  caption VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_gallery_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO users (name,nim,email,password,study_program,role) VALUES
('Administrator Jurusan','0000000000','admin@electroevent.test','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi','Teknik Informatika','admin'),
('Budi Santoso','2022310045','member@electroevent.test','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi','Teknik Informatika','member');

INSERT INTO categories (name,description) VALUES
('Seminar','Kegiatan seminar akademik dan profesional'),
('Workshop','Pelatihan praktis berbasis project'),
('Webinar','Kegiatan online untuk kuliah umum dan sharing'),
('Kompetisi','Lomba akademik dan non-akademik mahasiswa'),
('Organisasi','Kegiatan HMJ, komunitas, dan unit mahasiswa');

INSERT INTO events (category_id,title,slug,description,study_program,event_type,event_date,event_time,location,quota,status,created_by) VALUES
(1,'Seminar Nasional IoT dan Smart City 2025','seminar-nasional-iot-smart-city-2025','Seminar nasional yang membahas penerapan Internet of Things pada smart city, industri, dan kampus cerdas.','Teknik Elektro','offline','2025-02-12','08:30:00','Aula Jurusan Elektro',150,'open',1),
(2,'Workshop Machine Learning dengan Python','workshop-machine-learning-python','Workshop hands-on untuk memahami dasar machine learning, dataset, training model, dan evaluasi model.','Teknik Informatika','offline','2025-02-20','09:00:00','Laboratorium Komputer 2',40,'open',1),
(3,'Webinar Cyber Security Awareness','webinar-cyber-security-awareness','Webinar pengenalan keamanan siber, etika digital, dan perlindungan data pribadi mahasiswa.','Teknik Informatika','online','2025-03-01','13:00:00','Zoom Meeting',200,'open',1),
(4,'Kompetisi Robotika Line Follower','kompetisi-robotika-line-follower','Kompetisi robot line follower untuk mahasiswa Jurusan Elektro dengan sistem penjurian profesional.','Teknik Elektro','offline','2025-03-15','08:00:00','Hall Gedung Elektro',60,'open',1);

INSERT INTO registrations (user_id,event_id,status) VALUES (2,1,'approved'),(2,3,'approved');

INSERT INTO news (title,slug,content,author_id) VALUES
('Jurusan Elektro Membuka Rangkaian Event Akademik 2025','jurusan-elektro-event-akademik-2025','Jurusan Elektro membuka rangkaian kegiatan akademik tahun 2025 yang melibatkan Program Studi Teknik Elektro dan Teknik Informatika.',1),
('Pengumuman Jadwal Workshop Semester Genap','pengumuman-jadwal-workshop-semester-genap','Mahasiswa dapat mengikuti workshop sesuai minat dan program studi. Pendaftaran dilakukan melalui ElectroEvent Hub.',1);

INSERT INTO gallery (event_id,title,image,caption) VALUES
(1,'Dokumentasi Seminar IoT','assets/uploads/sample-seminar.jpg','Suasana kegiatan seminar di aula jurusan'),
(2,'Workshop Machine Learning','assets/uploads/sample-workshop.jpg','Peserta praktik langsung di laboratorium');