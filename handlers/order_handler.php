<?php
// ===================================================
// Order Handler
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
    
    case 'create':
        $items = $_POST['items'] ?? '[]';
        $subtotal = $_POST['subtotal'] ?? 0;
        $shipping = $_POST['shipping'] ?? 0;
        $distance = $_POST['distance'] ?? 0;
        $total = $_POST['total'] ?? 0;
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $detail = $_POST['detail'] ?? '';
        $payment = $_POST['payment'] ?? 'COD';
        
        $order_id = 'ORD-' . time();
        $date = date('d/m/Y H:i');
        
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, order_id, items, subtotal, shipping, distance, total, phone, address, detail, payment, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$user_id, $order_id, $items, $subtotal, $shipping, $distance, $total, $phone, $address, $detail, $payment, $date, 'Pesanan sedang diproses'])) {
            echo json_encode(['success' => true, 'order_id' => $order_id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create order']);
        }
        break;
    
    case 'get_history':
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$user_id]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $formattedOrders = array_map(function($order) {
            return [
                'order_id' => $order['order_id'],
                'date' => $order['date'],
                'items' => json_decode($order['items'], true),
                'subtotal' => (int)$order['subtotal'],
                'shipping' => (int)$order['shipping'],
                'distance' => (float)$order['distance'],
                'total' => (int)$order['total'],
                'phone' => $order['phone'],
                'address' => $order['address'],
                'detail' => $order['detail'],
                'payment' => $order['payment'],
                'status' => $order['status']
            ];
        }, $orders);
        
        echo json_encode(['success' => true, 'orders' => $formattedOrders]);
        break;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>