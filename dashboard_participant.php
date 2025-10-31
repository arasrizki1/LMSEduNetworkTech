<?php
require_once __DIR__ . '../includes/db.php';
if (!is_logged_in()) { header('Location: index.php'); exit; }
$user = current_user($pdo);
if ($user['role'] !== 'Peserta') { header('Location: index.php'); exit; }
$page_title = 'Dashboard Peserta';
require __DIR__ . '../includes/header.php';
?>

<div class="text-center mb-4">
  <h2>Halo, <?= htmlspecialchars($user['full_name'] ?: $user['username']) ?>!</h2>
  <p class="text-muted">Dashboard Peserta EduNetworkTech</p>
</div>

<div class="row g-4">
  <?php
  $menus = [
    ['Absen', 'bi-calendar-check', 'absen.php'],
    ['Tugas', 'bi-clipboard', 'tugas.php'],
    ['Pilihan Ganda', 'bi-list-check', 'pilihan_ganda.php'],
    ['Essay', 'bi-journal-text', 'essay.php'],
    ['Praktek', 'bi-tools', 'praktek.php'],
    ['Laporan', 'bi-file-earmark-text', 'laporan.php'],
    ['Diskusi', 'bi-chat-dots', 'diskusi.php']
  ];
  foreach ($menus as $m): ?>
  <div class="col-md-3 col-sm-6">
    <a href="<?= $m[2] ?>" class="text-decoration-none">
      <div class="card card-menu text-center shadow-sm h-100 border-0 hover-glow">
        <div class="card-body">
          <i class="bi <?= $m[1] ?> display-5 text-primary"></i>
          <h5 class="mt-3 text-dark"><?= $m[0] ?></h5>
        </div>
      </div>
    </a>
  </div>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . '../includes/footer.php'; ?>
