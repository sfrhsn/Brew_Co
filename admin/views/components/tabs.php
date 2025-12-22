<?php
function renderTabs($currentPage) {
    ?>
    <div class="admin-tabs">
        <button class="admin-tab <?php echo $currentPage === 'menu' ? 'active' : ''; ?>" 
                onclick="location.href='?page=menu'">
            Kelola Menu
        </button>
        <button class="admin-tab <?php echo $currentPage === 'orders' ? 'active' : ''; ?>" 
                onclick="location.href='?page=orders'">
            Riwayat Pemesanan
        </button>
    </div>
    <?php
}