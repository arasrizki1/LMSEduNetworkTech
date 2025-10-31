<?php
require_once __DIR__ . '../../includes/db.php';
require_login();

$user = current_user($pdo);
header('Content-Type: application/json; charset=utf-8');

$pesan = trim($_POST['pesan'] ?? '');
$imagePath = null;

if (!empty($_FILES['image']['name'])) {
    $uploadDir = __DIR__ . '../../uploads/chat/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('chat_') . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename);
    $imagePath = 'uploads/chat/' . $filename;
}

if ($pesan === '' && !$imagePath) {
    echo json_encode(['success' => false, 'error' => 'Pesan kosong']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO diskusi (user_id, pesan, image_path) VALUES (?,?,?)");
$stmt->execute([$user['id'], $pesan, $imagePath]);

$id = $pdo->lastInsertId();
$q = $pdo->prepare("SELECT d.*, u.full_name, u.role FROM diskusi d JOIN users u ON d.user_id=u.id WHERE d.id=?");
$q->execute([$id]);
$msg = $q->fetch(PDO::FETCH_ASSOC);
$msg['created_at'] = date('H:i');

echo json_encode(['success'=>true,'message'=>$msg]);
