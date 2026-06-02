<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();
$user = current_user();
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name=trim($_POST['name']); $phone=trim($_POST['phone']); $study=$_POST['study_program'];
    $stmt=$pdo->prepare('UPDATE users SET name=?, phone=?, study_program=? WHERE id=?');
    $stmt->execute([$name,$phone,$study,$user['id']]);
    $_SESSION['user']['name']=$name; $_SESSION['user']['study_program']=$study; $_SESSION['flash_success']='Profil berhasil diperbarui.'; redirect('member/profile.php');
}
$stmt=$pdo->prepare('SELECT * FROM users WHERE id=?'); $stmt->execute([$user['id']]); $profile=$stmt->fetch();
$title='Edit Profil'; require_once __DIR__ . '/../includes/header.php';
?>
<section class="section"><form class="form-card" method="post"><span class="eyebrow">Profil</span><h1>Edit Profil</h1><div class="form-row"><label class="label">Nama</label><input class="input" name="name" value="<?= e($profile['name']) ?>" required></div><div class="form-row"><label class="label">Telepon</label><input class="input" name="phone" value="<?= e($profile['phone']) ?>"></div><div class="form-row"><label class="label">Program Studi</label><select name="study_program"><option <?= $profile['study_program']==='Teknik Elektro'?'selected':'' ?>>Teknik Elektro</option><option <?= $profile['study_program']==='Teknik Informatika'?'selected':'' ?>>Teknik Informatika</option></select></div><button class="btn btn-primary" style="width:100%">Simpan</button></form></section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>