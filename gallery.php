<?php
require_once __DIR__ . '/config/database.php';
$title = 'Galeri - ElectroEvent Hub';
$items = $pdo->query('SELECT g.*, e.title event_title FROM gallery g LEFT JOIN events e ON e.id=g.event_id ORDER BY g.created_at DESC')->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>
<section class="section"><div class="container"><div class="section-head"><div><span class="eyebrow">Gallery</span><h2>Galeri Kegiatan</h2><p>Dokumentasi kegiatan jurusan dan organisasi mahasiswa.</p></div></div><div class="gallery"><?php foreach($items as $g): ?><figure><img src="<?= e($g['image']) ?>" alt="<?= e($g['title']) ?>"><figcaption><?= e($g['title']) ?><p class="meta"><?= e($g['event_title'] ?? $g['caption']) ?></p></figcaption></figure><?php endforeach; ?></div></div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>