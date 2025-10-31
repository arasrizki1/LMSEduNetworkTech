<?php
// File: public/login.php
require_once __DIR__ . '../includes/db.php';
$page_title = 'Masuk';
require __DIR__ . '../includes/header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
$u = $_POST['username'];
$p = $_POST['password'];


$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1');
$stmt->execute([$u, $u]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($user && password_verify($p, $user['password'])) {
$_SESSION['user_id'] = $user['id'];
if ($user['role'] === 'Instruktur') {
header('Location: dashboard_instructor.php'); exit;
} else {
header('Location: dashboard_participant.php'); exit;
}
} else {
$error = 'Username/email atau password salah.';
}
}
?>


<div class="row">
<div class="col-md-6 mx-auto">
<div class="card p-4 shadow-sm">
<h3 class="card-title text-center mb-4">Masuk ke EduNetworkTech</h3>
<?php if(!empty($error)): ?>
<div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post">
<div class="mb-3">
<label class="form-label">Username atau Email</label>
<input name="username" class="form-control" required>
</div>
<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" required>
</div>
<div class="d-flex justify-content-between align-items-center">
<a href="register.php">Daftar</a>
<a href="reset_password.php">Lupa password?</a>
</div>
<div class="mt-4 text-end">
<button name="login" class="btn btn-primary">Masuk</button>
</div>
</form>
</div>
</div>
</div>


<?php require __DIR__ . '../includes/footer.php'; ?>