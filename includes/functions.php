<?php
// ===================================================
// Helper Functions
// ===================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    require_once __DIR__ . '/../config/db.php';
    $db = new Database();
    $conn = $db->connect();
    
    $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    
    return $stmt->fetch();
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: index.php');
        exit;
    }
}

function formatRupiah($amount) {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function formatDateIndo($date) {
    $months = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $timestamp = strtotime($date);
    $day = date('d', $timestamp);
    $month = $months[(int)date('m', $timestamp)];
    $year = date('Y', $timestamp);
    
    return $day . ' ' . $month . ' ' . $year;
}