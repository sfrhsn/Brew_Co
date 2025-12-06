<?php
// ===================================================
// Footer Template
// ===================================================
?>

<footer class="footer">
    <p>&copy; 2025 Brew & Co. All rights reserved.</p>
</footer>

<div id="memberModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('memberModal')">&times;</span>
        <h3>Our Team</h3>
        <div id="memberGrid" class="member-grid"></div>
    </div>
</div>

<div id="menuModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('menuModal')">&times;</span>
        <img id="modalImage" src="" alt="Gambar Detail Menu">
        <h3 id="modalTitle"></h3>
        <ul id="modalInfo"></ul>
    </div>
</div>

<div id="authModal" class="modal">
    <div class="modal-content auth-modal-content">
        <span class="close-btn" onclick="closeModal('authModal')">&times;</span>
        
        <div id="loginForm" class="auth-form">
            <h3>Login</h3>
            <input type="email" id="loginEmail" placeholder="Email" required>
            <input type="password" id="loginPassword" placeholder="Password" required>
            <button class="btn btn-primary" onclick="handleLogin()">Login</button>
            <p class="auth-switch">Belum punya akun? <a href="#" onclick="switchToSignup()">Sign Up</a></p>
        </div>

        <div id="signupForm" class="auth-form" style="display:none;">
            <h3>Sign Up</h3>
            <input type="text" id="signupUsername" placeholder="Username" required>
            <input type="email" id="signupEmail" placeholder="Email" required>
            <input type="password" id="signupPassword" placeholder="Password" required>
            <button class="btn btn-primary" onclick="handleSignup()">Sign Up</button>
            <p class="auth-switch">Sudah punya akun? <a href="#" onclick="switchToLogin()">Login</a></p>
        </div>
    </div>
</div>

<div id="cartModal" class="modal">
    <div class="modal-content cart-modal-content">
        <span class="close-btn" onclick="closeModal('cartModal')">&times;</span>
        
        <div class="cart-tabs">
            <button class="cart-tab active" onclick="showCartTab('current')">Keranjang</button>
            <button class="cart-tab" onclick="showCartTab('history')">Riwayat</button>
        </div>

        <div id="currentCart" class="cart-content">
            <h3>Keranjang Belanja</h3>
            <div id="cartItems" class="cart-items-container"></div>
            
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span id="cartSubtotal">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span>Ongkir:</span>
                    <span id="cartShipping">Rp 0</span>
                </div>
                <div class="summary-row total-row">
                    <strong>Total:</strong>
                    <strong id="cartTotalPrice">Rp 0</strong>
                </div>
            </div>
            
            <button class="btn btn-primary btn-checkout" onclick="showCheckoutForm()" id="checkoutBtn">Checkout</button>

            <div id="checkoutForm" style="display:none;">
                <h4>Informasi Pengiriman</h4>
                
                <div class="form-group">
                    <label for="phoneNumber">Nomor Telepon <span class="required">*</span></label>
                    <input type="tel" id="phoneNumber" placeholder="Contoh: 081234567890" maxlength="15" required>
                    <small class="form-hint">Format: 08xxxxxxxxxx</small>
                </div>

                <div class="form-group">
                    <label for="fullAddress">Alamat Lengkap <span class="required">*</span></label>
                    <textarea id="fullAddress" placeholder="Masukkan alamat lengkap" rows="3" required></textarea>
                    <small class="form-hint">Contoh: Jl. Ketintang No. 123, RT 02/RW 05, Ketintang, Gayungan</small>
                </div>

                <div class="form-group">
                    <label for="addressDetail">Detail Tambahan (Opsional)</label>
                    <textarea id="addressDetail" placeholder="Patokan, warna rumah, atau catatan khusus untuk kurir" rows="2"></textarea>
                    <small class="form-hint">Contoh: Rumah cat putih, dekat Indomaret</small>
                </div>
                
                <div class="shipping-info">
                    <div class="shipping-header">
                        <h5>Informasi Pengiriman</h5>
                    </div>
                    <p class="shipping-note">Biaya ongkir akan dihitung otomatis berdasarkan jarak dari cafe ke alamat Anda</p>
                    <p class="shipping-rate">Tarif: <strong>Rp 1.000 per kilometer</strong></p>
                    
                    <div class="shipping-calculation">
                        <div class="shipping-row">
                            <span class="shipping-label">Estimasi Jarak:</span>
                            <span class="shipping-value" id="estimatedDistance">- km</span>
                        </div>
                        <div class="shipping-row highlight">
                            <span class="shipping-label">Biaya Ongkir:</span>
                            <span class="shipping-value" id="shippingCostDisplay">Rp 0</span>
                        </div>
                    </div>
                </div>

                <div class="payment-method-info">
                    <h5>Metode Pembayaran</h5>
                    <div class="payment-badge">
                        <span class="payment-icon">💵</span>
                        <span class="payment-text">Cash on Delivery (COD)</span>
                    </div>
                    <p class="payment-note">Pembayaran dilakukan saat pesanan sampai</p>
                </div>
                
                <button class="btn btn-primary btn-complete-order" onclick="completeOrder()">
                    <span class="btn-icon"></span>
                    Selesaikan Pesanan (COD)
                </button>
            </div>
        </div>

        <div id="historyCart" class="cart-content" style="display:none;">
            <h3>Riwayat Pemesanan</h3>
            <div id="orderHistory"></div>
        </div>
    </div>
</div>

<div id="reviewsModal" class="modal">
    <div class="modal-content reviews-modal-content">
        <span class="close-btn" onclick="closeModal('reviewsModal')">&times;</span>
        <h3>Semua Ulasan Pelanggan</h3>
        <div id="allReviewsList" class="all-reviews-list"></div>
    </div>
</div>

<div id="orderDetailModal" class="modal">
    <div class="modal-content order-detail-modal-content">
        <span class="close-btn" onclick="closeModal('orderDetailModal')">&times;</span>
        <div id="orderDetailContent"></div>
    </div>
</div>

<script src="assets/Script.js"></script>

</body>
</html>