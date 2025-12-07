# Project UTS Pemrograman Web - Website Brew & Co.

Proyek ini merupakan Ujian Akhir Semester (UAS) untuk matakuliah Pemrograman Web (Program Studi: Sarjana Terapan Manajemen Informatika / Semester 3). Proyek ini bertujuan untuk membuat halaman website interaktif untuk sebuah *coffee shop* fiktif bernama "Brew & Co." menggunakan HTML, CSS, JavaScript, dan PHP. Hasil akhir proyek di-hosting di server GitHub.

## Anggota Kelompok

| Nama Lengkap | NIM |
| :------------------------ | :---------- |
| Firda Agustina | 24091397032 |
| Mochammad Dzaky Budi Praditya | 24091397033 |
| Risda Sifa Hasna | 24091397054 |

## Alamat Domain (Live Demo)

Website ini telah di-hosting dan dapat diakses melalui tautan berikut:

**https://kelompok7.2024b.my.id/**

## Teknologi yang Digunakan

* **HTML5:** Untuk membangun struktur dan kerangka utama halaman web.
* **CSS3:** Untuk mendesain, menata letak, dan menambahkan animasi untuk mempercantik tampilan website.
* **JavaScript:** Untuk fungsionalitas dan interaktivitas, seperti event handling dan manipulasi DOM.
* **PHP:** Untuk pemrosesan server-side, pengelolaan data dinamis, dan logika backend.
* **MySQL:** Database untuk menyimpan data menu, pesanan, user, dan review.

---

## Struktur Proyek

```
web_2/
│
├── assets/                   # Folder untuk aset media
│   ├── images/              # Gambar-gambar website (menu, hero, dll)
│   ├── script.js            # File JavaScript untuk interaktivitas
│   └── style.css            # File styling CSS
│
├── config/                   # Folder konfigurasi
│   └── database.php         # Konfigurasi koneksi database
│
├── handlers/                 # Folder untuk handler PHP (logic backend)
│   ├── auth_handler.php     # Handler autentikasi user
│   ├── cart_handler.php     # Handler keranjang belanja
│   ├── get_menu.php         # Handler untuk mengambil data menu
│   ├── order_handler.php    # Handler pemesanan
│   └── review_handler.php   # Handler review/testimonial
│
├── includes/                 # Folder untuk file PHP yang dapat di-include
│   ├── footer.php           # Template footer
│   ├── functions.php        # Fungsi-fungsi helper PHP
│   ├── header.php           # Template header/navigasi
│   └── navbar.php           # Template navigasi bar
│
├── admin.php                 # Halaman admin dashboard
├── brew_co.sql              # File database SQL
├── index.php                # Halaman utama website
└── README.md                # Dokumentasi proyek
```

---

## Petunjuk Penggunaan

### 1. Persiapan Environment

Pastikan Anda telah menginstall:
- **Web Server** (Apache/Nginx)
- **PHP** (versi 7.4 atau lebih tinggi)
- **MySQL/MariaDB** (untuk database)

Atau gunakan paket seperti:
- **XAMPP** (Windows/Mac/Linux)
- **WAMP** (Windows)
- **MAMP** (Mac)
- **Laragon** (Windows)

### 2. Cara Menjalankan Proyek Secara Lokal

#### Menggunakan XAMPP:

1. **Download dan Install XAMPP**
   - Unduh dari [https://www.apachefriends.org](https://www.apachefriends.org)
   - Install sesuai sistem operasi Anda

2. **Clone atau Download Proyek**
   ```bash
   git clone https://github.com/sfrhsn/Brew_Co.git
   ```
   Atau download ZIP dan extract

3. **Pindahkan Folder Proyek**
   - Copy folder proyek `web_2` ke direktori `htdocs` di XAMPP
   - Path lengkap: `C:\xampp\htdocs\web_2\` (Windows)
   - Atau: `/Applications/XAMPP/htdocs/web_2/` (Mac)

4. **Jalankan XAMPP**
   - Buka XAMPP Control Panel
   - Start Apache
   - Start MySQL

5. **Akses Website**
   - Buka browser
   - Ketik: `http://localhost/web_2/`
   - Website akan terbuka

#### Menggunakan PHP Built-in Server:

1. **Buka Terminal/Command Prompt**
   ```bash
   cd C:\xampp\htdocs\web_2
   ```

2. **Jalankan PHP Server**
   ```bash
   php -S localhost:8000
   ```

3. **Akses Website**
   - Buka browser
   - Ketik: `http://localhost:8000`

### 3. Konfigurasi Database

1. **Buat Database**
   - Akses phpMyAdmin: `http://localhost/phpmyadmin`
   - Buat database baru dengan nama `brew_co`

2. **Import SQL**
   - Pilih database `brew_co` yang baru dibuat
   - Klik tab "Import"
   - Pilih file `brew_co.sql` dari folder proyek
   - Klik "Go" untuk import

3. **Konfigurasi Koneksi**
   Edit file `config/database.php`:
   ```php
   <?php
   $host = 'localhost';
   $dbname = 'brew_co';
   $username = 'root';
   $password = '';
   
   try {
       $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } catch(PDOException $e) {
       echo "Connection failed: " . $e->getMessage();
   }
   ?>
   ```

---

## Fitur-Fitur Website

### Fitur User/Pelanggan:

#### 1. Sistem Autentikasi
- **Register:** Pendaftaran akun user baru
- **Login:** Masuk ke akun dengan kredensial
- **Session Management:** Tracking user yang sedang login
- **Logout:** Keluar dari akun dengan aman

#### 2. Navigasi Responsif
- Menu hamburger untuk tampilan mobile
- Smooth scroll ke berbagai section (Home, About, Testimonials, Contact)
- Navbar sticky yang mengikuti scroll
- Highlight menu aktif saat scroll

#### 3. Katalog Menu Dinamis
- Menampilkan menu Coffee dan Snacks dari database
- Filter/switch kategori menu dengan animasi smooth
- Klik item menu untuk melihat detail lengkap dalam modal
- Informasi detail: gambar, nama, deskripsi, harga
- Data menu real-time dari database

#### 4. Keranjang Belanja (Shopping Cart)
- Icon cart dengan badge notifikasi jumlah item
- Tambah item ke cart langsung dari modal menu
- Update quantity item di keranjang
- Hapus item dari keranjang
- Kalkulasi total harga otomatis
- Data cart tersimpan dalam session

#### 5. Sistem Pemesanan (Order)
- Form checkout dengan validasi
- Input data pengiriman (nama, alamat, no. telepon)
- Review pesanan sebelum submit
- Konfirmasi pemesanan
- Data order tersimpan ke database
- Notifikasi sukses setelah order

#### 6. Review/Testimonial
- User dapat memberikan review setelah login
- Form review dengan rating bintang
- Input nama, komentar, dan rating
- Display testimonial dari pelanggan lain
- Review tersimpan di database

#### 7. Informasi Tambahan
- **Modal "Anggota Kami":** Menampilkan tim developer
- **Tombol "Lokasi Coffee":** Link ke lokasi coffee shop
- **Section About:** Informasi tentang Brew & Co.
- **Section Contact:** Informasi kontak dan social media
- **Hero Section:** Banner utama dengan CTA buttons

### Fitur Admin:

#### 1. Admin Dashboard (admin.php)
- Login khusus admin dengan autentikasi terpisah
- Dashboard overview dengan statistik
- Interface yang user-friendly untuk manajemen

#### 2. Manajemen Menu (CRUD)
- **Create:** Tambah menu baru dengan upload gambar
- **Read:** Lihat daftar semua menu
- **Update:** Edit detail menu (nama, harga, deskripsi, kategori)
- **Delete:** Hapus menu yang tidak tersedia

#### 3. Manajemen Pesanan
- Lihat daftar semua pesanan yang masuk
- Detail pesanan lengkap (items, customer info, total)
- Update status pesanan (Pending, Processing, Completed, Cancelled)
- Filter pesanan berdasarkan status atau tanggal

#### 4. Manajemen Review
- Lihat semua review yang masuk
- Approve atau reject review
- Hapus review yang tidak sesuai
- Moderasi konten testimonial

#### 5. Upload & Media Management
- Upload gambar menu dengan preview
- Validasi format file (JPG, PNG)
- Resize otomatis untuk optimasi
- Hapus gambar lama saat update

---

## Cara Menggunakan Website

### Untuk User/Pelanggan:

#### A. Registrasi dan Login
1. Klik tombol "Login" atau "Register" di halaman utama
2. **Untuk Register:**
   - Isi form registrasi (username, email, password)
   - Klik "Daftar"
   - Akun berhasil dibuat
3. **Untuk Login:**
   - Masukkan email dan password
   - Klik "Login"
   - Anda akan masuk ke website
4. Setelah login, tombol "Logout" akan muncul di navbar

#### B. Menjelajahi dan Memesan Menu
1. Klik tombol "Explore Menu" di hero section atau scroll ke bagian Menu
2. Pilih kategori menu (Coffee atau Snacks)
3. Klik pada kartu menu yang diinginkan
4. Modal akan muncul menampilkan:
   - Gambar menu besar
   - Nama menu
   - Deskripsi lengkap
   - Harga
   - Tombol "Add to Cart"
5. Klik "Add to Cart" untuk menambahkan ke keranjang
6. Badge notifikasi di icon cart akan terupdate secara real-time

#### C. Mengelola Keranjang Belanja
1. Klik icon **cart** (🛒) di navbar
2. Modal keranjang akan terbuka menampilkan:
   - List item yang sudah ditambahkan
   - Quantity setiap item
   - Harga per item
   - Total harga keseluruhan
3. **Update Quantity:**
   - Klik tombol + atau - untuk mengubah jumlah
   - Total harga akan terupdate otomatis
4. **Hapus Item:**
   - Klik tombol hapus (🗑️) pada item
   - Item akan dihapus dari keranjang
5. Klik "Checkout" untuk melanjutkan ke pemesanan

#### D. Melakukan Pemesanan
1. Setelah klik "Checkout", form pemesanan akan muncul
2. Isi data berikut:
   - Nama lengkap
   - No. telepon/WhatsApp
   - Alamat pengiriman lengkap
   - Catatan tambahan (opsional)
3. Review kembali pesanan Anda
4. Klik "Submit Order" untuk konfirmasi
5. Pesanan akan tersimpan ke database
6. Notifikasi sukses akan muncul
7. Admin akan memproses pesanan Anda

#### E. Memberikan Review/Testimonial
1. Scroll ke section "Testimonials"
2. Klik tombol "Berikan Review" (harus login terlebih dahulu)
3. Modal form review akan muncul
4. Isi form review:
   - Pilih rating (1-5 bintang)
   - Tulis komentar/pengalaman Anda
5. Klik "Submit Review"
6. Review Anda akan muncul di section testimonials

#### F. Fitur Lainnya
- **Lokasi Coffee:**
  - Klik tombol "Lokasi Coffee" di hero section
  - Akan menampilkan peta/alamat coffee shop
  
- **Anggota Kami:**
  - Scroll ke section "About"
  - Klik tombol "Anggota Kami"
  - Modal akan menampilkan informasi tim developer
  
- **Menutup Modal:**
  - Klik tombol X di pojok kanan atas
  - Klik area di luar modal
  - Tekan tombol "Escape" di keyboard

### Untuk Admin:

#### A. Login Admin
1. Akses halaman admin: `http://localhost/web_2/admin.php`
2. Masukkan kredensial admin:
   - Username/Email admin
   - Password admin
3. Klik "Login"
4. Anda akan masuk ke dashboard admin

#### B. Mengelola Menu

**Menambah Menu Baru:**
1. Di dashboard, klik menu "Kelola Menu"
2. Klik tombol "Tambah Menu Baru"
3. Isi form tambah menu:
   - Nama menu
   - Kategori (Coffee/Snacks)
   - Harga (dalam Rupiah)
   - Deskripsi produk
   - Upload gambar menu
4. Klik "Simpan"
5. Menu baru akan muncul di website

**Mengedit Menu:**
1. Pada daftar menu, cari menu yang ingin diedit
2. Klik icon **edit** (✏️) pada menu tersebut
3. Form edit akan muncul dengan data saat ini
4. Ubah data yang diinginkan:
   - Ganti nama, harga, deskripsi
   - Upload gambar baru (opsional)
5. Klik "Update"
6. Perubahan akan tersimpan

**Menghapus Menu:**
1. Pada daftar menu, cari menu yang ingin dihapus
2. Klik icon **hapus** (🗑️) pada menu tersebut
3. Konfirmasi popup akan muncul
4. Klik "Ya, Hapus" untuk konfirmasi
5. Menu akan terhapus dari database dan website

#### C. Mengelola Pesanan
1. Klik menu "Kelola Pesanan" di dashboard
2. Akan tampil daftar semua pesanan dengan informasi:
   - ID Pesanan
   - Nama customer
   - Total harga
   - Status pesanan
   - Tanggal order
3. **Melihat Detail Pesanan:**
   - Klik tombol "Detail" pada pesanan
   - Akan tampil info lengkap pesanan, items, dan customer
4. **Update Status Pesanan:**
   - Pilih dropdown status pada pesanan
   - Pilih status baru:
     - **Pending:** Pesanan baru masuk
     - **Processing:** Sedang diproses
     - **Completed:** Pesanan selesai
     - **Cancelled:** Pesanan dibatalkan
   - Klik "Update Status"
   - Status akan tersimpan
5. **Filter Pesanan:**
   - Gunakan filter berdasarkan status
   - Filter berdasarkan tanggal
   - Search berdasarkan nama customer

#### D. Mengelola Review/Testimonial
1. Klik menu "Kelola Review" di dashboard
2. Akan tampil daftar semua review dengan:
   - Nama reviewer
   - Rating (bintang)
   - Komentar
   - Tanggal review
   - Status (Approved/Pending)
3. **Approve Review:**
   - Klik tombol "Approve" pada review
   - Review akan tampil di website
4. **Reject/Hapus Review:**
   - Klik tombol "Hapus" pada review yang tidak sesuai
   - Konfirmasi penghapusan
   - Review akan dihapus dari database

#### E. Logout Admin
1. Klik tombol "Logout" di pojok kanan atas dashboard
2. Anda akan keluar dari session admin
3. Akan diarahkan kembali ke halaman login

---

## Penjelasan Kodingan Sesuai Kriteria Penilaian

Berikut adalah penjelasan implementasi kode pada proyek yang disesuaikan dengan kriteria penilaian pada dokumen UTS Pemweb.pdf.

### 1. Struktur HTML/PHP

File `index.php` diorganisir menggunakan tag HTML semantik dengan integrasi PHP untuk konten dinamis:

* **<?php include 'includes/header.php'; ?>:** Memuat template header yang dapat digunakan ulang.
* **<?php include 'includes/navbar.php'; ?>:** Memuat navigasi bar yang konsisten.
* **<header>:** Berisi elemen navigasi utama yang mencakup logo dan tautan ke bagian-bagian halaman.
* **<main>:** Membungkus seluruh konten utama halaman, yang dibagi lagi ke dalam beberapa bagian.
* **<section>:** Setiap bagian konten (seperti Home, Menu, About, Testimonials, Contact) dipisahkan menggunakan tag <section> dengan ID yang relevan untuk memfasilitasi navigasi internal.
* **PHP Dynamic Content:** Menggunakan handler PHP (`get_menu.php`) untuk menampilkan data menu dari database secara dinamis.
* **<?php include 'includes/footer.php'; ?>:** Memuat template footer yang konsisten di seluruh halaman.
* **Struktur Modal:** Terdapat beberapa <div> modal untuk menu detail, cart, dan member info yang awalnya disembunyikan dan akan ditampilkan menggunakan JavaScript.

### 2. Desain CSS

File `assets/style.css` bertanggung jawab atas seluruh aspek visual untuk menciptakan desain yang estetis dan menarik.

* **CSS Variables (:root):** Palet warna utama seperti `--bg-main`, `--coffee-dark`, dan `--primary-color` didefinisikan sebagai variabel untuk menjaga konsistensi dan kemudahan dalam modifikasi desain.
* **Layouting:** Layout utama menggunakan **Flexbox** dan **CSS Grid** untuk mengatur elemen seperti navbar, konten hero, kartu menu, dan kartu testimoni, yang mempermudah implementasi desain yang responsif.
* **Desain Responsif:** Menggunakan **@media queries** untuk menyesuaikan tampilan pada berbagai ukuran layar:
  - Desktop (> 1024px): Layout full dengan sidebar
  - Tablet (768px - 1024px): Layout 2 kolom
  - Mobile (< 768px): Layout 1 kolom dengan hamburger menu
* **Animasi dan Transisi:** 
  - Animasi fadeUp pada teks hero
  - Transform scale pada item menu saat hover
  - Animasi fadeIn & scaleUp pada modal
  - Smooth scroll behavior
  - Loading animations
  - Badge notification pulse effect

### 3. Fungsionalitas JavaScript & PHP

**JavaScript (assets/script.js)** mengelola interaktivitas client-side:
* **Event Handling:** 
  - Click events untuk menu, cart, modal
  - Scroll events untuk navbar sticky
  - Keyboard events (Escape untuk close modal)
  - Form submit events dengan validasi
* **DOM Manipulation:** 
  - Dynamic content rendering untuk menu
  - Update cart badge real-time
  - Modal management (open/close dengan animasi)
  - Form validation dan error display
* **AJAX Calls:** 
  - Fetch data menu dari `get_menu.php`
  - Submit cart items ke `cart_handler.php`
  - Real-time cart updates tanpa reload
  - Form submissions asynchronous

**PHP Handlers (folder handlers/)** mengelola logika server-side:
* **get_menu.php:** 
  - Query database untuk ambil data menu
  - Filter berdasarkan kategori
  - Return JSON response untuk AJAX
* **auth_handler.php:** 
  - Validasi login credentials
  - Hash password dengan bcrypt
  - Session management untuk user
  - Register user baru dengan validasi
* **cart_handler.php:** 
  - Add item ke session cart
  - Update quantity dengan validasi stock
  - Remove item dari cart
  - Calculate total price
* **order_handler.php:** 
  - Validate order data
  - Insert order ke database
  - Insert order items (detail pesanan)
  - Clear cart after successful order
  - Return order confirmation
* **review_handler.php:** 
  - Validate review input
  - Insert review ke database
  - Get approved reviews untuk display
  - Rating calculation

**PHP Includes (folder includes/)** untuk modularitas:
* **header.php:** Meta tags, CSS links, SEO tags
* **navbar.php:** Navigation bar dengan dynamic login/logout button
* **footer.php:** Footer dengan copyright dan social links
* **functions.php:** 
  - `sanitize_input()`: Sanitasi input user
  - `check_login()`: Cek status login user
  - `format_currency()`: Format harga ke Rupiah
  - `upload_image()`: Handle upload gambar dengan validasi

**Konfigurasi (folder config/):**
* **database.php:** 
  - PDO connection dengan error handling
  - Prepared statements untuk prevent SQL injection
  - UTF-8 encoding
  - Exception mode untuk debugging

### 4. Dokumentasi dan SRS

* **Dokumentasi Kode:** Komentar telah ditambahkan di dalam file PHP, JavaScript, dan CSS untuk menjelaskan bagian-bagian kode yang penting, seperti fungsi utama, alur logika, dan blok styling.

* **SRS (Software Requirements Specification):**
  
  * **a. Tujuan Proyek:** 
    Merancang dan mengembangkan website full-stack e-commerce coffee shop yang fungsional, estetis, dan user-friendly untuk "Brew & Co.". Website ini bertujuan untuk memberikan pengalaman pemesanan online yang mudah bagi pelanggan, serta menyediakan sistem manajemen konten untuk admin.
  
  * **b. Kebutuhan Fungsional:**
    - User dapat registrasi dan login ke website
    - User dapat melihat katalog menu yang diambil dari database
    - Menu terbagi dalam kategori Coffee dan Snacks dengan filter
    - User dapat melihat detail menu dalam modal popup
    - User dapat menambahkan item ke keranjang belanja
    - User dapat mengelola keranjang (update quantity, hapus item)
    - User dapat melakukan checkout dan submit pesanan
    - Pesanan tersimpan ke database dengan detail lengkap
    - User dapat memberikan review dengan rating
    - Review tampil di section testimonials
    - Admin dapat login ke dashboard terpisah
    - Admin dapat CRUD (Create, Read, Update, Delete) menu
    - Admin dapat melihat dan mengelola pesanan
    - Admin dapat mengelola review (approve/reject)
    - Website responsif untuk desktop, tablet, dan mobile
    - Navigasi smooth scroll ke berbagai section
    - Modal dapat ditutup dengan berbagai cara (X, click outside, Escape)
  
  * **c. Kebutuhan Non-Fungsional:**
    - **Desain Estetis:** Tampilan modern, menarik, dan konsisten dengan tema coffee shop dengan palet warna coklat, cream, dan aksen hangat
    - **Performa:** 
      - Page load time < 3 detik
      - Smooth animations tanpa lag
      - Optimasi gambar untuk fast loading
      - Efficient database queries
    - **Usability:** 
      - Interface intuitif dan mudah digunakan
      - Clear call-to-action buttons
      - Helpful error messages
      - Consistent navigation
    - **Keterbacaan:** 
      - Typography hierarchy yang jelas
      - Kontras warna yang baik (WCAG AA compliant)
      - Font size minimal 16px untuk body text
      - Line height optimal untuk readability
    - **Keamanan:** 
      - Password hashing dengan bcrypt
      - Prepared statements untuk prevent SQL injection
      - Input sanitization untuk prevent XSS
      - Session management yang aman
      - CSRF token untuk form submissions
      - Admin authentication dan authorization
    - **Responsiveness:** 
      - Mobile-first approach
      - Breakpoints: 768px (tablet), 1024px (desktop)
      - Touch-friendly buttons (min 44x44px)
      - Responsive images dengan srcset
    - **Maintainability:** 
      - Modular code structure
      - Separation of concerns (MVC pattern)
      - Reusable components (includes)
      - Well-documented code dengan comments
      - Consistent naming conventions
      - Version control dengan Git
    - **Validasi Kode:** 
      - HTML5 semantic markup yang valid
      - CSS3 sesuai standar W3C
      - PHP 7.4+ compatibility
      - Cross-browser compatibility (Chrome, Firefox, Safari, Edge)

---

## Troubleshooting

### Masalah Umum:

**1. Error 404 Not Found**
   - Pastikan file berada di folder `htdocs/web_2/`
   - Cek penulisan nama file (case-sensitive di Linux/Mac)
   - Pastikan mengakses: `http://localhost/web_2/`

**2. PHP Code Tampil sebagai Text**
   - Pastikan Apache sudah running di XAMPP
   - Pastikan file berekstensi `.php` bukan `.html`
   - Restart Apache di XAMPP Control Panel

**3. Database Connection Error**
   - Cek konfigurasi di `config/database.php`
   - Pastikan MySQL sudah running di XAMPP
   - Verifikasi nama database: `brew_co`
   - Verifikasi username: `root` dan password: kosong (default XAMPP)

**4. SQL Import Gagal**
   - Pastikan database `brew_co` sudah dibuat
   - Cek ukuran file SQL tidak melebihi `upload_max_filesize` di php.ini
   - Cek syntax error di file SQL
   - Import ulang dengan menghapus database lama terlebih dahulu

**5. CSS/JS Tidak Load**
   - Cek path file di tag `<link>` dan `<script>` di HTML
   - Pastikan path: `assets/style.css` dan `assets/script.js`
   - Clear browser cache (Ctrl + Shift + R)
   - Cek console browser untuk error 404

**6. Gambar Tidak Muncul**
   - Pastikan folder `assets/images/` ada dan memiliki permission read
   - Cek path gambar di database
   - Pastikan file gambar ada di folder yang benar
   - Cek console browser untuk error loading image

**7. Session Tidak Berfungsi**
   - Pastikan `session_start()` dipanggil di awal file PHP
   - Cek folder session di php.ini memiliki permission write
   - Clear browser cookies
   - Cek `session.save_path` di phpinfo()

**8. Cart Tidak Terupdate**
   - Cek console browser untuk JavaScript error
   - Pastikan AJAX request berhasil (cek Network tab)
   - Verify handler `cart_handler.php` berfungsi
   - Cek session cart di `$_SESSION['cart']`

**9. Login Gagal (Kredensial Benar)**
   - Cek apakah password di database sudah di-hash
   - Verify fungsi `password_verify()` di `auth_handler.php`
   - Cek tabel users di database ada dan terisi
   - Reset password user di database

**10. Admin Dashboard Tidak Bisa Diakses**
   - Pastikan sudah login sebagai admin
   - Cek role user di database (harus 'admin')
   - Verify redirect di `auth_handler.php`
   - Clear session dan login ulang

---

## Tips Pengembangan Lebih Lanjut

Berikut beberapa fitur yang bisa ditambahkan untuk pengembangan proyek:

1. **Payment Gateway Integration**
   - Integrasi dengan Midtrans, DOKU, atau payment gateway lain
   - Multiple payment methods (Transfer, E-wallet, COD)

2. **Email Notification**
   - Konfirmasi order via email
   - Newsletter subscription
   - Reset password via email

3. **Advanced Search & Filter**
   - Search menu by name
   - Filter by price range
   - Sort by popularity, rating, price

4. **User Profile**
   - Edit profile information
   - Order history
   - Saved addresses
   - Wishlist/Favorites

5. **Real-time Features**
   - Live order tracking
   - Push notifications
   - Real-time chat dengan admin

6. **Analytics Dashboard**
   - Sales statistics
   - Popular menu items
   - Customer demographics
   - Revenue reports

7. **Social Features**
   - Share menu ke social media
   - Login with Google/Facebook
   - Social proof (X orang order ini)

8. **SEO & Marketing**
   - Meta tags optimization
   - Sitemap.xml
   - robots.txt
   - Promo codes & discounts

---
