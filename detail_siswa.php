<?php
require_once __DIR__ . '../includes/db.php';
require_login();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: data_siswa.php');
    exit;
}

$id = (int) $_GET['id'];

// Ambil data siswa
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$siswa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$siswa) {
    echo "<div class='alert alert-danger text-center mt-4'>Data siswa tidak ditemukan.</div>";
    exit;
}

// ==== PROSES UPDATE ====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $birth_place = $_POST['birth_place'] ?? '';
    $birth_date = $_POST['birth_date'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $religion = $_POST['religion'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $hobbies = $_POST['hobbies'] ?? '';
    $last_education = $_POST['last_education'] ?? '';
    $current_education = $_POST['current_education'] ?? '';
    $cohort = $_POST['cohort'] ?? '';
	$year_entry = !empty($_POST['year_entry']) ? 
	$_POST['year_entry'] : null;

    // === Upload Foto Baru ===
    $photo = $siswa['photo'];
    if (!empty($_FILES['photo']['name'])) {
        $upload_dir = __DIR__ . '/uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_name = time() . '_' . basename($_FILES['photo']['name']);
        $target_file = $upload_dir . $file_name;

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            if (move_uploaded_file($file_tmp, $target_file)) {
                // Hapus foto lama jika ada
                if (!empty($siswa['photo']) && file_exists($upload_dir . $siswa['photo'])) {
                    unlink($upload_dir . $siswa['photo']);
                }
                $photo = $file_name;
            }
        }
    }

    // Update ke database
    $update = $pdo->prepare("UPDATE users SET 
        full_name = ?, email = ?, birth_place = ?, birth_date = ?, gender = ?, religion = ?, 
        phone = ?, address = ?, hobbies = ?, last_education = ?, current_education = ?, 
        cohort = ?, year_entry = ?, photo = ? WHERE id = ?");

    $update->execute([
        $full_name, $email, $birth_place, $birth_date, $gender, $religion,
        $phone, $address, $hobbies, $last_education, $current_education,
        $cohort, $year_entry, $photo, $id
    ]);

    // Refresh data
    header("Location: detail_siswa.php?id=$id&updated=1");
    exit;
}

$page_title = 'Detail & Edit Siswa';
require __DIR__ . '../includes/header.php';
?>

<div class="container py-4">
  <?php if (isset($_GET['updated'])): ?>
    <div class="alert alert-success">✅ Data siswa berhasil diperbarui.</div>
  <?php endif; ?>

  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="bi bi-person-badge"></i> Detail Siswa</h4>
      <button class="btn btn-light btn-sm" id="toggleEdit"><i class="bi bi-pencil-square"></i> Edit Data</button>
    </div>

    <div class="card-body">

      <!-- === TABEL DETAIL === -->
      <div id="detailSection">
       

      <div class="row">
        <div class="col-md-4 text-center mb-3">
          <?php if (!empty($siswa['photo']) && file_exists(__DIR__ . '/uploads/' . $siswa['photo'])): ?>
            <img src="uploads/<?= htmlspecialchars($siswa['photo']) ?>" class="img-fluid rounded shadow-sm" alt="Foto Siswa">
          <?php else: ?>
            <img src="https://via.placeholder.com/200x200.png?text=No+Photo" class="img-fluid rounded shadow-sm" alt="No Photo">
          <?php endif; ?>
        </div>

          <div class="col-md-8">
            <table class="table table-bordered">
              <tr><th>Nama Lengkap</th><td><?= htmlspecialchars($siswa['full_name'] ?? '-') ?></td></tr>
              <tr><th>Email</th><td><?= htmlspecialchars($siswa['email'] ?? '-') ?></td></tr>
              <tr><th>Tempat, Tanggal Lahir</th>
                <td><?= htmlspecialchars($siswa['birth_place'] ?? '-') ?>, <?= htmlspecialchars($siswa['birth_date'] ?? '-') ?></td></tr>
              <tr><th>Jenis Kelamin</th><td><?= htmlspecialchars($siswa['gender'] ?? '-') ?></td></tr>
              <tr><th>Agama</th><td><?= htmlspecialchars($siswa['religion'] ?? '-') ?></td></tr>
              <tr><th>No. Telepon</th><td><?= htmlspecialchars($siswa['phone'] ?? '-') ?></td></tr>
              <tr><th>Alamat</th><td><?= nl2br(htmlspecialchars($siswa['address'] ?? '-')) ?></td></tr>
              <tr><th>Hobi</th><td><?= nl2br(htmlspecialchars($siswa['hobbies'] ?? '-')) ?></td></tr>
              <tr><th>Pendidikan Terakhir</th><td><?= htmlspecialchars($siswa['last_education'] ?? '-') ?></td></tr>
              <tr><th>Pendidikan Sekarang</th><td><?= htmlspecialchars($siswa['current_education'] ?? '-') ?></td></tr>
              <tr><th>Angkatan</th><td><?= htmlspecialchars($siswa['cohort'] ?? '-') ?></td></tr>
              <tr><th>Tahun Masuk</th><td><?= htmlspecialchars($siswa['year_entry'] ?? '-') ?></td></tr>
              <tr><th>Dibuat Pada</th><td><?= htmlspecialchars($siswa['created_at'] ?? '-') ?></td></tr>
            </table>
          </div>
        </div>
      </div>

      <!-- === FORM EDIT === -->
      <form id="editSection" method="POST" enctype="multipart/form-data" class="d-none">
        
      <div class="row">
        <div class="col-md-4 text-center mb-3">
          <?php if (!empty($siswa['photo']) && file_exists(__DIR__ . '/uploads/' . $siswa['photo'])): ?>
            <img src="uploads/<?= htmlspecialchars($siswa['photo']) ?>" class="img-fluid rounded shadow-sm" alt="Foto Siswa">
          <?php else: ?>
            <img src="https://via.placeholder.com/200x200.png?text=No+Photo" class="img-fluid rounded shadow-sm" alt="No Photo">
          <?php endif; ?>
            <input type="file" name="photo" class="form-control mt-2" accept="image/*">
        </div>



          <div class="col-md-8">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($siswa['full_name'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($siswa['email'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" name="birth_place" class="form-control" value="<?= htmlspecialchars($siswa['birth_place'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="birth_date" class="form-control" value="<?= htmlspecialchars($siswa['birth_date'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Jenis Kelamin</label>
                <select name="gender" class="form-select">
                  <option value="">-- Pilih --</option>
                  <option value="Laki-laki" <?= ($siswa['gender'] == 'Laki-laki' ? 'selected' : '') ?>>Laki-laki</option>
                  <option value="Perempuan" <?= ($siswa['gender'] == 'Perempuan' ? 'selected' : '') ?>>Perempuan</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Agama</label>
                <input type="text" name="religion" class="form-control" value="<?= htmlspecialchars($siswa['religion'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">No. Telepon</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($siswa['phone'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Angkatan</label>
                <input type="text" name="cohort" class="form-control" value="<?= htmlspecialchars($siswa['cohort'] ?? '') ?>">
              </div>
              <div class="col-12">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($siswa['address'] ?? '') ?></textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Hobi</label>
                <textarea name="hobbies" class="form-control" rows="2"><?= htmlspecialchars($siswa['hobbies'] ?? '') ?></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Pendidikan Terakhir</label>
                <input type="text" name="last_education" class="form-control" value="<?= htmlspecialchars($siswa['last_education'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Pendidikan Sekarang</label>
                <input type="text" name="current_education" class="form-control" value="<?= htmlspecialchars($siswa['current_education'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Tahun Masuk</label>
                <input type="text" name="year_entry" class="form-control" value="<?= htmlspecialchars($siswa['year_entry'] ?? '') ?>">
              </div>
            </div>
          </div>
        </div>
        <div class="text-end mt-3">
          <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Perubahan</button>
          <button type="button" id="cancelEdit" class="btn btn-secondary">Batal</button>
        </div>
      </form>

    </div>

    <div class="card-footer text-end">
      <a href="data_siswa.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>

<script>
document.getElementById('toggleEdit').addEventListener('click', () => {
  document.getElementById('detailSection').classList.add('d-none');
  document.getElementById('editSection').classList.remove('d-none');
});
document.getElementById('cancelEdit').addEventListener('click', () => {
  document.getElementById('editSection').classList.add('d-none');
  document.getElementById('detailSection').classList.remove('d-none');
});
</script>

<?php require __DIR__ . '../includes/footer.php'; ?>
