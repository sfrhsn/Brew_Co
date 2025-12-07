-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Des 2025 pada 15.01
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brew_co`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `menu_key` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `menu_key`, `title`, `price`, `quantity`, `created_at`) VALUES
(7, 1, 'fries', 'French Fries', 14000, 2, '2025-12-07 02:21:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `menu_key` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` enum('coffee','snacks') NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `menu_key`, `title`, `category`, `price`, `image`, `description`, `created_at`) VALUES
(1, 'cappuccino', 'Cappuccino', 'coffee', 22000, 'assets/images/capucino.jpg', 'Perpaduan espresso, susu steamed, dan busa foam tebal.\r\nRasa seimbang antara pahit dan lembut.\r\nCocok diminum pagi hari untuk energi ekstra.', '2025-12-07 13:24:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `items` text NOT NULL,
  `subtotal` int(11) NOT NULL,
  `shipping` int(11) NOT NULL,
  `distance` decimal(10,2) NOT NULL,
  `total` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `detail` text DEFAULT NULL,
  `payment` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pesanan sedang diproses',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_id`, `items`, `subtotal`, `shipping`, `distance`, `total`, `phone`, `address`, `detail`, `payment`, `date`, `status`, `created_at`) VALUES
(1, 1, 'ORD-1765016654', '[{\"key\":\"onionrings\",\"title\":\"Onion Rings\",\"price\":10000,\"quantity\":2},{\"key\":\"fries\",\"title\":\"French Fries\",\"price\":14000,\"quantity\":1}]', 34000, 8000, 8.00, 42000, '085748039016', 'Jln. Jatisari besar gang langgar\nRT 04/RW 05', 'Rumah cat hijau', 'Cash on Delivery (COD)', '06/12/2025 11:24', 'Pesanan sedang diproses', '2025-12-06 10:24:14'),
(2, 1, 'ORD-1765019324', '[{\"key\":\"matcha\",\"title\":\"Matcha Latte\",\"price\":23000,\"quantity\":1},{\"key\":\"nugget\",\"title\":\"Nugget\",\"price\":14000,\"quantity\":1}]', 37000, 8000, 8.00, 45000, '085748039016', 'Jln. Jatisari besar gang langgar\nRT 04/RW 05', 'Rumah cat hijau', 'Cash on Delivery (COD)', '06/12/2025 12:08', 'Pesanan sedang diproses', '2025-12-06 11:08:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `date` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `name`, `text`, `rating`, `date`, `created_at`) VALUES
(1, 1, 'Reyhan', 'Brew & Co. bener-bener serius soal kopi. Biji kopinya yang single origin tuh mantap banget, kerasa banget kualitasnya di tiap tegukan. Wajib banget dicoba!', 4, '06 December 2025', '2025-12-06 11:07:14'),
(2, 1, 'Inumaki Toge', 'Tempat favorit aku buat ngopi! Suasananya tenang, aromanya selalu bikin rileks, dan rasa kopinya konsisten enak setiap datang. Baristanya ramah dan ingat pesanan pelanggan tetap. Pokoknya wajib mampir kalau lagi butuh mood booster pagi!', 5, '06 December 2025', '2025-12-06 15:58:12'),
(3, 1, 'shena', 'Ngopi di sini selalu bikin hari aku lebih waras. Tempatnya enak banget buat nongkrong, kopinya juga ga pernah miss. Baristanya asik, kadang suka ngobrol juga. Pokoknya kalo lewat sini, kaki langsung auto belok sendiri', 4, '06 December 2025', '2025-12-06 15:59:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'sfrhsn', 'sifahasnarisda@gmail.com', '$2y$10$c7.NX15BKL/iJwYE5BYeiOSePTFzIazBN4cnxlIfKVWIuxdJyd6SG', '2025-12-06 10:23:06');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_menu` (`user_id`,`menu_key`),
  ADD KEY `idx_user_cart` (`user_id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_key` (`menu_key`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `idx_user_orders` (`user_id`),
  ADD KEY `idx_order_id` (`order_id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_reviews` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
