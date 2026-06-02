<?php
require_once __DIR__ . '/includes/functions.php';
session_destroy();
session_start();
$_SESSION['flash_success'] = 'Anda berhasil logout.';
redirect('index.php');