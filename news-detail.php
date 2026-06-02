<?php
require_once __DIR__ . '/config/database.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT n.*, u.name author FROM news n LEFT JOIN users u ON u.id=n.author_id WHERE n.id=?');
$stmt->execute([$id]);
$n = $stmt->fetch();
if (!$n) { header('Location: news.php'); exit; }
$title = $n['title']; require_once __DIR__ . '/includes/header.php';
?>
<section class="section"><div class="container" style="max-width:850px"><span class="eyebrow">Berita</span><h1><?= e($n['title']) ?></h1><p class="meta"><?= date('d M Y', strtotime($n['created_at'])) ?> oleh <?= e($n['author'] ?? 'Admin') ?></p><?php if($n['image']): ?><img class="card" src="<?= e($n['image']) ?>" alt="<?= e($n['title']) ?>" style="margin:20px 0"><?php endif; ?><div class="card"><div class="card-body"><p><?= nl2br(e($n['content'])) ?></p></div></div></div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>