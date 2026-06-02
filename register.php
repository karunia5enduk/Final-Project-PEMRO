<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? ''); $nim = trim($_POST['nim'] ?? ''); $email = trim($_POST['email'] ?? '');
    $study = $_POST['study_program'] ?? ''; $password = $_POST['password'] ?? '';
    if ($name && $nim && filter_var($email, FILTER_VALIDATE_EMAIL) && in_array($study, ['Teknik Elektro','Teknik Informatika']) && strlen($password) >= 6) {
        try {
            $stmt = $pdo->prepare('INSERT INTO users (name,nim,email,password,study_program,role) VALUES (?,?,?,?,?,"member")');
            $stmt->execute([$name,$nim,$email,password_hash($password, PASSWORD_DEFAULT),$study]);
            $_SESSION['flash_success'] = 'Registrasi berhasil. Silakan login.'; redirect('login.php');
        } catch (PDOException $e) { $_SESSION['flash_error'] = 'Email sudah digunakan.'; }
    } else { $_SESSION['flash_error'] = 'Lengkapi data dengan benar. Password minimal 6 karakter.'; }
}
$title = 'Register'; require_once __DIR__ . '/includes/header.php';
?>
<section class="section"><form class="form-card" method="post"><span class="eyebrow">Register</span><h1>Buat Akun Member</h1><div class="form-row"><label class="label">Nama</label><input class="input" name="name" required></div><div class="form-row"><label class="label">NIM</label><input class="input" name="nim" required></div><div class="form-row"><label class="label">Email</label><input class="input" type="email" name="email" required></div><div class="form-row"><label class="label">Prodi</label><select name="study_program" required><option value="">Pilih</option><option>Teknik Elektro</option><option>Teknik Informatika</option></select></div><div class="form-row"><label class="label">Password</label><input class="input" type="password" name="password" required minlength="6"></div><button class="btn btn-primary" style="width:100%">Register</button></form></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>