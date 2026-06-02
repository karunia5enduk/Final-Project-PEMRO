<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT e.*, c.name category_name FROM events e JOIN categories c ON c.id=e.category_id WHERE e.id=?');
$stmt->execute([$id]);
$event = $stmt->fetch();
if (!$event) redirect('events.php');
$count = event_registration_count($pdo, $id);
$registered = is_logged_in() ? user_registered($pdo, $id, current_user()['id']) : false;
$title = $event['title'];
require_once __DIR__ . '/includes/header.php';
?>
<section class="section"><div class="container grid grid-2">
  <div>
    <?php if ($event['poster']): ?><img class="card" src="<?= e($event['poster']) ?>" alt="<?= e($event['title']) ?>"><?php else: ?><div class="event-img card" style="height:420px"></div><?php endif; ?>
  </div>
  <div>
    <span class="badge"><?= e($event['study_program']) ?></span> <span class="badge alt"><?= e($event['category_name']) ?></span>
    <h1><?= e($event['title']) ?></h1>
    <p class="meta"><?= date('d M Y', strtotime($event['event_date'])) ?>, <?= substr($event['event_time'],0,5) ?> - <?= e($event['location']) ?></p>
    <p data-countdown="<?= e($event['event_date'].'T'.$event['event_time']) ?>" class="badge warn"></p>
    <p><?= nl2br(e($event['description'])) ?></p>
    <p><strong>Kuota:</strong> <?= $count ?>/<?= (int)$event['quota'] ?> peserta</p>
    <div class="actions">
      <?php if (!is_logged_in()): ?><a class="btn btn-primary" href="login.php">Login untuk Daftar</a>
      <?php elseif (is_admin()): ?><a class="btn btn-muted" href="admin/events.php">Kelola Event</a>
      <?php elseif ($registered): ?><span class="btn btn-muted">Anda sudah terdaftar</span>
      <?php elseif ($count >= (int)$event['quota']): ?><span class="btn btn-danger">Kuota penuh</span>
      <?php else: ?><form method="post" action="event-register.php"><input type="hidden" name="event_id" value="<?= $event['id'] ?>"><button class="btn btn-primary">Daftar Event</button></form><?php endif; ?>
    </div>
  </div>
</div></section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>