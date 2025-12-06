<?php
// ===================================================
// Home Page
// ===================================================

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
                <div class="menu-item" onclick="openModal('espresso')">
                    <img src="assets/images/espresso.jpg" alt="Espresso">
                    <p>Espresso</p>
                    <span class="menu-price">Rp 15.000</span>
                    <button class="add-to-cart" onclick="addToCart('espresso', event)">+</button>
                </div>
                <div class="menu-item" onclick="openModal('latte')">
                    <img src="assets/images/latte.jpg" alt="Latte">
                    <p>Latte</p>
                    <span class="menu-price">Rp 20.000</span>
                    <button class="add-to-cart" onclick="addToCart('latte', event)">+</button>
                </div>
                <div class="menu-item" onclick="openModal('cappuccino')">
                    <img src="assets/images/capucino.jpg" alt="Cappuccino">
                    <p>Cappuccino</p>
                    <span class="menu-price">Rp 22.000</span>
                    <button class="add-to-cart" onclick="addToCart('cappuccino', event)">+</button>
                </div>
                <div class="menu-item" onclick="openModal('mocha')">
                    <img src="assets/images/mocha.jpg" alt="Mocha">
                    <p>Mocha</p>
                    <span class="menu-price">Rp 23.000</span>
                    <button class="add-to-cart" onclick="addToCart('mocha', event)">+</button>
                </div>
                <div class="menu-item" onclick="openModal('americano')">
                    <img src="assets/images/americano.jpg" alt="Americano">
                    <p>Americano</p>
                    <span class="menu-price">Rp 28.000</span>
                    <button class="add-to-cart" onclick="addToCart('americano', event)">+</button>
                </div>
                <div class="menu-item" onclick="openModal('matcha')">
                    <img src="assets/images/matcha.jpg" alt="Matcha">
                    <p>Matcha</p>
                    <span class="menu-price">Rp 23.000</span>
                    <button class="add-to-cart" onclick="addToCart('matcha', event)">+</button>
                </div>
                <div class="menu-item" onclick="openModal('coldbrew')">
                    <img src="assets/images/coldbrew.jpg" alt="Cold Brew">
                    <p>Cold Brew</p>
                    <span class="menu-price">Rp 27.000</span>
                    <button class="add-to-cart" onclick="addToCart('coldbrew', event)">+</button>
                </div>
            </div>

            <div class="menu-gallery" id="snackMenu" style="display:none;">
                <div class="menu-item" onclick="openModal('brownies')">
                    <img src="assets/images/Brownies.jpg" alt="Brownies">
                    <p>Brownies</p>
                    <span class="menu-price">Rp 20.000</span>
                    <button class="add-to-cart" onclick="addToCart('brownies', event)">+</button>
                </div>      
                <div class="menu-item" onclick="openModal('cookies')">
                    <img src="assets/images/Cookies.jpg" alt="Cookies">
                    <p>Cookies</p>
                    <span class="menu-price">Rp 15.000</span>
                    <button class="add-to-cart" onclick="addToCart('cookies', event)">+</button>
                </div>
                <div class="menu-item" onclick="openModal('croissant')">
                    <img src="assets/images/Croissant.jpg" alt="Croissant">
                    <p>Croissant</p>
                    <span class="menu-price">Rp 22.000</span>
                    <button class="add-to-cart" onclick="addToCart('croissant', event)">+</button>
                </div>
                <div class="menu-item" onclick="openModal('fries')">
                    <img src="assets/images/FrenchFries.jpg" alt="French Fries">
                    <p>French Fries</p>
                    <span class="menu-price">Rp 14.000</span>
                    <button class="add-to-cart" onclick="addToCart('fries', event)">+</button>
                </div>
                <div class="menu-item" onclick="openModal('onionrings')">
                    <img src="assets/images/Onionrings.jpg" alt="Onion Rings">
                    <p>Onion Rings</p>
                    <span class="menu-price">Rp 10.000</span>
                    <button class="add-to-cart" onclick="addToCart('onionrings', event)">+</button>
                </div>
                <div class="menu-item" onclick="openModal('nugget')">
                    <img src="assets/images/Nugget.jpg" alt="Nugget">
                    <p>Nugget</p>
                    <span class="menu-price">Rp 14.000</span>
                    <button class="add-to-cart" onclick="addToCart('nugget', event)">+</button>
                </div>
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