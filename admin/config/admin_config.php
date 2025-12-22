<?php
// Admin Configuration
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123');

// Default menus untuk auto-insert
function getDefaultMenus() {
    return [
        ['espresso', 'Espresso', 'coffee', 15000, 'assets/images/espresso.jpg', 'Kopi murni dengan cita rasa kuat dan pekat. Diseduh menggunakan tekanan tinggi tanpa campuran. Cocok untuk penikmat kopi sejati yang menyukai rasa bold.'],
        ['latte', 'Latte', 'coffee', 20000, 'assets/images/latte.jpg', 'Campuran espresso dan susu steamed yang creamy. Memiliki lapisan foam tipis di bagian atas. Favorit bagi pecinta rasa lembut dan seimbang.'],
        ['cappuccino', 'Cappuccino', 'coffee', 22000, 'assets/images/capucino.jpg', 'Perpaduan espresso, susu steamed, dan busa foam tebal. Rasa seimbang antara pahit dan lembut. Cocok diminum pagi hari untuk energi ekstra.'],
        ['mocha', 'Mocha', 'coffee', 23000, 'assets/images/mocha.jpg', 'Kombinasi espresso, susu, dan cokelat murni. Rasa manis berpadu dengan aroma kopi pekat. Pilihan ideal untuk kamu yang suka kopi dengan sentuhan coklat.'],
        ['americano', 'Americano', 'coffee', 28000, 'assets/images/americano.jpg', 'Espresso yang dicampur air panas. Rasa ringan dengan aroma kopi yang kuat. Sering dinikmati tanpa tambahan gula atau susu.'],
        ['matcha', 'Matcha Latte', 'coffee', 23000, 'assets/images/matcha.jpg', 'Perpaduan bubuk matcha Jepang dan susu steamed. Rasa earthy yang khas dengan aroma lembut. Disajikan panas atau dingin sesuai selera.'],
        ['coldbrew', 'Cold Brew', 'coffee', 27000, 'assets/images/coldbrew.jpg', 'Kopi diseduh dengan air dingin selama 12-18 jam. Rasa lebih halus dan tidak terlalu asam. Cocok dinikmati dingin untuk hari yang panas.'],
        ['brownies', 'Brownies', 'snacks', 20000, 'assets/images/Brownies.jpg', 'Cokelat brownies lembut dengan aroma butter. Tekstur fudgy dan manis seimbang. Paling nikmat disajikan dengan kopi espresso.'],
        ['cookies', 'Cookies', 'snacks', 15000, 'assets/images/Cookies.jpg', 'Kue renyah dengan taburan chocochips premium. Rasa gurih mentega dan manis cokelat berpadu sempurna. Cocok sebagai teman ngobrol di sore hari.'],
        ['croissant', 'Croissant', 'snacks', 22000, 'assets/images/Croissant.jpg', 'Roti Prancis berlapis dengan tekstur flaky dan lembut. Dibuat dari adonan mentega berkualitas tinggi. Lezat disantap bersama kopi latte atau teh hangat.'],
        ['fries', 'French Fries', 'snacks', 14000, 'assets/images/FrenchFries.jpg', 'Kentang goreng renyah di luar, lembut di dalam. Dibumbui ringan dengan garam dan herbs. Cocok untuk camilan santai atau teman minum kopi.'],
        ['onionrings', 'Onion Rings', 'snacks', 10000, 'assets/images/Onionrings.jpg', 'Irisan bawang besar dilapisi tepung crispy. Rasa gurih dan sedikit manis alami. Paling enak dengan saus keju atau mayones.'],
        ['nugget', 'Nugget', 'snacks', 14000, 'assets/images/Nugget.jpg', 'Potongan ayam dibalut tepung renyah. Dimasak hingga keemasan dan gurih. Sajikan hangat untuk rasa terbaik.']
        ];
        }