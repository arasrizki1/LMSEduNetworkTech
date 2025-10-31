<?php
// includes/db.php
// Konfigurasi database
$DB_HOST = '127.0.0.1';
$DB_NAME = 'edunetworktech';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Mengecek apakah user sudah login
 */
function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

/**
 * Paksa user login (redirect kalau belum)
 */
function require_login(): void {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Ambil data user aktif dari session
 */
function current_user(PDO $pdo): ?array {
    if (!is_logged_in()) return null;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
