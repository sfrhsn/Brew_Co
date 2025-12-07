<?php

$host = 'localhost';
$dbname = 'brew_co';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("SELECT * FROM menu WHERE category = 'coffee' ORDER BY id ASC");
    $stmt->execute();
    $coffeeMenus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->prepare("SELECT * FROM menu WHERE category = 'snacks' ORDER BY id ASC");
    $stmt->execute();
    $snacksMenus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    $coffeeMenus = [];
    $snacksMenus = [];
}

$pageTitle = 'Home';
require_once 'includes/functions.php'; 
require_once 'includes/header.php';
?>

<main>
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Crafted With Passion</h1>
            <p>Experience the perfect blend of artisanal coffee and warm hospitality</p>
            <div class="hero-buttons">
                <a href="#menu" class="btn btn-primary">Explore Menu</a>
                <a href="https://www.google.com/maps/place/Ketintang,+Gayungan,+Surabaya" target="_blank" class="btn btn-outline">Our Location</a>
            </div>
        </div>
    </section>

    <div id="welcomeSection" class="welcome-section">
        <h2 class="welcome-title">Selamat Datang, <span id="userName"><?= isLoggedIn() ? getCurrentUser()['username'] : 'Guest' ?></span>!</h2>
        <p id="welcomeMessage">
            <?= isLoggedIn() ? 'Kami senang Anda kembali! Jelajahi menu kami dan temukan kopi favorit Anda hari ini.' : 'Silakan login untuk menikmati pengalaman berbelanja yang lebih baik!' ?>
        </p>
    </div>

    <section id="menu" class="menu-section">
        <h2>Our Menu</h2>
        <p class="subtitle">Nikmatin berbagai pilihan kopi premium dan camilan lezat yang udah kami racik khusus buat kamu!</p>

        <div class="menu-toggle">
            <button id="btnCoffee" class="active" onclick="showCategory('coffee')">Coffee</button>
            <button id="btnSnacks" onclick="showCategory('snacks')">Snacks</button>
        </div>

        <div class="menu-wrapper">
            <button class="scroll-btn left" onclick="scrollMenu(-1)">&#10094;</button>

            <div class="menu-gallery" id="coffeeMenu">
                <?php if (empty($coffeeMenus)): ?>
                    <div style="text-align:center;padding:50px;width:100%;color:#999;">
                        <p>Belum ada menu coffee. Silakan tambahkan dari Admin Panel.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($coffeeMenus as $menu): ?>
                        <div class="menu-item" onclick="openModalDynamic('<?= $menu['menu_key'] ?>')">
                            <img src="<?= htmlspecialchars($menu['image']) ?>" 
                                alt="<?= htmlspecialchars($menu['title']) ?>"
                                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22220%22 height=%22200%22%3E%3Crect fill=%22%23ddd%22 width=%22220%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%23999%22%3ENo Image%3C/text%3E%3C/svg%3E'">
                            <p><?= htmlspecialchars($menu['title']) ?></p>
                            <span class="menu-price">Rp <?= number_format($menu['price'], 0, ',', '.') ?></span>
                            <button class="add-to-cart" onclick="addToCartDynamic('<?= $menu['menu_key'] ?>', event)">+</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="menu-gallery" id="snackMenu" style="display:none;">
                <?php if (empty($snacksMenus)): ?>
                    <div style="text-align:center;padding:50px;width:100%;color:#999;">
                        <p>Belum ada menu snacks. Silakan tambahkan dari Admin Panel.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($snacksMenus as $menu): ?>
                        <div class="menu-item" onclick="openModalDynamic('<?= $menu['menu_key'] ?>')">
                            <img src="<?= htmlspecialchars($menu['image']) ?>" 
                                alt="<?= htmlspecialchars($menu['title']) ?>"
                                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22220%22 height=%22200%22%3E%3Crect fill=%22%23ddd%22 width=%22220%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%23999%22%3ENo Image%3C/text%3E%3C/svg%3E'">
                            <p><?= htmlspecialchars($menu['title']) ?></p>
                            <span class="menu-price">Rp <?= number_format($menu['price'], 0, ',', '.') ?></span>
                            <button class="add-to-cart" onclick="addToCartDynamic('<?= $menu['menu_key'] ?>', event)">+</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <button class="scroll-btn right" onclick="scrollMenu(1)">&#10095;</button>
        </div>
    </section>

    <section class="about-section" id="about">
        <div class="about-content">
            <div class="about-text">
                <h2>About Our Coffee</h2>
                <p>Di Brew & Co, kami percaya bahwa kopi yang enak berawal dari biji kopi yang berkualitas. Kami mendapatkan biji kopi langsung dari petani berkelanjutan, supaya tetap terjamin kualitas dan praktik etisnya.</p>
                <p>Barista kami ahli dalam meracik kopi, mampu menghadirkan cita rasa dan aroma khas di setiap cangkir. Mau kamu suka espresso yang kuat atau latte yang lembut, setiap minuman kami buat dengan ketelitian dan sepenuh hati.</p>
                <button class="btn btn-primary btn-member" onclick="openMemberModal()">Anggota Kami</button>
            </div>
            <div class="about-image">
                <img src="assets/images/coffeshop.jpg" alt="Suasana di dalam Coffee Shop Brew & Co.">
            </div>
        </div>
    </section>

    <section id="reviews" class="reviews-form-section">
        <h2>Tulis Ulasan Anda</h2>
        <p class="subtitle">Bagikan pengalaman Anda di Brew & Co. bersama pelanggan lainnya!</p>
        
        <div class="review-form-container">
            <div class="rating-input">
                <label>Rating Anda:</label>
                <div class="star-rating" id="starRating">
                    <span class="star" data-rating="1">☆</span>
                    <span class="star" data-rating="2">☆</span>
                    <span class="star" data-rating="3">☆</span>
                    <span class="star" data-rating="4">☆</span>
                    <span class="star" data-rating="5">☆</span>
                </div>
            </div>
        
            <input type="text" id="reviewerName" placeholder="Nama Anda" required>
            <textarea id="reviewText" placeholder="Tulis ulasan Anda di sini..." rows="4" required></textarea>
            <button class="btn btn-primary" onclick="submitReview()">Kirim Ulasan</button>
        </div>
    </section>

    <section id="testimonials" class="testimonials-section">
        <h2>What Our Customers Say</h2>
        <p class="subtitle">Jangan cuma percaya omongan kita - dengerin aja cerita dari pelanggan setia Brew & Co. tentang pengalaman mereka di sini!</p>
        
        <div class="testimonials-wrapper">
            <button class="scroll-btn left" onclick="scrollReviews(-1)">&#10094;</button>
            
            <div class="testimonials-grid" id="testimonialsScroll">
            </div>
            
            <button class="scroll-btn right" onclick="scrollReviews(1)">&#10095;</button>
        </div>
    </section>

    <section id="contact" class="contact-section">
        <h2>Visit Us</h2>
        <p class="subtitle">Datang langsung ke kedai kami dan rasakan secangkir kopi yang sempurna di suasana yang hangat dan ramah.</p>
        <div class="contact-info">
            <div class="info-item">
                <h3>Location</h3>
                <p>Ketintang, Gayungan, Jawa timur<br>(60231)</p>
            </div>
            <div class="info-item">
                <h3>Hours</h3>
                <p>Mon–Fri: 7am – 8pm<br>Sat–Sun: 8am – 9pm</p>
            </div>
            <div class="info-item">
                <h3>Contact</h3>
                <p>+6281358845236<br>firdaagustina@gmail.com</p>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>

