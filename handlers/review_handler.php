<?php
// ===================================================
// Review Handler
// ===================================================

session_start();
header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$host = 'localhost';
$dbname = 'brew_co';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}

switch($action) {
    
    case 'get':
        $stmt = $pdo->query("SELECT * FROM reviews ORDER BY id DESC");
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'reviews' => $reviews]);
        break;
    
    case 'add':
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Please login first']);
            exit;
        }
        
        $user_id = $_SESSION['user_id'];
        $name = $_POST['name'] ?? '';
        $text = $_POST['text'] ?? '';
        $rating = (int)($_POST['rating'] ?? 0);
        $date = date('d F Y');
        
        $stmt = $pdo->prepare("INSERT INTO reviews (user_id, name, text, rating, date) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$user_id, $name, $text, $rating, $date])) {
            $stmt = $pdo->query("SELECT * FROM reviews ORDER BY id DESC");
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'reviews' => $reviews]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add review']);
        }
        break;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>