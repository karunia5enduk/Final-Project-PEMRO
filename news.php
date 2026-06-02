<?php
require_once __DIR__ . '/config/database.php';
$title = 'Berita - ElectroEvent Hub';
$news = $pdo->query('SELECT n.*, u.name author FROM news n LEFT JOIN users u ON u.id=n.author_id ORDER BY n.created_at DESC')->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>
<section class="section"><div class="container"><div class="section-head"><div><span class="eyebrow">News</span><h2>Berita dan Pengumuman</h2></div></div><div class="grid grid-3"><?php foreach($news as $n): ?><article class="card"><?php if($n['image']): ?><img class="event-img" src="<?= e($n['image']) ?>" alt="<?= e($n['title']) ?>"><?php endif; ?><div class="card-body"><p class="meta"><?= date('d M Y', strtotime($n['created_at'])) ?> oleh <?= e($n['author'] ?? 'Admin') ?></p><h3><?= e($n['title']) ?></h3><p><?= e(substr(strip_tags($n['content']),0,140)) ?>...</p><a class="btn btn-primary" href="news-detail.php?id=<?= $n['id'] ?>">Baca Detail</a></div></article><?php endforeach; ?></div></div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>