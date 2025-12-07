<?php

session_start();

if (!isset($_SESSION['is_admin'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $user = $_POST['username'] ?? '';
        $pass = $_POST['password'] ?? '';
        
        if ($user === 'admin' && $pass === 'admin123') {
            $_SESSION['is_admin'] = true;
        } else {
            $error = 'Username atau password salah!';
        }
    }
    
    if (!isset($_SESSION['is_admin'])) {
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin Login</title>
            <link rel="stylesheet" href="assets/style.css">
            <style>
                .login-box {
                    max-width: 400px;
                    margin: 100px auto;
                    background: white;
                    padding: 40px;
                    border-radius: 15px;
                    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
                }
                .login-box h2 { text-align: center; margin-bottom: 30px; }
                .login-box input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; }
                .error { background: #fee; color: #c33; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
            </style>
        </head>
        <body>
            <div class="login-box">
                <h2>🔐 Admin Login</h2>
                <?php if (isset($error)): ?>
                    <div class="error"><?= $error ?></div>
                <?php endif; ?>
                <form method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login" class="btn btn-primary" style="width:100%">Login</button>
                </form>
                <p style="text-align:center; margin-top:20px;">
                    <a href="index.php">← Kembali ke Home</a>
                </p>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

$host = 'localhost';
$dbname = 'brew_co';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database error: " . $e->getMessage());
}

$checkMenu = $pdo->query("SELECT COUNT(*) FROM menu")->fetchColumn();
if ($checkMenu == 0) {
    $existingMenus = [
        ['espresso', 'Espresso', 'coffee', 15000, 'assets/images/espresso.jpg', 'Kopi murni dengan cita rasa kuat dan pekat. Diseduh menggunakan tekanan tinggi tanpa campuran. Cocok untuk penikmat kopi sejati yang menyukai rasa bold.'],
        ['latte', 'Latte', 'coffee', 20000, 'assets/images/latte.jpg', 'Campuran espresso dan susu steamed yang creamy. Memiliki lapisan foam tipis di bagian atas. Favorit bagi pecinta rasa lembut dan seimbang.'],
        ['cappuccino', 'Cappuccino', 'coffee', 22000, 'assets/images/capucino.jpg', 'Perpaduan espresso, susu steamed, dan busa foam tebal. Rasa seimbang antara pahit dan lembut. Cocok diminum pagi hari untuk energi ekstra.'],
        ['mocha', 'Mocha', 'coffee', 23000, 'assets/images/mocha.jpg', 'Kombinasi espresso, susu, dan cokelat murni. Rasa manis berpadu dengan aroma kopi pekat. Pilihan ideal untuk kamu yang suka kopi dengan sentuhan coklat.'],
        ['americano', 'Americano', 'coffee', 28000, 'assets/images/americano.jpg', 'Espresso yang dicampur air panas. Rasa ringan dengan aroma kopi yang kuat. Sering dinikmati tanpa tambahan gula atau susu.'],
        ['matcha', 'Matcha Latte', 'coffee', 23000, 'assets/images/matcha.jpg', 'Perpaduan bubuk matcha Jepang dan susu steamed. Rasa earthy yang khas dengan aroma lembut. Disajikan panas atau dingin sesuai selera.'],
        ['coldbrew', 'Cold Brew', 'coffee', 27000, 'assets/images/coldbrew.jpg', 'Kopi diseduh dengan air dingin selama 12-18 jam. Rasa lebih halus dan tidak terlalu asam. Cocok dinikmati dingin untuk hari yang panas.'],
        
        ['brownies', 'Brownies', 'snacks', 20000, 'assets/images/Brownies.jpg', 'Cokelat brownies lembut dengan aroma butter. Tekstur fudgy dan manis seimbang. Paling nikmat disajikan dengan kopi espresso.'],
        ['cookies', 'Cookies', 'snacks', 15000, 'assets/images/Cookies.jpg', 'Kue renyah dengan taburan chocochips premium. Rasa gurih mentega dan manis cokelat berpadu sempurna. Cocok sebagai teman ngobrol di sore hari.'],
        ['croissant', 'Croissant', 'snacks', 22000, 'assets/images/Croissant.jpg', 'Roti Prancis berlapis dengan tekstur flaky dan lembut. Dibuat dari adonan mentega berkualitas tinggi. Lezat disantap bersama kopi latte atau teh hangat.'],
        ['fries', 'French Fries', 'snacks', 14000, 'assets/images/FrenchFries.jpg', 'Kentang goreng renyah di luar, lembut di dalam. Dibumbui ringan dengan garam dan herbs. Cocok untuk camilan santai atau teman minum kopi.'],
        ['onionrings', 'Onion Rings', 'snacks', 10000, 'assets/images/Onionrings.jpg', 'Irisan bawang besar dilapisi tepung crispy. Rasa gurih dan sedikit manis alami. Paling enak dengan saus keju atau mayones.'],
        ['nugget', 'Nugget', 'snacks', 14000, 'assets/images/Nugget.jpg', 'Potongan ayam dibalut tepung renyah. Dimasak hingga keemasan dan gurih. Sajikan hangat untuk rasa terbaik.']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO menu (menu_key, title, category, price, image, description) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($existingMenus as $menu) {
        try {
            $stmt->execute($menu);
        } catch (PDOException $e) {
        }
    }
}

$message = '';
$messageType = 'success';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM menu WHERE id = ?");
    if ($stmt->execute([$id])) {
        $message = "Menu berhasil dihapus!";
    }

    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $id = $_POST['id'] ?? null;
    $menu_key = strtolower(trim($_POST['menu_key'] ?? ''));
    $title = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? 'coffee';
    $price = (int)($_POST['price'] ?? 0);
    $image = trim($_POST['image'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    try {
        if ($id) {
            // UPDATE
            $stmt = $pdo->prepare("UPDATE menu SET menu_key = ?, title = ?, category = ?, price = ?, image = ?, description = ? WHERE id = ?");
            $stmt->execute([$menu_key, $title, $category, $price, $image, $description, $id]);
            $message = "Menu berhasil diupdate!";
            $messageType = 'success';
        } else {
            // INSERT
            $stmt = $pdo->prepare("INSERT INTO menu (menu_key, title, category, price, image, description) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$menu_key, $title, $category, $price, $image, $description]);
            $message = "Menu berhasil ditambahkan!";
            $messageType = 'success';
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = 'error';
    }
}

if (isset($_SESSION['admin_message'])) {
    $message = $_SESSION['admin_message'];
    $messageType = $_SESSION['admin_message_type'] ?? 'success';
    unset($_SESSION['admin_message'], $_SESSION['admin_message_type']);
}

$stmt = $pdo->query("SELECT * FROM menu ORDER BY category, id DESC");
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM menu WHERE id = ?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - CRUD Menu</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .admin-header {
            background: var(--coffee-dark);
            color: #FFFF;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .admin-header h1 { margin: 0; }
        .message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideDown 0.3s;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .form-section h2 { margin-bottom: 20px; color: var(--coffee-dark); }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .form-hint {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .data-table {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: var(--coffee-dark);
            color: white;
        }
        .menu-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .category-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-coffee {
            background: #c9b5a0;
            color: #5a3e27;
        }
        .badge-snacks {
            background: #ffe0b2;
            color: #e65100;
        }
        .btn-small {
            padding: 6px 15px;
            font-size: 13px;
            margin-right: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-edit {
            background: #76553aff;
            color: white;
        }
        .btn-delete {
            background: #9f704eff;
            color: white;
        }
        .btn-cancel {
            background: #76553aff;
            color: white;
        }
        
        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                text-align: center;
            }
            .data-table {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Admin Panel - CRUD Menu</h1>
            <div>
                <a href="index.php" class="btn btn-primary" style="margin-right:10px;">Lihat Website</a>
                <a href="?logout" class="btn btn-outline">Logout</a>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="message <?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="form-section">
            <h2><?= $editData ? 'Edit Menu' : 'Tambah Menu Baru' ?></h2>
            <form method="POST" onsubmit="return validateForm()">
                <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
                
                <div class="form-group">
                    <label>Menu Key (ID unik, lowercase, no space)</label>
                    <input type="text" name="menu_key" id="menu_key" 
                           value="<?= $editData['menu_key'] ?? '' ?>" 
                           placeholder="contoh: cappuccino, cookies" 
                           required>
                    <div class="form-hint">Gunakan huruf kecil tanpa spasi, contoh: cappuccino, chocolate_cake</div>
                </div>

                <div class="form-group">
                    <label>Nama Menu</label>
                    <input type="text" name="title" id="title" 
                           value="<?= $editData['title'] ?? '' ?>" 
                           placeholder="contoh: Cappuccino" 
                           required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category" id="category" required>
                        <option value="coffee" <?= ($editData['category'] ?? '') === 'coffee' ? 'selected' : '' ?>>Coffee</option>
                        <option value="snacks" <?= ($editData['category'] ?? '') === 'snacks' ? 'selected' : '' ?>>Snacks</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" id="price" 
                           value="<?= $editData['price'] ?? '' ?>" 
                           placeholder="contoh: 25000" 
                           min="1000" 
                           required>
                </div>

                <div class="form-group">
                    <label>URL Gambar</label>
                    <input type="text" name="image" id="image" 
                           value="<?= $editData['image'] ?? '' ?>" 
                           placeholder="assets/images/nama_gambar.jpg" 
                           required>
                    <div class="form-hint">Upload gambar ke folder assets/images/ lalu masukkan path-nya di sini</div>
                </div>

                <div class="form-group">
                    <label>Deskripsi / Detail Menu</label>
                    <textarea name="description" id="description" required><?= $editData['description'] ?? '' ?></textarea>
                    <div class="form-hint">Jelaskan detail menu, bahan, atau keunikan produk</div>
                </div>

                <div style="margin-top: 25px;">
                    <button type="submit" name="save" class="btn btn-primary">
                        <?= $editData ? 'Update Menu' : 'Simpan Menu' ?>
                    </button>
                    
                    <?php if ($editData): ?>
                        <a href="admin.php" class="btn btn-small btn-cancel">❌ Batal</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="data-table">
            <h2>Daftar Menu (<?= count($menus) ?>)</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Menu Key</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($menus)): ?>
                        <tr>
                            <td colspan="8" style="text-align:center;padding:30px;color:#999;">
                                Belum ada data menu. Silakan tambahkan menu baru!
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($menus as $menu): ?>
                            <tr>
                                <td><?= $menu['id'] ?></td>
                                <td>
                                    <img src="<?= htmlspecialchars($menu['image']) ?>" 
                                         alt="<?= htmlspecialchars($menu['title']) ?>" 
                                         class="menu-img"
                                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22%3E%3Crect fill=%22%23ddd%22 width=%2260%22 height=%2260%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%23999%22%3ENo Image%3C/text%3E%3C/svg%3E'">
                                </td>
                                <td><code><?= htmlspecialchars($menu['menu_key']) ?></code></td>
                                <td><strong><?= htmlspecialchars($menu['title']) ?></strong></td>
                                <td>
                                    <span class="category-badge badge-<?= $menu['category'] ?>">
                                        <?= ucfirst($menu['category']) ?>
                                    </span>
                                </td>
                                <td>Rp <?= number_format($menu['price'], 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars(substr($menu['description'], 0, 50)) ?>...</td>
                                <td>
                                    <a href="?edit=<?= $menu['id'] ?>" class="btn-small btn-edit">Edit</a>
                                    <a href="?delete=<?= $menu['id'] ?>" 
                                       class="btn-small btn-delete"
                                       onclick="return confirm('Yakin ingin menghapus menu <?= htmlspecialchars($menu['title']) ?>?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div style="text-align:center;margin-top:30px;padding:20px;">
            <p style="color:#666;">© 2025 Brew & Co. Admin Panel</p>
        </div>
    </div>

    <script>
        function validateForm() {
            const menuKey = document.getElementById('menu_key').value.trim();
            const title = document.getElementById('title').value.trim();
            const price = parseInt(document.getElementById('price').value);
            const image = document.getElementById('image').value.trim();
            const description = document.getElementById('description').value.trim();

            if (!/^[a-z0-9_]+$/.test(menuKey)) {
                alert('Menu Key harus lowercase tanpa spasi!\nGunakan underscore (_) untuk memisahkan kata.\nContoh: chocolate_cake');
                return false;
            }

            if (!title) {
                alert('Nama menu harus diisi!');
                return false;
            }

            if (price < 1000) {
                alert('Harga minimal Rp 1.000!');
                return false;
            }

            if (!image) {
                alert('URL gambar harus diisi!');
                return false;
            }

            if (description.length < 10) {
                alert('Deskripsi minimal 10 karakter!');
                return false;
            }

            return true;
        }

        document.getElementById('title').addEventListener('input', function(e) {
            const menuKeyInput = document.getElementById('menu_key');
            if (!menuKeyInput.value || menuKeyInput.dataset.auto !== 'false') {
                const menuKey = e.target.value
                    .toLowerCase()
                    .replace(/\s+/g, '_')
                    .replace(/[^a-z0-9_]/g, '');
                menuKeyInput.value = menuKey;
            }
        });

        document.getElementById('menu_key').addEventListener('input', function() {
            this.dataset.auto = 'false';
        });

        const message = document.querySelector('.message');
        if (message) {
            setTimeout(() => {
                message.style.opacity = '0';
                message.style.transform = 'translateY(-10px)';
                setTimeout(() => message.remove(), 300);
            }, 5000);
        }
    </script>
</body>
</html>