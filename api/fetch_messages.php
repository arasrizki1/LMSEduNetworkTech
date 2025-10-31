<?php
require_once __DIR__ . '../../includes/db.php';
require_login();
header('Content-Type: application/json; charset=utf-8');

$after = isset($_GET['after']) ? (int)$_GET['after'] : 0;
$q = $pdo->prepare("SELECT d.id,d.pesan,d.image_path,d.created_at,u.id AS user_id,u.full_name,u.role
FROM diskusi d JOIN users u ON d.user_id=u.id
WHERE d.id>? ORDER BY d.id ASC LIMIT 100");
$q->execute([$after]);
$data = $q->fetchAll(PDO::FETCH_ASSOC);
foreach ($data as &$d) $d['created_at'] = date('H:i', strtotime($d['created_at']));
echo json_encode($data);
