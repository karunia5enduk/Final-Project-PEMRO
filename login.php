<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email=? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id'=>$user['id'],'name'=>$user['name'],'email'=>$user['email'],'role'=>$user['role'],'study_program'=>$user['study_program'],'nim'=>$user['nim']];
        redirect($user['role'] === 'admin' ? 'admin/dashboard.php' : 'member/dashboard.php');
    }
    $_SESSION['flash_error'] = 'Email atau password salah.';
}
$title = 'Login'; require_once __DIR__ . '/includes/header.php';
?>
<section class="section"><form class="form-card" method="post"><span class="eyebrow">Login</span><h1>Masuk Akun</h1><div class="form-row"><label class="label">Email</label><input class="input" type="email" name="email" required></div><div class="form-row"><label class="label">Password</label><input class="input" type="password" name="password" required></div><button class="btn btn-primary" style="width:100%">Login</button><p class="meta">Demo: admin@electroevent.test / password</p></form></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>