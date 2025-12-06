// ===================================================
// SCRIPT.JS - BREW & CO COFFEE SHOP
// Part 1: Core Functions, Authentication & Cart
// ===================================================

// Global Variables
window.currentUser = null;
window.cart = [];
window.orderHistory = [];
window.shippingCost = 0;
window.estimatedDistance = 0;
window.currentCategory = 'coffee';

// Menu Details Data
window.menuDetails = {
    espresso: { title: "Espresso", image: "assets/images/espresso.jpg", price: 15000, info: ["Kopi murni dengan cita rasa kuat dan pekat.", "Diseduh menggunakan tekanan tinggi tanpa campuran.", "Cocok untuk penikmat kopi sejati yang menyukai rasa bold."] },
    latte: { title: "Latte", image: "assets/images/latte.jpg", price: 20000, info: ["Campuran espresso dan susu steamed yang creamy.", "Memiliki lapisan foam tipis di bagian atas.", "Favorit bagi pecinta rasa lembut dan seimbang."] },
    cappuccino: { title: "Cappuccino", image: "assets/images/capucino.jpg", price: 22000, info: ["Perpaduan espresso, susu steamed, dan busa foam tebal.", "Rasa seimbang antara pahit dan lembut.", "Cocok diminum pagi hari untuk energi ekstra."] },
    mocha: { title: "Mocha", image: "assets/images/mocha.jpg", price: 23000, info: ["Kombinasi espresso, susu, dan cokelat murni.", "Rasa manis berpadu dengan aroma kopi pekat.", "Pilihan ideal untuk kamu yang suka kopi dengan sentuhan coklat."] },
    americano: { title: "Americano", image: "assets/images/americano.jpg", price: 28000, info: ["Espresso yang dicampur air panas.", "Rasa ringan dengan aroma kopi yang kuat.", "Sering dinikmati tanpa tambahan gula atau susu."] },
    matcha: { title: "Matcha Latte", image: "assets/images/matcha.jpg", price: 23000, info: ["Perpaduan bubuk matcha Jepang dan susu steamed.", "Rasa earthy yang khas dengan aroma lembut.", "Disajikan panas atau dingin sesuai selera."] },
    coldbrew: { title: "Cold Brew", image: "assets/images/coldbrew.jpg", price: 27000, info: ["Kopi diseduh dengan air dingin selama 12-18 jam.", "Rasa lebih halus dan tidak terlalu asam.", "Cocok dinikmati dingin untuk hari yang panas."] },
    brownies: { title: "Brownies", image: "assets/images/Brownies.jpg", price: 20000, info: ["Cokelat brownies lembut dengan aroma butter.", "Tekstur fudgy dan manis seimbang.", "Paling nikmat disajikan dengan kopi espresso."] },
    cookies: { title: "Cookies", image: "assets/images/Cookies.jpg", price: 15000, info: ["Kue renyah dengan taburan chocochips premium.", "Rasa gurih mentega dan manis cokelat berpadu sempurna.", "Cocok sebagai teman ngobrol di sore hari."] },
    croissant: { title: "Croissant", image: "assets/images/Croissant.jpg", price: 22000, info: ["Roti Prancis berlapis dengan tekstur flaky dan lembut.", "Dibuat dari adonan mentega berkualitas tinggi.", "Lezat disantap bersama kopi latte atau teh hangat."] },
    fries: { title: "French Fries", image: "assets/images/FrenchFries.jpg", price: 14000, info: ["Kentang goreng renyah di luar, lembut di dalam.", "Dibumbui ringan dengan garam dan herbs.", "Cocok untuk camilan santai atau teman minum kopi."] },
    onionrings: { title: "Onion Rings", image: "assets/images/Onionrings.jpg", price: 10000, info: ["Irisan bawang besar dilapisi tepung crispy.", "Rasa gurih dan sedikit manis alami.", "Paling enak dengan saus keju atau mayones."] },
    nugget: { title: "Nugget", image: "assets/images/Nugget.jpg", price: 14000, info: ["Potongan ayam dibalut tepung renyah.", "Dimasak hingga keemasan dan gurih.", "Sajikan hangat untuk rasa terbaik."] }
};

// Member Details Data
window.memberDetails = [
    { name: "Firda Agustina", image: "assets/images/Firda.JPEG" },
    { name: "Mochammad Dzaky", image: "assets/images/Adit.JPEG" },
    { name: "Risda Sifa Hasna", image: "assets/images/Risda.jpg" }
];

// Cafe Location
window.cafeLocation = { lat: -7.3289, lng: 112.7278 };

// ===================================================
// LOAD DATA FROM SERVER
// ===================================================

async function loadUserData() {
    try {
        const response = await fetch('handlers/auth_handler.php', {
            method: 'POST',
            body: new URLSearchParams({ action: 'check_session' })
        });
        
        const data = await response.json();
        
        if (data.success && data.user) {
            window.currentUser = data.user;
            await loadCart();
            await loadOrderHistory();
        } else {
            window.currentUser = null;
            window.cart = [];
            window.orderHistory = [];
        }
        
        window.shippingCost = 0;
        window.estimatedDistance = 0;
        
        updateUIAfterLogin();
        updateCartBadge();
        
        console.log('Data loaded for user:', window.currentUser?.username || 'guest');
    } catch (error) {
        console.error('Error loading user data:', error);
        window.currentUser = null;
        window.cart = [];
        window.orderHistory = [];
    }
}

async function loadCart() {
    try {
        const response = await fetch('handlers/cart_handler.php', {
            method: 'POST',
            body: new URLSearchParams({ action: 'get' })
        });
        
        const data = await response.json();
        window.cart = data.success ? data.cart : [];
        console.log('Cart items:', window.cart.length);
    } catch (error) {
        console.error('Error loading cart:', error);
        window.cart = [];
    }
}

async function loadOrderHistory() {
    try {
        const response = await fetch('handlers/order_handler.php', {
            method: 'POST',
            body: new URLSearchParams({ action: 'get_history' })
        });
        
        const data = await response.json();
        window.orderHistory = data.success ? data.orders : [];
        console.log('Order history:', window.orderHistory.length);
    } catch (error) {
        console.error('Error loading order history:', error);
        window.orderHistory = [];
    }
}

// ===================================================
// AUTHENTICATION FUNCTIONS
// ===================================================

window.openAuthModal = async function() {
    if (window.currentUser) {
        if (confirm('Logout dari akun ' + window.currentUser.username + '?')) {
            try {
                await fetch('handlers/auth_handler.php', {
                    method: 'POST',
                    body: new URLSearchParams({ action: 'logout' })
                });
                
                window.currentUser = null;
                window.cart = [];
                window.orderHistory = [];
                updateUIAfterLogin();
                updateCartBadge();
                alert('Logout berhasil!');
            } catch (error) {
                console.error('Error logout:', error);
            }
        }
    } else {
        const modal = document.getElementById('authModal');
        modal.style.display = 'flex';
        document.body.classList.add('modal-open');
    }
};

window.switchToSignup = function() {
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('signupForm').style.display = 'block';
};

window.switchToLogin = function() {
    document.getElementById('signupForm').style.display = 'none';
    document.getElementById('loginForm').style.display = 'block';
};

window.handleLogin = async function() {
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    if (!email || !password) {
        alert('Mohon isi semua field!');
        return;
    }

    try {
        const response = await fetch('handlers/auth_handler.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'login',
                email: email,
                password: password
            })
        });

        const data = await response.json();

        if (data.success) {
            window.currentUser = data.user;
            
            await loadCart();
            await loadOrderHistory();
            
            document.getElementById('loginEmail').value = '';
            document.getElementById('loginPassword').value = '';
            
            const authModal = document.getElementById('authModal');
            authModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            
            updateUIAfterLogin();
            updateCartBadge();
            
            alert('Login berhasil! Selamat datang, ' + data.user.username + '!');
        } else {
            alert(data.message || 'Email atau password salah!');
        }
    } catch (error) {
        console.error('Error login:', error);
        alert('Terjadi kesalahan saat login!');
    }
};

window.handleSignup = async function() {
    const username = document.getElementById('signupUsername').value;
    const email = document.getElementById('signupEmail').value;
    const password = document.getElementById('signupPassword').value;

    if (!username || !email || !password) {
        alert('Mohon isi semua field!');
        return;
    }

    try {
        const response = await fetch('handlers/auth_handler.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'signup',
                username: username,
                email: email,
                password: password
            })
        });

        const data = await response.json();

        if (data.success) {
            alert('Akun berhasil dibuat! Silakan login.');
            window.switchToLogin();
        } else {
            alert(data.message || 'Gagal membuat akun!');
        }
    } catch (error) {
        console.error('Error signup:', error);
        alert('Terjadi kesalahan saat membuat akun!');
    }
};

function updateUIAfterLogin() {
    const authBtn = document.getElementById('authBtn');
    const userName = document.getElementById('userName');
    const welcomeMsg = document.getElementById('welcomeMessage');
    const welcomeSection = document.getElementById('welcomeSection');

    if (window.currentUser) {
        authBtn.textContent = 'Logout';
        userName.textContent = window.currentUser.username;
        welcomeMsg.textContent = 'Kami senang Anda kembali! Jelajahi menu kami dan temukan kopi favorit Anda hari ini.';
        welcomeSection.classList.add('show');
    } else {
        authBtn.textContent = 'Login';
        userName.textContent = 'Guest';
        welcomeMsg.textContent = 'Silakan login untuk menikmati pengalaman berbelanja yang lebih baik!';
        welcomeSection.classList.remove('show');
    }
}

function updateCartBadge() {
    const badge = document.getElementById('cartBadge');
    const totalItems = window.cart.reduce((sum, item) => sum + item.quantity, 0);
    badge.textContent = totalItems;
}

// ===================================================
// CART FUNCTIONS
// ===================================================

window.addToCart = async function(menuKey, event) {
    if (event) event.stopPropagation();

    if (!window.currentUser) {
        alert('Silakan login terlebih dahulu untuk menambah ke keranjang!');
        window.openAuthModal();
        return;
    }

    const item = window.menuDetails[menuKey];

    try {
        const response = await fetch('handlers/cart_handler.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'add',
                menu_key: menuKey,
                title: item.title,
                price: item.price,
                quantity: 1
            })
        });

        const data = await response.json();

        if (data.success) {
            window.cart = data.cart;
            updateCartBadge();
            alert(item.title + ' ditambahkan ke keranjang!');
        } else {
            alert(data.message || 'Gagal menambahkan ke keranjang!');
        }
    } catch (error) {
        console.error('Error add to cart:', error);
        alert('Terjadi kesalahan!');
    }
};

window.openCartModal = async function() {
    if (!window.currentUser) {
        alert('Silakan login terlebih dahulu!');
        window.openAuthModal();
        return;
    }

    await loadCart();

    const modal = document.getElementById('cartModal');
    modal.style.display = 'flex';
    document.body.classList.add('modal-open');
    
    const tabs = document.querySelectorAll('.cart-tab');
    tabs.forEach(t => t.classList.remove('active'));
    tabs[0].classList.add('active');
    
    document.getElementById('currentCart').style.display = 'block';
    document.getElementById('historyCart').style.display = 'none';
    
    renderCart();
};

window.showCartTab = async function(tab) {
    const tabs = document.querySelectorAll('.cart-tab');
    tabs.forEach(t => t.classList.remove('active'));
    
    if (tab === 'current') {
        tabs[0].classList.add('active');
        document.getElementById('currentCart').style.display = 'block';
        document.getElementById('historyCart').style.display = 'none';
        await loadCart();
        renderCart();
    } else {
        tabs[1].classList.add('active');
        document.getElementById('currentCart').style.display = 'none';
        document.getElementById('historyCart').style.display = 'block';
        await loadOrderHistory();
        window.renderOrderHistory();
    }
};

window.renderCart = function() {
    const cartItemsDiv = document.getElementById('cartItems');
    const subtotalSpan = document.getElementById('cartSubtotal');
    const shippingSpan = document.getElementById('cartShipping');
    const totalPriceSpan = document.getElementById('cartTotalPrice');

    if (window.cart.length === 0) {
        cartItemsDiv.innerHTML = '<div class="empty-message">Keranjang masih kosong</div>';
        subtotalSpan.textContent = 'Rp 0';
        shippingSpan.textContent = 'Rp 0';
        totalPriceSpan.textContent = 'Rp 0';
        document.getElementById('checkoutBtn').style.display = 'none';
        return;
    }

    document.getElementById('checkoutBtn').style.display = 'block';
    let subtotal = 0;
    let html = '';

    window.cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        html += `
            <div class="cart-item">
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.title}</div>
                    <div class="cart-item-price">Rp ${item.price.toLocaleString('id-ID')} x ${item.quantity}</div>
                </div>
                <div class="cart-item-quantity">
                    <button class="qty-btn" onclick="updateQuantity(${index}, -1)">-</button>
                    <span>${item.quantity}</span>
                    <button class="qty-btn" onclick="updateQuantity(${index}, 1)">+</button>
                </div>
            </div>
        `;
    });

    cartItemsDiv.innerHTML = html;
    
    const total = subtotal + window.shippingCost;
    subtotalSpan.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    shippingSpan.textContent = 'Rp ' + window.shippingCost.toLocaleString('id-ID');
    totalPriceSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');
};

window.updateQuantity = async function(index, change) {
    const item = window.cart[index];
    const newQuantity = item.quantity + change;

    try {
        const response = await fetch('handlers/cart_handler.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'update',
                menu_key: item.key,
                quantity: newQuantity
            })
        });

        const data = await response.json();

        if (data.success) {
            window.cart = data.cart;
            updateCartBadge();
            renderCart();
        }
    } catch (error) {
        console.error('Error update quantity:', error);
    }
};

// Expose utility functions
window.updateUIAfterLogin = updateUIAfterLogin;
window.updateCartBadge = updateCartBadge;
window.loadCart = loadCart;
window.loadOrderHistory = loadOrderHistory;

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', loadUserData);

// ===================================================
// SCRIPT.JS - BREW & CO COFFEE SHOP
// Part 2: Checkout, Orders, Reviews & Menu
// ===================================================

document.addEventListener('DOMContentLoaded', function () {

    // ===================================================
    // SHIPPING CALCULATION
    // ===================================================

    function estimateDistanceFromAddress(address) {
        const addressLower = address.toLowerCase();
        
        if (addressLower.includes('ketintang') || addressLower.includes('gayungan') || 
            addressLower.includes('manyar') || addressLower.includes('ngagel')) {
            return 2;
        }
        else if (addressLower.includes('gubeng') || addressLower.includes('wonokromo') || 
                 addressLower.includes('tegalsari') || addressLower.includes('genteng')) {
            return 5;
        }
        else if (addressLower.includes('rungkut') || addressLower.includes('tenggilis') || 
                 addressLower.includes('wiyung') || addressLower.includes('lakarsantri')) {
            return 10;
        }
        else if (addressLower.includes('benowo') || addressLower.includes('sukolilo') || 
                 addressLower.includes('sambikerep') || addressLower.includes('mulyorejo')) {
            return 15;
        }
        else {
            return 8;
        }
    }

    function calculateShippingFromAddress() {
        const address = document.getElementById('fullAddress').value;
        
        if (!address || address.trim().length < 5) {
            window.shippingCost = 0;
            window.estimatedDistance = 0;
            document.getElementById('estimatedDistance').textContent = '- km';
            document.getElementById('shippingCostDisplay').textContent = 'Rp 0';
            
            if (window.cart && window.cart.length > 0) {
                const subtotal = window.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                document.getElementById('cartSubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                document.getElementById('cartShipping').textContent = 'Rp 0';
                document.getElementById('cartTotalPrice').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            }
            return;
        }

        const distance = estimateDistanceFromAddress(address);
        window.estimatedDistance = distance;
        window.shippingCost = Math.round(distance * 1000);
        
        document.getElementById('estimatedDistance').textContent = distance.toFixed(1) + ' km';
        document.getElementById('shippingCostDisplay').textContent = 'Rp ' + window.shippingCost.toLocaleString('id-ID');
        
        if (window.cart && window.cart.length > 0) {
            const subtotal = window.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const total = subtotal + window.shippingCost;
            
            document.getElementById('cartSubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('cartShipping').textContent = 'Rp ' + window.shippingCost.toLocaleString('id-ID');
            document.getElementById('cartTotalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    }

    // ===================================================
    // CHECKOUT PROCESS
    // ===================================================

    window.showCheckoutForm = function() {
        document.getElementById('checkoutForm').style.display = 'block';
        document.getElementById('checkoutBtn').style.display = 'none';
        
        window.shippingCost = 0;
        window.estimatedDistance = 0;
        document.getElementById('estimatedDistance').textContent = '- km';
        document.getElementById('shippingCostDisplay').textContent = 'Rp 0';
        
        document.getElementById('phoneNumber').value = '';
        document.getElementById('fullAddress').value = '';
        document.getElementById('addressDetail').value = '';
        
        window.renderCart();
    };

    window.completeOrder = async function() {
        const phone = document.getElementById('phoneNumber').value.trim();
        const address = document.getElementById('fullAddress').value.trim();
        const detail = document.getElementById('addressDetail').value.trim();

        if (!phone) {
            alert('Mohon isi nomor telepon!');
            return;
        }

        if (!address || address.length < 10) {
            alert('Mohon isi alamat lengkap (minimal 10 karakter)!');
            return;
        }

        if (window.shippingCost === 0 && address.length >= 5) {
            calculateShippingFromAddress();
        }

        const subtotal = window.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const total = subtotal + window.shippingCost;

        try {
            const response = await fetch('handlers/order_handler.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'create',
                    items: JSON.stringify(window.cart),
                    subtotal: subtotal,
                    shipping: window.shippingCost,
                    distance: window.estimatedDistance,
                    total: total,
                    phone: phone,
                    address: address,
                    detail: detail,
                    payment: 'Cash on Delivery (COD)'
                })
            });

            const data = await response.json();

            if (data.success) {
                await fetch('handlers/cart_handler.php', {
                    method: 'POST',
                    body: new URLSearchParams({ action: 'clear' })
                });

                window.cart = [];
                window.shippingCost = 0;
                window.estimatedDistance = 0;
                
                window.updateCartBadge();

                alert('Pesanan berhasil dibuat!\n\nTotal: Rp ' + total.toLocaleString('id-ID') + '\nPembayaran: Cash on Delivery (COD)\nAlamat: ' + address + '\n\nTerima kasih telah memesan di Brew & Co!');
                
                document.getElementById('phoneNumber').value = '';
                document.getElementById('fullAddress').value = '';
                document.getElementById('addressDetail').value = '';
                document.getElementById('estimatedDistance').textContent = '- km';
                document.getElementById('shippingCostDisplay').textContent = 'Rp 0';
                document.getElementById('checkoutForm').style.display = 'none';
                document.getElementById('checkoutBtn').style.display = 'block';
                
                window.renderCart();
                
                setTimeout(() => {
                    window.showCartTab('history');
                }, 500);
            } else {
                alert(data.message || 'Gagal membuat pesanan!');
            }
        } catch (error) {
            console.error('Error complete order:', error);
            alert('Terjadi kesalahan saat membuat pesanan!');
        }
    };

    // ===================================================
    // ORDER HISTORY
    // ===================================================

    window.renderOrderHistory = function() {
        const historyDiv = document.getElementById('orderHistory');

        console.log('Rendering order history...');
        console.log('Total orders:', window.orderHistory ? window.orderHistory.length : 0);

        if (!window.orderHistory || window.orderHistory.length === 0) {
            historyDiv.innerHTML = '<div class="empty-message">Belum ada riwayat pesanan</div>';
            return;
        }

        let html = '';
        
        [...window.orderHistory].reverse().forEach((order) => {
            html += `
                <div class="order-history-item">
                    <div class="order-success-badge">
                        <span class="badge-icon">🎉</span>
                        <span class="badge-text">Pesanan Berhasil!</span>
                    </div>
                    
                    <div class="order-id-section">
                        <strong>ID Pesanan:</strong> ${order.order_id}
                    </div>
                    
                    <div class="order-date-section">
                        <strong>Tanggal:</strong> ${order.date}
                    </div>
                    
                    <div class="order-divider"></div>
                    
                    <div class="order-section-title">Detail Pesanan:</div>
                    <div class="order-items">
                        ${order.items.map(item => `
                            <div class="order-item-detail">
                                <span>• ${item.title} x${item.quantity}</span>
                                <span>Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</span>
                            </div>
                        `).join('')}
                    </div>
                    
                    <div class="order-summary-section">
                        <div class="order-item-detail">
                            <span><strong>Subtotal Pesanan:</strong></span>
                            <span>Rp ${order.subtotal.toLocaleString('id-ID')}</span>
                        </div>
                        <div class="order-item-detail">
                            <span><strong>Ongkir (${order.distance} km):</strong></span>
                            <span>Rp ${order.shipping.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                    
                    <div class="order-total-section">
                        <strong>Total Harga:</strong> Rp ${order.total.toLocaleString('id-ID')}
                    </div>
                    
                    <div class="order-divider"></div>
                    
                    <div class="order-section-title">Informasi Pengiriman:</div>
                    <div class="order-info-grid">
                        <div class="info-row">
                            <strong>Nama:</strong> ${window.currentUser?.username || 'Guest'}
                        </div>
                        <div class="info-row">
                            <strong>No. Telepon:</strong> ${order.phone}
                        </div>
                        <div class="info-row">
                            <strong>Alamat:</strong> ${order.address}
                        </div>
                        ${order.detail ? `
                            <div class="info-row">
                                <strong>Detail Alamat:</strong> ${order.detail}
                            </div>
                        ` : ''}
                    </div>
                    
                    <div class="order-divider"></div>
                    
                    <div class="order-section-title">Metode Pembayaran:</div>
                    <div class="payment-method-display">
                        ${order.payment}
                    </div>
                </div>
            `;
        });

        historyDiv.innerHTML = html;
        console.log('Order history rendered successfully');
    };

    // ===================================================
    // EVENT LISTENERS FOR SHIPPING
    // ===================================================

    const addressInput = document.getElementById('fullAddress');
    if (addressInput) {
        addressInput.addEventListener('blur', calculateShippingFromAddress);
        
        let typingTimer;
        addressInput.addEventListener('input', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(calculateShippingFromAddress, 1000);
        });
        
        addressInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                calculateShippingFromAddress();
            }
        });
    }

    // ===================================================
    // MENU & MODAL FUNCTIONS
    // ===================================================

    window.openModal = function(menuKey) {
        const item = window.menuDetails[menuKey];
        if (!item) return;

        const modal = document.getElementById("menuModal");
        const modalImg = document.getElementById("modalImage");
        const modalTitle = document.getElementById("modalTitle");
        const modalInfo = document.getElementById("modalInfo");

        modalImg.src = item.image;
        modalImg.alt = item.title;
        modalTitle.textContent = item.title;

        modalInfo.innerHTML = "";
        item.info.forEach(text => {
            const li = document.createElement("li");
            li.textContent = text;
            modalInfo.appendChild(li);
        });

        modal.style.display = "flex";
        document.body.classList.add('modal-open');
    };

    window.openMemberModal = function() {
        const modal = document.getElementById("memberModal");
        const grid = document.getElementById("memberGrid");

        grid.innerHTML = "";
        window.memberDetails.forEach(member => {
            const card = document.createElement("div");
            card.className = "member-card";
            card.innerHTML = `
                <img src="${member.image}" alt="Foto ${member.name}" class="member-image">
                <p class="member-name">${member.name}</p>
                <p class="member-major">Manajemen Informatika</p>
            `;
            grid.appendChild(card);
        });

        modal.style.display = "flex";
        document.body.classList.add('modal-open');
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = "none";
            document.body.classList.remove('modal-open');
            
            if (modalId === 'cartModal') {
                document.getElementById('checkoutForm').style.display = 'none';
                document.getElementById('checkoutBtn').style.display = 'block';
            }
        }
    };

    window.scrollMenu = function(direction) {
        const galleryId = window.currentCategory === 'coffee' ? 'coffeeMenu' : 'snackMenu';
        const gallery = document.getElementById(galleryId);
        if (gallery) {
            const scrollAmount = gallery.clientWidth * 0.8;
            gallery.scrollBy({ left: direction * scrollAmount, behavior: "smooth" });
        }
    };

    window.showCategory = function(category) {
        if (window.currentCategory === category) return;

        const coffeeMenu = document.getElementById("coffeeMenu");
        const snackMenu = document.getElementById("snackMenu");
        const btnCoffee = document.getElementById("btnCoffee");
        const btnSnacks = document.getElementById("btnSnacks");

        const activeMenu = (window.currentCategory === 'coffee') ? coffeeMenu : snackMenu;
        const targetMenu = (category === 'coffee') ? coffeeMenu : snackMenu;

        activeMenu.style.opacity = '0';
        activeMenu.style.transform = 'translateY(10px)';

        setTimeout(() => {
            activeMenu.style.display = 'none';
            targetMenu.style.display = 'flex';
            targetMenu.style.opacity = '0';
            targetMenu.style.transform = 'translateY(10px)';
            
            requestAnimationFrame(() => {
                targetMenu.style.opacity = '1';
                targetMenu.style.transform = 'translateY(0)';
            });

            btnCoffee.classList.toggle('active', category === 'coffee');
            btnSnacks.classList.toggle('active', category === 'snacks');
            window.currentCategory = category;

        }, 400);
    };

    // ===================================================
    // NAVIGATION HANDLERS
    // ===================================================

    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
    }

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            const activeModal = document.querySelector('.modal[style*="display: flex"]');
            if (activeModal) {
                window.closeModal(activeModal.id);
            }
        }
    });

    // ===================================================
    // REVIEWS MANAGEMENT
    // ===================================================

    let userReviews = [];
    let selectedRating = 0;

    async function loadReviews() {
        try {
            const response = await fetch('handlers/review_handler.php', {
                method: 'POST',
                body: new URLSearchParams({ action: 'get' })
            });
            
            const data = await response.json();
            
            if (data.success) {
                userReviews = data.reviews;
                renderReviews();
            }
        } catch (error) {
            console.error('Error loading reviews:', error);
        }
    }

    function highlightStars(rating) {
        const stars = document.querySelectorAll('#starRating .star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.textContent = '★';
                star.classList.add('active');
            } else {
                star.textContent = '☆';
                star.classList.remove('active');
            }
        });
    }

    function updateStarDisplay() {
        const stars = document.querySelectorAll('#starRating .star');
        stars.forEach((star, index) => {
            if (index < selectedRating) {
                star.textContent = '★';
                star.classList.add('active');
            } else {
                star.textContent = '☆';
                star.classList.remove('active');
            }
        });
    }

    const stars = document.querySelectorAll('#starRating .star');
    stars.forEach(star => {
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.getAttribute('data-rating'));
            updateStarDisplay();
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            highlightStars(rating);
        });
    });

    const starRating = document.getElementById('starRating');
    if (starRating) {
        starRating.addEventListener('mouseleave', function() {
            updateStarDisplay();
        });
    }

    window.submitReview = async function() {
        const currentUser = window.currentUser;
        
        if (!currentUser) {
            alert('Silakan login terlebih dahulu untuk menulis ulasan!');
            window.openAuthModal();
            return;
        }

        const name = document.getElementById('reviewerName').value.trim();
        const text = document.getElementById('reviewText').value.trim();

        if (!name) {
            alert('Mohon isi nama Anda!');
            return;
        }

        if (!text) {
            alert('Mohon tulis ulasan Anda!');
            return;
        }

        if (selectedRating === 0) {
            alert('Mohon pilih rating bintang!');
            return;
        }

        try {
            const response = await fetch('handlers/review_handler.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'add',
                    name: name,
                    text: text,
                    rating: selectedRating
                })
            });

            const data = await response.json();

            if (data.success) {
                userReviews = data.reviews;
                renderReviews();

                document.getElementById('reviewerName').value = '';
                document.getElementById('reviewText').value = '';
                selectedRating = 0;
                updateStarDisplay();

                alert('Terima kasih atas ulasan Anda, ' + currentUser.username + '!');
                
                document.getElementById('testimonials').scrollIntoView({ behavior: 'smooth' });
            } else {
                alert(data.message || 'Gagal menambahkan ulasan!');
            }
        } catch (error) {
            console.error('Error submit review:', error);
            alert('Terjadi kesalahan saat menambahkan ulasan!');
        }
    };

    function renderReviews() {
        const grid = document.querySelector('.testimonials-grid');
        if (!grid) return;

        const oldUserReviews = grid.querySelectorAll('.testimonial-card.user-review');
        oldUserReviews.forEach(card => card.remove());

        userReviews.forEach(review => {
            const card = document.createElement('div');
            card.className = 'testimonial-card user-review';
            card.innerHTML = `
                <div class="stars">${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}</div>
                <p class="quote">"${review.text}"</p>
                <div class="author">
                    <img src="image/default_avatar.jpg" alt="Foto ${review.name}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2250%22 height=%2250%22%3E%3Ccircle cx=%2225%22 cy=%2225%22 r=%2225%22 fill=%22%238b5e3c%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22white%22 font-size=%2220%22 font-family=%22Arial%22%3E${review.name.charAt(0).toUpperCase()}%3C/text%3E%3C/svg%3E'">
                    <div>
                        <strong>${review.name}</strong><br>
                        <span>${review.date}</span>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    window.scrollReviews = function(direction) {
        const container = document.getElementById('testimonialsScroll');
        if (container) {
            const scrollAmount = container.clientWidth * 0.8;
            container.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
        }
    };

    // Initialize reviews
    loadReviews();

    // Expose functions
    window.calculateShippingFromAddress = calculateShippingFromAddress;
    window.estimateDistanceFromAddress = estimateDistanceFromAddress;
});