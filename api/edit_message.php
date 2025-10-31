<?php
require_once __DIR__ . '../../includes/db.php';
require_login();
$user = current_user($pdo);

$input = json_decode(file_get_contents('php://input'), true);
$id = (int)($input['id'] ?? 0);
$text = trim($input['pesan'] ?? '');

header('Content-Type: application/json; charset=utf-8');

$stmt = $pdo->prepare("SELECT * FROM diskusi WHERE id=?");
$stmt->execute([$id]);
$msg = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$msg) exit(json_encode(['success'=>false]));

if ($msg['user_id'] != $user['id'] && $user['role'] != 'Instruktur')
    exit(json_encode(['success'=>false,'error'=>'Tidak berhak']));

$pdo->prepare("UPDATE diskusi SET pesan=? WHERE id=?")->execute([$text, $id]);
echo json_encode(['success'=>true]);
