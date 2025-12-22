<?php
function renderOrdersSection($orders) {
    ?>
    <div class="data-table">
        <h2>Riwayat Pemesanan Customer (<?php echo count($orders); ?>)</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="7" style="text-align:center;padding:30px;color:#999;">
                            Belum ada riwayat pemesanan
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($order['order_id']); ?></strong></td>
                            <td>
                                <strong><?php echo htmlspecialchars($order['username']); ?></strong><br>
                                <small style="color:#777;"><?php echo htmlspecialchars($order['email']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($order['date']); ?></td>
                            <td><strong>Rp <?php echo number_format($order['total'], 0, ',', '.'); ?></strong></td>
                            <td><?php echo htmlspecialchars($order['payment']); ?></td>
                            <td>
                                <span class="status-badge status-proses">
                                    <?php echo htmlspecialchars($order['status']); ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn-small btn-detail" onclick="showOrderDetail(<?php echo $order['id']; ?>)">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}