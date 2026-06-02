# ElectroEvent Hub

Sistem Informasi Event Jurusan Elektro berbasis HTML5, CSS3 murni, Vanilla JavaScript, PHP Native, dan MySQL. Project ini tidak memakai Bootstrap, jQuery, Laravel, CodeIgniter, atau framework lain.

## Cara Menjalankan

1. Copy folder project ke `htdocs/electroevent-hub` jika memakai XAMPP.
2. Buat database dari file `database/electroevent_hub.sql` melalui phpMyAdmin atau MySQL CLI.
3. Sesuaikan koneksi database di `config/database.php`.
4. Buka `http://localhost/electroevent-hub/index.php`.

## Akun Demo

- Admin: `admin@electroevent.test` / `password`
- Member: `member@electroevent.test` / `password`

## Fitur

- Public: home, daftar event, detail event, berita, galeri, about team, login, register.
- Member: registrasi event, event saya, edit profil.
- Admin: dashboard statistik, CRUD event, kategori, berita, galeri, kelola peserta.
- Keamanan dasar: session login, proteksi admin, prepared statement PDO, password_hash/password_verify, validasi upload gambar.