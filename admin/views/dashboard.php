<?php
// Load all components
require_once 'components/header.php';
require_once 'components/tabs.php';
require_once 'components/menu_section.php';
require_once 'components/orders_section.php';
require_once 'components/footer.php';
require_once 'components/modal.php';
require_once 'components/javascript.php';

function renderDashboard($menus, $orders, $editData, $message, $messageType, $currentPage) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel - Brew & Co.</title>
        <link rel="stylesheet" href="../assets/style.css">
        <?php require_once 'admin_styles.php'; ?>
    </head>
    <body>
        <div class="admin-container">
            <?php renderHeader(); ?>
            
            <?php if ($message): ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <?php renderTabs($currentPage); ?>
            
            <?php if ($currentPage === 'menu'): ?>
                <?php renderMenuSection($menus, $editData); ?>
            <?php elseif ($currentPage === 'orders'): ?>
                <?php renderOrdersSection($orders); ?>
            <?php endif; ?>
            
            <?php renderFooter(); ?>
        </div>
        
        <?php renderModal($orders); ?>
        <?php renderJavaScript($orders); ?>
    </body>
    </html>
    <?php
}

renderDashboard($menus, $orders, $editData, $message, $messageType, $page);