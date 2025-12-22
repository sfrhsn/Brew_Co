<?php
function renderMenuSection($menus, $editData) {
    ?>
    <div class="form-section">
        <h2><?php echo $editData ? 'Edit Menu' : 'Tambah Menu Baru'; ?></h2>
        <form method="POST" onsubmit="return validateForm()">
            <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">
            
            <div class="form-group">
                <label>Menu Key (ID unik, lowercase, no space)</label>
                <input type="text" name="menu_key" id="menu_key" 
                       value="<?php echo $editData['menu_key'] ?? ''; ?>" 
                       placeholder="contoh: cappuccino, cookies" 
                       required>
                <div class="form-hint">Gunakan huruf kecil tanpa spasi, contoh: cappuccino, chocolate_cake</div>
            </div>

            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="title" id="title" 
                       value="<?php echo $editData['title'] ?? ''; ?>" 
                       placeholder="contoh: Cappuccino" 
                       required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category" id="category" required>
                    <option value="coffee" <?php echo ($editData['category'] ?? '') === 'coffee' ? 'selected' : ''; ?>>Coffee</option>
                    <option value="snacks" <?php echo ($editData['category'] ?? '') === 'snacks' ? 'selected' : ''; ?>>Snacks</option>
                </select>
            </div>

            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="price" id="price" 
                       value="<?php echo $editData['price'] ?? ''; ?>" 
                       placeholder="contoh: 25000" 
                       min="1000" 
                       required>
            </div>

            <div class="form-group">
                <label>URL Gambar</label>
                <input type="text" name="image" id="image" 
                       value="<?php echo $editData['image'] ?? ''; ?>" 
                       placeholder="assets/images/nama_gambar.jpg" 
                       required>
                <div class="form-hint">Upload gambar ke folder assets/images/ lalu masukkan path-nya di sini</div>
            </div>

            <div class="form-group">
                <label>Deskripsi / Detail Menu</label>
                <textarea name="description" id="description" required><?php echo $editData['description'] ?? ''; ?></textarea>
                <div class="form-hint">Jelaskan detail menu, bahan, atau keunikan produk</div>
            </div>

            <div style="margin-top: 25px;">
                <button type="submit" name="save" class="btn btn-primary">
                    <?php echo $editData ? 'Update Menu' : 'Simpan Menu'; ?>
                </button>
                
                <?php if ($editData): ?>
                    <a href="index.php?page=menu" class="btn btn-small btn-cancel">Batal</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <?php renderMenuTable($menus); ?>
    <?php
}

function renderMenuTable($menus) {
    ?>
    <div class="data-table">
        <h2>Daftar Menu (<?php echo count($menus); ?>)</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Menu Key</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($menus)): ?>
                    <tr>
                        <td colspan="8" style="text-align:center;padding:30px;color:#999;">
                            Belum ada data menu. Silakan tambahkan menu baru!
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($menus as $menu): ?>
                        <tr>
                            <td><?php echo $menu['id']; ?></td>
                            <td>
                                <img src="../<?php echo htmlspecialchars($menu['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($menu['title']); ?>" 
                                     class="menu-img"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22%3E%3Crect fill=%22%23ddd%22 width=%2260%22 height=%2260%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%23999%22%3ENo Image%3C/text%3E%3C/svg%3E'">
                            </td>
                            <td><code><?php echo htmlspecialchars($menu['menu_key']); ?></code></td>
                            <td><strong><?php echo htmlspecialchars($menu['title']); ?></strong></td>
                            <td>
                                <span class="category-badge badge-<?php echo $menu['category']; ?>">
                                    <?php echo ucfirst($menu['category']); ?>
                                </span>
                            </td>
                            <td>Rp <?php echo number_format($menu['price'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars(substr($menu['description'], 0, 50)); ?>...</td>
                            <td>
                                <a href="?page=menu&edit=<?php echo $menu['id']; ?>" class="btn-small btn-edit">Edit</a>
                                <a href="?delete=<?php echo $menu['id']; ?>" 
                                   class="btn-small btn-delete"
                                   onclick="return confirm('Yakin ingin menghapus menu <?php echo htmlspecialchars($menu['title']); ?>?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}