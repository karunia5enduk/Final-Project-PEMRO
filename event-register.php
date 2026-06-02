<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_login();
if (is_admin()) redirect('events.php');
$eventId = (int)($_POST['event_id'] ?? 0);
$stmt = $pdo->prepare('SELECT quota FROM events WHERE id=? AND status="open"');
$stmt->execute([$eventId]);
$event = $stmt->fetch();
if (!$event) { $_SESSION['flash_error'] = 'Event tidak tersedia.'; redirect('events.php'); }
if (event_registration_count($pdo, $eventId) >= (int)$event['quota']) { $_SESSION['flash_error'] = 'Kuota event penuh.'; redirect('event-detail.php?id='.$eventId); }
try {
    $stmt = $pdo->prepare('INSERT INTO registrations (user_id,event_id,status) VALUES (?,?,"approved")');
    $stmt->execute([current_user()['id'], $eventId]);
    $_SESSION['flash_success'] = 'Pendaftaran event berhasil.';
} catch (PDOException $e) {
    $_SESSION['flash_error'] = 'Anda sudah terdaftar pada event ini.';
}
redirect('event-detail.php?id=' . $eventId);