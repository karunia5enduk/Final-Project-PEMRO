<?php
require_once __DIR__ . '/../config/database.php'; require_once __DIR__ . '/../includes/functions.php'; require_admin();
if(isset($_GET['status'],$_GET['id'])){$stmt=$pdo->prepare('UPDATE registrations SET status=? WHERE id=?');$stmt->execute([$_GET['status'],(int)$_GET['id']]);redirect('admin/registrations.php');}
$rows=$pdo->query('SELECT r.*, u.name user_name, u.nim, u.study_program, e.title event_title FROM registrations r JOIN users u ON u.id=r.user_id JOIN events e ON e.id=r.event_id ORDER BY r.registered_at DESC')->fetchAll();
$title='Peserta Event'; require_once __DIR__ . '/_layout.php';
?>
<h1>Kelola Peserta Event</h1><div class="table-wrap"><table><thead><tr><th>Peserta</th><th>NIM</th><th>Prodi</th><th>Event</th><th>Status</th><th>Aksi</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?= e($r['user_name']) ?></td><td><?= e($r['nim']) ?></td><td><?= e($r['study_program']) ?></td><td><?= e($r['event_title']) ?></td><td><?= e($r['status']) ?></td><td><a href="?id=<?= $r['id'] ?>&status=approved">Approve</a> | <a href="?id=<?= $r['id'] ?>&status=rejected">Reject</a></td></tr><?php endforeach; ?></tbody></table></div>
<?php require_once __DIR__ . '/_footer.php'; ?>