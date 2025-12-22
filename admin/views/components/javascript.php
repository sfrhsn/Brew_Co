<?php
function renderJavaScript($orders = []) {
    ?>
    <script>
        const ordersData = <?php echo json_encode($orders); ?>;

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

        document.getElementById('title')?.addEventListener('input', function(e) {
            const menuKeyInput = document.getElementById('menu_key');
            if (!menuKeyInput.value || menuKeyInput.dataset.auto !== 'false') {
                const menuKey = e.target.value
                    .toLowerCase()
                    .replace(/\s+/g, '_')
                    .replace(/[^a-z0-9_]/g, '');
                menuKeyInput.value = menuKey;
            }
        });

        document.getElementById('menu_key')?.addEventListener('input', function() {
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

        function showOrderDetail(orderId) {
            console.log('Opening order detail for ID:', orderId);
            console.log('Available orders:', ordersData);
            
            const order = ordersData.find(o => o.id === orderId);
            
            if (!order) {
                console.error('Order not found:', orderId);
                alert('Order tidak ditemukan!');
                return;
            }

            console.log('Order found:', order);

            let items = [];
            try {
                items = typeof order.items === 'string' ? JSON.parse(order.items) : order.items;
            } catch (e) {
                console.error('Error parsing items:', e);
                alert('Error parsing order items!');
                return;
            }
            
            let itemsHTML = '<ul class="order-items-list">';
            items.forEach(item => {
                const itemTotal = item.price * item.quantity;
                itemsHTML += `
                    <li>
                        <span>${item.title} x${item.quantity}</span>
                        <span><strong>Rp ${itemTotal.toLocaleString('id-ID')}</strong></span>
                    </li>
                `;
            });
            itemsHTML += '</ul>';

            const html = `
                <div class="detail-section">
                    <h3>Informasi Pesanan</h3>
                    <div class="detail-row">
                        <span class="detail-label">Order ID:</span>
                        <span class="detail-value"><strong>${order.order_id}</strong></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal:</span>
                        <span class="detail-value">${order.date}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status:</span>
                        <span class="detail-value"><span class="status-badge status-proses">${order.status}</span></span>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Informasi Customer</h3>
                    <div class="detail-row">
                        <span class="detail-label">Nama:</span>
                        <span class="detail-value">${order.username}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">${order.email}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">No. Telepon:</span>
                        <span class="detail-value">${order.phone}</span>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Alamat Pengiriman</h3>
                    <div class="detail-row">
                        <span class="detail-label">Alamat:</span>
                        <span class="detail-value">${order.address}</span>
                    </div>
                    ${order.detail ? `
                    <div class="detail-row">
                        <span class="detail-label">Detail:</span>
                        <span class="detail-value">${order.detail}</span>
                    </div>
                    ` : ''}
                    <div class="detail-row">
                        <span class="detail-label">Jarak:</span>
                        <span class="detail-value">${order.distance} km</span>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Item Pesanan</h3>
                    ${itemsHTML}
                </div>

                <div class="detail-section">
                    <h3>Rincian Biaya</h3>
                    <div class="detail-row">
                        <span class="detail-label">Subtotal:</span>
                        <span class="detail-value">Rp ${parseInt(order.subtotal).toLocaleString('id-ID')}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Ongkir (${order.distance} km):</span>
                        <span class="detail-value">Rp ${parseInt(order.shipping).toLocaleString('id-ID')}</span>
                    </div>
                    <div class="detail-row" style="border-top: 2px solid var(--coffee-dark); padding-top: 10px; margin-top: 10px;">
                        <span class="detail-label"><strong>Total:</strong></span>
                        <span class="detail-value"><strong style="color: var(--coffee-dark); font-size: 1.2rem;">Rp ${parseInt(order.total).toLocaleString('id-ID')}</strong></span>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Pembayaran</h3>
                    <div class="detail-row">
                        <span class="detail-label">Metode:</span>
                        <span class="detail-value"><strong>${order.payment}</strong></span>
                    </div>
                </div>
            `;

            document.getElementById('orderDetailContent').innerHTML = html;
            document.getElementById('orderDetailModal').style.display = 'block';
            console.log('✅ Modal displayed');
        }

        function closeOrderModal() {
            document.getElementById('orderDetailModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('orderDetailModal');
            if (event.target == modal) {
                closeOrderModal();
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeOrderModal();
            }
        });
    </script>
    <?php
}