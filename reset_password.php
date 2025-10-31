<?php
require_once __DIR__ . '../includes/db.php';
$page_title = 'Reset Password';
require __DIR__ . '../includes/header.php';

// reset to default '123456789'
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $new = password_hash('123456789', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE username = ? OR email = ?');
    $stmt->execute([$new, $username, $username]);
    $success = 'Password telah direset ke default: 123456789';
}
?>

<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card p-4 shadow-sm">
      <h3 class="card-title">Reset Password</h3>
      <?php if(!empty($success)): ?><div class="alert alert-success"><?=htmlspecialchars($success)?></div><?php endif; ?>
      <form method="post">
        <div class="mb-3"><label>Username atau Email</label><input name="username" class="form-control" required></div>
        <div class="text-end"><button class="btn btn-warning">Reset ke default</button></div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '../includes/footer.php'; ?>