<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function base_url($path = '') {
    $root = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    $root = preg_replace('#/(admin|member)$#', '', $root);
    return $root . '/' . ltrim($path, '/');
}

function redirect($path) {
    header('Location: ' . base_url($path));
    exit;
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function is_logged_in() {
    return isset($_SESSION['user']);
}

function is_admin() {
    return is_logged_in() && $_SESSION['user']['role'] === 'admin';
}

function require_login() {
    if (!is_logged_in()) {
        $_SESSION['flash_error'] = 'Silakan login terlebih dahulu.';
        redirect('login.php');
    }
}

function require_admin() {
    require_login();
    if (!is_admin()) {
        $_SESSION['flash_error'] = 'Akses admin ditolak.';
        redirect('index.php');
    }
}

function flash($type) {
    $key = 'flash_' . $type;
    if (!empty($_SESSION[$key])) {
        $message = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $message;
    }
    return null;
}

function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
    return trim($text, '-') ?: uniqid('item-');
}

function upload_image($field, $folder = 'assets/uploads') {
    if (empty($_FILES[$field]['name'])) {
        return null;
    }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime = mime_content_type($_FILES[$field]['tmp_name']);
    if (!isset($allowed[$mime])) {
        return null;
    }

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $name = uniqid('img_', true) . '.' . $allowed[$mime];
    $target = rtrim($folder, '/') . '/' . $name;
    move_uploaded_file($_FILES[$field]['tmp_name'], $target);
    return $target;
}

function event_registration_count($pdo, $eventId) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM registrations WHERE event_id = ? AND status != "rejected"');
    $stmt->execute([$eventId]);
    return (int) $stmt->fetchColumn();
}

function user_registered($pdo, $eventId, $userId) {
    $stmt = $pdo->prepare('SELECT id FROM registrations WHERE event_id = ? AND user_id = ?');
    $stmt->execute([$eventId, $userId]);
    return (bool) $stmt->fetchColumn();
}