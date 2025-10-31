<?php
require_once __DIR__ . '../includes/db.php';
if (!is_logged_in()) { header('Location: index.php'); exit; }
$user = current_user($pdo);
if ($user['role'] !== 'Instruktur') { header('Location: index.php'); exit; }
$page_title = 'Dashboard Instruktur';
require __DIR__ . '../includes/header.php';

// ambil data singkat
$total_users = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$total_participants = $pdo->query("SELECT COUNT(*) FROM users WHERE role='Peserta'")->fetchColumn();
?>

<div class="text-center mb-4">
  <h2>Selamat Datang, <?= htmlspecialchars($user['full_name'] ?: $user['username']) ?>!</h2>
  <p class="text-muted">Dashboard Instruktur EduNetworkTech</p>
</div>

<div class="row g-4">
  <?php
  $menus = [
    ['Data Siswa', 'bi-people', 'data_siswa.php'],
    ['Absensi', 'bi-calendar-check', 'absensi.php'],
    ['Hasil Tugas', 'bi-clipboard-check', 'hasil_tugas.php'],
    ['Hasil Pilihan Ganda', 'bi-list-check', 'hasil_pilgan.php'],
    ['Hasil Essay', 'bi-journal-text', 'hasil_essay.php'],
    ['Hasil Praktek', 'bi-tools', 'hasil_praktek.php'],
    ['Hasil Laporan', 'bi-file-earmark-text', 'hasil_laporan.php'],
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

<hr class="my-5">

<div class="text-center">
  <div class="row justify-content-center">
    <div class="col-md-3">
      <div class="card bg-light border-0 shadow-sm">
        <div class="card-body">
          <h6>Total Pengguna</h6>
          <h3><?= $total_users ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-light border-0 shadow-sm">
        <div class="card-body">
          <h6>Peserta</h6>
          <h3><?= $total_participants ?></h3>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '../includes/footer.php'; ?>
