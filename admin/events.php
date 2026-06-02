<?php
require_once __DIR__ . '/../config/database.php'; require_once __DIR__ . '/../includes/functions.php'; require_admin();
if (isset($_GET['delete'])) { $stmt=$pdo->prepare('DELETE FROM events WHERE id=?'); $stmt->execute([(int)$_GET['delete']]); $_SESSION['flash_success']='Event dihapus.'; redirect('admin/events.php'); }
$events=$pdo->query('SELECT e.*, c.name category_name FROM events e JOIN categories c ON c.id=e.category_id ORDER BY e.event_date DESC')->fetchAll();
$title='Kelola Event'; require_once __DIR__ . '/_layout.php';
?>
<div class="section-head"><div><h1>Kelola Event</h1></div><a class="btn btn-primary" href="event-form.php">Tambah Event</a></div><div class="table-wrap"><table><thead><tr><th>Judul</th><th>Kategori</th><th>Prodi</th><th>Tanggal</th><th>Kuota</th><th>Status</th><th>Aksi</th></tr></thead><tbody><?php foreach($events as $e): ?><tr><td><?= e($e['title']) ?></td><td><?= e($e['category_name']) ?></td><td><?= e($e['study_program']) ?></td><td><?= date('d M Y', strtotime($e['event_date'])) ?></td><td><?= (int)$e['quota'] ?></td><td><?= e($e['status']) ?></td><td><a class="btn btn-muted" href="event-form.php?id=<?= $e['id'] ?>">Edit</a> <a class="btn btn-danger" onclick="return confirm('Hapus event?')" href="events.php?delete=<?= $e['id'] ?>">Hapus</a></td></tr><?php endforeach; ?></tbody></table></div>
<?php require_once __DIR__ . '/_footer.php'; ?>