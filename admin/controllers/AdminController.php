<?php
class AdminController {
    private $db;
    private $pdo;
    
    public function __construct() {
        $database = new Database();
        $this->pdo = $database->connect();
    }
    
    public function handleRequest() {
        // Cek logout
        if (isset($_GET['logout'])) {
            $this->logout();
        }
        
        // Cek login
        if (!isset($_SESSION['is_admin'])) {
            $this->showLogin();
            return;
        }
        
        // Auto insert menu default
        $this->autoInsertMenu();
        
        // Handle actions
        $page = $_GET['page'] ?? 'menu';
        
        if (isset($_GET['delete'])) {
            $this->deleteMenu($_GET['delete']);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
            $this->saveMenu($_POST);
        }
        
        // Show dashboard
        $this->showDashboard($page);
    }
    
    private function showLogin() {
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $user = $_POST['username'] ?? '';
            $pass = $_POST['password'] ?? '';
            
            if ($user === 'admin' && $pass === 'admin123') {
                $_SESSION['is_admin'] = true;
                header('Location: index.php');
                exit;
            } else {
                $error = 'Username atau password salah!';
            }
        }
        
        require_once 'views/login.php';
    }
    
    private function showDashboard($page) {
        // Get data
        $menus = $this->getMenus();
        $orders = $this->getOrders();
        $editData = null;
        
        if (isset($_GET['edit'])) {
            $editData = $this->getMenuById($_GET['edit']);
        }
        
        $message = $_SESSION['admin_message'] ?? '';
        $messageType = $_SESSION['admin_message_type'] ?? 'success';
        unset($_SESSION['admin_message'], $_SESSION['admin_message_type']);
        
        require_once 'views/dashboard.php';
    }
    
    private function autoInsertMenu() {
        $checkMenu = $this->pdo->query("SELECT COUNT(*) FROM menu")->fetchColumn();
        
        if ($checkMenu == 0) {
            $existingMenus = [
                ['espresso', 'Espresso', 'coffee', 15000, 'assets/images/espresso.jpg', 'Kopi murni dengan cita rasa kuat dan pekat. Diseduh menggunakan tekanan tinggi tanpa campuran. Cocok untuk penikmat kopi sejati yang menyukai rasa bold.'],
                // ... data menu lainnya
            ];
            
            $stmt = $this->pdo->prepare("INSERT INTO menu (menu_key, title, category, price, image, description) VALUES (?, ?, ?, ?, ?, ?)");
            foreach ($existingMenus as $menu) {
                try {
                    $stmt->execute($menu);
                } catch (PDOException $e) {}
            }
        }
    }
    
    private function getMenus() {
        $stmt = $this->pdo->query("SELECT * FROM menu ORDER BY category, id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getOrders() {
        $stmt = $this->pdo->query("
            SELECT o.*, u.username, u.email 
            FROM orders o 
            LEFT JOIN users u ON o.user_id = u.id 
            ORDER BY o.id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getMenuById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM menu WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    private function deleteMenu($id) {
        $stmt = $this->pdo->prepare("DELETE FROM menu WHERE id = ?");
        $stmt->execute([(int)$id]);
        
        $_SESSION['admin_message'] = "Menu berhasil dihapus!";
        $_SESSION['admin_message_type'] = 'success';
        
        header('Location: index.php?page=menu');
        exit;
    }
    
    private function saveMenu($data) {
        $id = $data['id'] ?? null;
        $menu_key = strtolower(trim($data['menu_key'] ?? ''));
        $title = trim($data['title'] ?? '');
        $category = $data['category'] ?? 'coffee';
        $price = (int)($data['price'] ?? 0);
        $image = trim($data['image'] ?? '');
        $description = trim($data['description'] ?? '');
        
        try {
            if ($id) {
                $stmt = $this->pdo->prepare("UPDATE menu SET menu_key = ?, title = ?, category = ?, price = ?, image = ?, description = ? WHERE id = ?");
                $stmt->execute([$menu_key, $title, $category, $price, $image, $description, $id]);
                $_SESSION['admin_message'] = "Menu berhasil diupdate!";
            } else {
                $stmt = $this->pdo->prepare("INSERT INTO menu (menu_key, title, category, price, image, description) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$menu_key, $title, $category, $price, $image, $description]);
                $_SESSION['admin_message'] = "Menu berhasil ditambahkan!";
            }
            $_SESSION['admin_message_type'] = 'success';
        } catch (PDOException $e) {
            $_SESSION['admin_message'] = "Error: " . $e->getMessage();
            $_SESSION['admin_message_type'] = 'error';
        }
        
        header('Location: index.php?page=menu');
        exit;
    }
    
    private function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}