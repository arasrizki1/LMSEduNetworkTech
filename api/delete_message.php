<?php
require_once __DIR__ . '../../includes/db.php';
require_login();
$user = current_user($pdo);

$input = json_decode(file_get_contents('php://input'), true);
$id = (int)($input['id'] ?? 0);

header('Content-Type: application/json; charset=utf-8');

$stmt = $pdo->prepare("SELECT * FROM diskusi WHERE id=?");
$stmt->execute([$id]);
$msg = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$msg) exit(json_encode(['success'=>false]));

if ($msg['user_id'] != $user['id'] && $user['role'] != 'Instruktur')
    exit(json_encode(['success'=>false,'error'=>'Tidak berhak']));

// hapus file gambar jika ada
if (!empty($msg['image_path'])) {
    $path = __DIR__ . '/../../' . $msg['image_path'];
    if (file_exists($path)) unlink($path);
}

$pdo->prepare("DELETE FROM diskusi WHERE id=?")->execute([$id]);
echo json_encode(['success'=>true]);
