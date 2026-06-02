<?php require_once __DIR__ . '/../includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'ElectroEvent Hub') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<header class="site-header">
    <a href="<?= base_url('index.php') ?>" class="brand">
        <span class="brand-mark">EH</span>
        <span><strong>ElectroEvent Hub</strong><small>Jurusan Elektro</small></span>
    </a>
    <button class="nav-toggle" data-nav-toggle>Menu</button>
    <nav class="main-nav" data-nav>
        <a href="<?= base_url('index.php') ?>">Home</a>
        <a href="<?= base_url('events.php') ?>">Event</a>
        <a href="<?= base_url('news.php') ?>">Berita</a>
        <a href="<?= base_url('gallery.php') ?>">Galeri</a>
        <a href="<?= base_url('about.php') ?>">Tim</a>
        <?php if (is_logged_in()): ?>
            <?php if (is_admin()): ?><a href="<?= base_url('admin/dashboard.php') ?>">Admin</a><?php endif; ?>
            <a href="<?= base_url('member/dashboard.php') ?>">Member</a>
            <a class="btn btn-outline" href="<?= base_url('logout.php') ?>">Logout</a>
        <?php else: ?>
            <a href="<?= base_url('login.php') ?>">Login</a>
            <a class="btn btn-primary" href="<?= base_url('register.php') ?>">Register</a>
        <?php endif; ?>
    </nav>
</header>
<main>
<?php if ($msg = flash('success')): ?><div class="flash success"><?= e($msg) ?></div><?php endif; ?>
<?php if ($msg = flash('error')): ?><div class="flash error"><?= e($msg) ?></div><?php endif; ?>