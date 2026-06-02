<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();
$user = current_user();
$stmt = $pdo->prepare('SELECT r.*, e.title, e.event_date, e.location, c.name category_name FROM registrations r JOIN events e ON e.id=r.event_id JOIN categories c ON c.id=e.category_id WHERE r.user_id=? ORDER BY r.registered_at DESC');
$stmt->execute([$user['id']]);
$regs = $stmt->fetchAll();
$title='Member Dashboard'; require_once __DIR__ . '/../includes/header.php';
?>
<section class="section"><div class="container"><div class="section-head"><div><span class="eyebrow">Member</span><h2>Halo, <?= e($user['name']) ?></h2><p><?= e($user['study_program']) ?> - <?= e($user['nim']) ?></p></div><a class="btn btn-primary" href="profile.php">Edit Profil</a></div><div class="table-wrap"><table><thead><tr><th>Event</th><th>Kategori</th><th>Tanggal</th><th>Lokasi</th><th>Status</th></tr></thead><tbody><?php foreach($regs as $r): ?><tr><td><?= e($r['title']) ?></td><td><?= e($r['category_name']) ?></td><td><?= date('d M Y', strtotime($r['event_date'])) ?></td><td><?= e($r['location']) ?></td><td><span class="badge ok"><?= e($r['status']) ?></span></td></tr><?php endforeach; ?></tbody></table></div></div></section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>