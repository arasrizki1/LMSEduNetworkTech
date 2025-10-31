<?php
// includes/header.php
if (!isset($page_title)) $page_title = 'EduNetworkTech';
$me = null;
if (isset($pdo)) $me = current_user($pdo);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($page_title) ?> - EduNetworkTech</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-sky">
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" >
        <div class="brand-badge">ENT</div>
        <div class="ms-2">
          <div class="brand-title">Teknisi Jaringan Komputer</div>
          <small class="text-muted">EduNetworkTech</small>
        </div>
      </a>

      <div class="ms-auto">
        <?php if($me): ?>
          <span class="me-3">Halo, <?= htmlspecialchars($me['full_name'] ?? $me['username']) ?></span>
          <a href="logout.php" class="btn btn-outline-secondary btn-sm">Logout</a>
        <?php else: ?>
          <a href="index.php" class="btn btn-primary btn-sm">Kembali</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <main class="container my-4">