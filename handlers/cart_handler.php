<?php
// ===================================================
// Cart Handler
// ===================================================

session_start();
header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

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

$user_id = $_SESSION['user_id'];

switch($action) {
    
    case 'get':
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $formattedCart = array_map(function($item) {
            return [
                'key' => $item['menu_key'],
                'title' => $item['title'],
                'price' => (int)$item['price'],
                'quantity' => (int)$item['quantity']
            ];
        }, $cart);
        
        echo json_encode(['success' => true, 'cart' => $formattedCart]);
        break;
    
    case 'add':
        $menu_key = $_POST['menu_key'] ?? '';
        $title = $_POST['title'] ?? '';
        $price = $_POST['price'] ?? 0;
        $quantity = $_POST['quantity'] ?? 1;
        
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND menu_key = ?");
        $stmt->execute([$user_id, $menu_key]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existing) {
            $newQty = $existing['quantity'] + $quantity;
            $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $stmt->execute([$newQty, $existing['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO cart (user_id, menu_key, title, price, quantity) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $menu_key, $title, $price, $quantity]);
        }
        
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $formattedCart = array_map(function($item) {
            return [
                'key' => $item['menu_key'],
                'title' => $item['title'],
                'price' => (int)$item['price'],
                'quantity' => (int)$item['quantity']
            ];
        }, $cart);
        
        echo json_encode(['success' => true, 'cart' => $formattedCart]);
        break;
    
    case 'update':
        $menu_key = $_POST['menu_key'] ?? '';
        $quantity = (int)($_POST['quantity'] ?? 0);
        
        if ($quantity <= 0) {
            $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND menu_key = ?");
            $stmt->execute([$user_id, $menu_key]);
        } else {
            $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND menu_key = ?");
            $stmt->execute([$quantity, $user_id, $menu_key]);
        }
        
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $formattedCart = array_map(function($item) {
            return [
                'key' => $item['menu_key'],
                'title' => $item['title'],
                'price' => (int)$item['price'],
                'quantity' => (int)$item['quantity']
            ];
        }, $cart);
        
        echo json_encode(['success' => true, 'cart' => $formattedCart]);
        break;
    
    case 'clear':
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([$user_id]);
        echo json_encode(['success' => true, 'cart' => []]);
        break;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>