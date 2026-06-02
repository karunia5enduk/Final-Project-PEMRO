<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$title='Dashboard Admin';
$stats=[
 'Event'=>$pdo->query('SELECT COUNT(*) FROM events')->fetchColumn(),
 'Kategori'=>$pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn(),
 'Peserta'=>$pdo->query('SELECT COUNT(*) FROM registrations')->fetchColumn(),
 'Berita'=>$pdo->query('SELECT COUNT(*) FROM news')->fetchColumn()
];
$latest=$pdo->query('SELECT e.*, c.name category_name FROM events e JOIN categories c ON c.id=e.category_id ORDER BY e.created_at DESC LIMIT 6')->fetchAll();
require_once __DIR__ . '/_layout.php';
?>
<h1>Dashboard Admin</h1><div class="stats"><?php foreach($stats as $k=>$v): ?><div class="stat"><p><?= e($k) ?></p><strong><?= (int)$v ?></strong></div><?php endforeach; ?></div><div class="table-wrap"><table><thead><tr><th>Event</th><th>Kategori</th><th>Prodi</th><th>Tanggal</th><th>Status</th></tr></thead><tbody><?php foreach($latest as $e): ?><tr><td><?= e($e['title']) ?></td><td><?= e($e['category_name']) ?></td><td><?= e($e['study_program']) ?></td><td><?= date('d M Y', strtotime($e['event_date'])) ?></td><td><?= e($e['status']) ?></td></tr><?php endforeach; ?></tbody></table></div>
<?php require_once __DIR__ . '/_footer.php'; ?>