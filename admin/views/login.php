<?php
function renderLoginPage($error = null) {
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link rel="stylesheet" href="../assets/style.css">
        <style>
            .login-box {
                max-width: 400px;
                margin: 100px auto;
                background: white;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            }
            .login-box h2 { text-align: center; margin-bottom: 30px; }
            .login-box input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; }
            .error { background: #fee; color: #c33; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        </style>
    </head>
    <body>
        <div class="login-box">
            <h2>🔐 Admin Login</h2>
            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login" class="btn btn-primary" style="width:100%">Login</button>
            </form>
            <p style="text-align:center; margin-top:20px;">
                <a href="../index.php">← Kembali ke Home</a>
            </p>
        </div>
    </body>
    </html>
    <?php
    echo ob_get_clean();
}

renderLoginPage($error ?? null);