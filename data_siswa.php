<?php
require_once __DIR__ . '../includes/db.php';
if (!is_logged_in()) { header('Location: index.php'); exit; }
$user = current_user($pdo);
if ($user['role'] !== 'Instruktur') { header('Location: index.php'); exit; }

$page_title = 'Data Siswa';
require __DIR__ . '../includes/header.php';

// ambil data siswa
$stmt = $pdo->query("SELECT id, username, full_name, email, phone, cohort AS angkatan, year_entry AS tahun_masuk FROM users WHERE role='Peserta' ORDER BY full_name ASC");
//$stmt = $pdo->query("SELECT id, username, full_name, email, phone, angkatan, tahun_masuk FROM users WHERE role='Peserta' ORDER BY full_name ASC");
$siswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-primary"><i class="bi bi-people"></i> Data Siswa</h3>
    <a href="dashboard_instructor.php" class="btn btn-outline-primary btn-sm">
      <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>
  </div>

  <div class="card shadow-sm border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table id="tabelSiswa" class="table table-striped align-middle">
          <thead class="table-primary">
            <tr>
              <th>No</th>
              <th>Nama Lengkap</th>
              <th>Username</th>
              <th>Email</th>
              <th>Nomor HP</th>
              <th>Angkatan</th>
              <th>Tahun Masuk</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach($siswa as $row): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['full_name'] ?? '') ?></td>
				<td><?= htmlspecialchars($row['username'] ?? '') ?></td>
				<td><?= htmlspecialchars($row['email'] ?? '') ?></td>
				<td><?= htmlspecialchars($row['phone'] ?? '') ?></td>
				<td><?= htmlspecialchars($row['angkatan'] ?? '') ?></td>
				<td><?= htmlspecialchars($row['tahun_masuk'] ?? '') ?></td>
              <td>
                <a href="detail_siswa.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-info">
                  <i class="bi bi-eye"></i> Detail
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Tambahkan DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function(){
  $('#tabelSiswa').DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
    }
  });
});
</script>

<?php require __DIR__ . '../includes/footer.php'; ?>
