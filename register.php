<?php
require_once __DIR__ . '../includes/db.php';
$page_title = 'Register';
require __DIR__ . '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sanitasi & upload photo sederhana
    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'] ?: null,
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'role' => $_POST['role'],
        'full_name' => $_POST['full_name'],
        'birth_place' => $_POST['birth_place'] ?: null,
        'birth_date' => $_POST['birth_date'] ?: null,
        'gender' => $_POST['gender'] ?: null,
        'religion' => $_POST['religion'] ?: null,
        'phone' => $_POST['phone'] ?: null,
        'address' => $_POST['address'] ?: null,
        'hobbies' => $_POST['hobbies'] ?: null,
        'last_education' => $_POST['last_education'] ?: null,
        'current_education' => $_POST['current_education'] ?: null,
        'cohort' => $_POST['cohort'] ?: null,
        'year_entry' => $_POST['year_entry'] ?: null,
    ];

    // photo upload
    if (!empty($_FILES['photo']['name'])) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $target = __DIR__ . '../uploads/' . uniqid('p_') . '.' . $ext;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            $data['photo'] = basename($target);
        }
    }

    $stmt = $pdo->prepare("INSERT INTO users (username,email,password,role,full_name,birth_place,birth_date,gender,religion,phone,address,hobbies,last_education,current_education,photo,cohort,year_entry) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute([
        $data['username'],$data['email'],$data['password'],$data['role'],$data['full_name'],$data['birth_place'],$data['birth_date'],$data['gender'],$data['religion'],$data['phone'],$data['address'],$data['hobbies'],$data['last_education'],$data['current_education'],$data['photo'] ?? null,$data['cohort'],$data['year_entry']
    ]);

    $success = 'Registrasi berhasil. Silakan masuk.';
}
?>

<div class="row">
  <div class="col-md-10 mx-auto">
    <div class="card p-4 shadow-sm">
      <h3 class="card-title">Daftar Akun</h3>
      <?php if(!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>
      <form method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Username</label>
            <input name="username" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Email (opsional)</label>
            <input name="email" class="form-control">
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select">
              <option>Peserta</option>
              <option>Instruktur</option>
            </select>
          </div>
        </div>

        <!-- additional fields simplified, user can expand -->
        <div class="row">
          <div class="col-md-6 mb-3"><label>Nama lengkap</label><input name="full_name" class="form-control"></div>
          <div class="col-md-6 mb-3"><label>Tempat Lahir</label><input name="birth_place" class="form-control"></div>
          <div class="col-md-6 mb-3"><label>Tanggal Lahir</label><input type="date" name="birth_date" class="form-control"></div>
          <div class="col-md-6 mb-3"><label>Jenis Kelamin</label><select name="gender" class="form-select"><option></option><option>Laki-laki</option><option>Perempuan</option><option>Lainnya</option></select></div>
          <div class="col-md-6 mb-3"><label>Agama</label><input name="religion" class="form-control"></div>
          <div class="col-md-6 mb-3"><label>Nomor Telepon</label><input name="phone" class="form-control"></div>
          <div class="col-12 mb-3"><label>Alamat lengkap</label><textarea name="address" class="form-control"></textarea></div>
          <div class="col-md-6 mb-3"><label>Hobi</label><input name="hobbies" class="form-control"></div>
          <div class="col-md-6 mb-3"><label>Pendidikan Terakhir</label><input name="last_education" class="form-control"></div>
          <div class="col-md-6 mb-3"><label>Pendidikan Sekarang</label><input name="current_education" class="form-control"></div>
          <div class="col-md-3 mb-3"><label>Angkatan</label><select name="cohort" class="form-select"><option></option><option>satu</option><option>dua</option><option>tiga</option><option>empat</option><option>lima</option></select></div>
          <div class="col-md-3 mb-3"><label>Tahun Masuk</label><input name="year_entry" type="number" class="form-control"></div>
          <div class="col-md-6 mb-3"><label>Foto Diri</label><input type="file" name="photo" class="form-control"></div>
        </div>

        <div class="text-end"><button class="btn btn-primary">Daftar</button></div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '../includes/footer.php'; ?>