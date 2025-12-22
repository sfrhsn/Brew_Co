<?php
function renderModal($orders) {
    ?>
    <div id="orderDetailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-modal" onclick="closeOrderModal()">&times;</span>
                <h2>Detail Pesanan</h2>
            </div>
            <div id="orderDetailContent">
                <!-- Akan diisi dengan JavaScript -->
            </div>
        </div>
    </div>
    <?php
}