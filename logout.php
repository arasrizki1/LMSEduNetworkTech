<?php
// File: public/logout.php
require_once __DIR__ . '../includes/db.php';

// hapus session user dan arahkan ke halaman login
session_unset();
session_destroy();

header('Location: index.php');
exit;
