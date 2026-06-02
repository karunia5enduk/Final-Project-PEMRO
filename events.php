<?php
require_once __DIR__ . '/config/database.php';
$title = 'Daftar Event - ElectroEvent Hub';
$categories = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
$stmt = $pdo->query('SELECT e.*, c.name category_name, (SELECT COUNT(*) FROM registrations r WHERE r.event_id=e.id AND r.status != "rejected") total_reg FROM events e JOIN categories c ON c.id=e.category_id WHERE e.status != "draft" ORDER BY e.event_date ASC');
$events = $stmt->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>
<section class="section"><div class="container">
  <div class="section-head"><div><span class="eyebrow">Event</span><h2>Daftar Event</h2><p>Gunakan search dan filter JavaScript untuk menemukan event sesuai prodi.</p></div></div>
  <div class="filters">
    <input class="input" data-event-search placeholder="Cari event...">
    <select data-event-prodi><option value="">Semua Prodi</option><option>Teknik Elektro</option><option>Teknik Informatika</option></select>
    <select data-event-category><option value="">Semua Kategori</option><?php foreach($categories as $c): ?><option><?= e($c['name']) ?></option><?php endforeach; ?></select>
  </div>
  <div class="grid grid-3">
    <?php foreach ($events as $event): ?>
    <article class="card" data-event-card data-title="<?= e(strtolower($event['title'])) ?>" data-prodi="<?= e($event['study_program']) ?>" data-category="<?= e($event['category_name']) ?>">
      <?php if ($event['poster']): ?><img class="event-img" src="<?= e($event['poster']) ?>" alt="<?= e($event['title']) ?>"><?php else: ?><div class="event-img"></div><?php endif; ?>
      <div class="card-body">
        <span class="badge"><?= e($event['study_program']) ?></span> <span class="badge alt"><?= e($event['category_name']) ?></span>
        <h3><?= e($event['title']) ?></h3>
        <p class="meta"><?= date('d M Y', strtotime($event['event_date'])) ?> - <?= e($event['location']) ?></p>
        <p><?= e(substr($event['description'],0,115)) ?>...</p>
        <p class="meta">Peserta: <?= (int)$event['total_reg'] ?>/<?= (int)$event['quota'] ?></p>
        <div class="actions"><a class="btn btn-primary" href="event-detail.php?id=<?= $event['id'] ?>">Detail</a></div>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
</div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>