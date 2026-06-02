<?php
require_once __DIR__ . '/config/database.php';
$title = 'ElectroEvent Hub - Event Jurusan Elektro';
$events = $pdo->query('SELECT e.*, c.name category_name, (SELECT COUNT(*) FROM registrations r WHERE r.event_id=e.id AND r.status != "rejected") total_reg FROM events e JOIN categories c ON c.id=e.category_id WHERE e.status="open" ORDER BY e.event_date ASC LIMIT 3')->fetchAll();
$news = $pdo->query('SELECT * FROM news ORDER BY created_at DESC LIMIT 3')->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="hero-content">
    <span class="eyebrow">Platform Event Resmi Jurusan Elektro</span>
    <h1>ElectroEvent Hub</h1>
    <p>Sistem informasi event untuk publikasi dan manajemen seminar, workshop, webinar, kompetisi, serta kegiatan organisasi mahasiswa Teknik Elektro dan Teknik Informatika.</p>
    <div class="actions" style="justify-content:center">
      <a class="btn btn-primary" href="events.php">Lihat Event</a>
      <a class="btn btn-outline" href="register.php">Daftar Member</a>
    </div>
  </div>
</section>
<section class="section">
  <div class="container">
    <div class="section-head"><div><span class="eyebrow">Upcoming</span><h2>Event Mendatang</h2><p>Kegiatan terbaru dari dua program studi di Jurusan Elektro.</p></div><a class="btn btn-primary" href="events.php">Semua Event</a></div>
    <div class="grid grid-3">
      <?php foreach ($events as $event): ?>
      <article class="card">
        <?php if ($event['poster']): ?><img class="event-img" src="<?= e($event['poster']) ?>" alt="<?= e($event['title']) ?>"><?php else: ?><div class="event-img"></div><?php endif; ?>
        <div class="card-body">
          <span class="badge"><?= e($event['study_program']) ?></span> <span class="badge alt"><?= e($event['category_name']) ?></span>
          <h3><?= e($event['title']) ?></h3>
          <p class="meta"><?= date('d M Y', strtotime($event['event_date'])) ?>, <?= substr($event['event_time'],0,5) ?> - <?= e($event['location']) ?></p>
          <p><?= e(substr($event['description'], 0, 110)) ?>...</p>
          <div class="actions"><a class="btn btn-primary" href="event-detail.php?id=<?= $event['id'] ?>">Detail</a></div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="section" style="background:#fff">
  <div class="container grid grid-2">
    <div><span class="eyebrow">Program Studi</span><h2>Teknik Elektro</h2><p>Event seputar sistem tenaga listrik, elektronika, telekomunikasi, kontrol, robotika, IoT, dan energi terbarukan.</p></div>
    <div><span class="eyebrow">Program Studi</span><h2>Teknik Informatika</h2><p>Event seputar pemrograman, data science, AI, cybersecurity, web development, UI/UX, dan software engineering.</p></div>
  </div>
</section>
<section class="section">
  <div class="container">
    <div class="section-head"><div><span class="eyebrow">News</span><h2>Berita dan Pengumuman</h2></div><a class="btn btn-primary" href="news.php">Semua Berita</a></div>
    <div class="grid grid-3">
      <?php foreach ($news as $item): ?>
      <article class="card"><div class="card-body"><p class="meta"><?= date('d M Y', strtotime($item['created_at'])) ?></p><h3><?= e($item['title']) ?></h3><p><?= e(substr(strip_tags($item['content']),0,130)) ?>...</p><a class="btn btn-muted" href="news-detail.php?id=<?= $item['id'] ?>">Baca</a></div></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>