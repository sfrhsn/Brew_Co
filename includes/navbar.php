<?php
?>
<header>
    <nav class="navbar">
        <div class="logo">Brew & Co.</div>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="nav-links">
            <ul class="nav-left">
                <li><a href="index.php#home">Home</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="index.php#testimonials">Testimonials</a></li>
                <li><a href="index.php#contact">Contact</a></li>
            </ul>
            <div class="nav-actions">
                <button class="cart-icon-btn" onclick="openCartModal()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-badge" id="cartBadge">0</span>
                </button>
                <button class="login-btn" onclick="openAuthModal()" id="authBtn">Login</button>
            </div>
        </div>
    </nav>
</header>