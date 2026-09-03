# SenjaKopi ☕

SenjaKopi adalah aplikasi pemesanan kopi berbasis web yang dibangun menggunakan Laravel. Aplikasi ini memungkinkan pelanggan melihat menu, mencari produk, memilih kategori, menambahkan menu ke keranjang, melakukan checkout, serta melihat dan mengelola pesanan.

SenjaKopi juga dilengkapi dengan halaman admin untuk mengelola produk, kategori, ketersediaan menu, serta transaksi pelanggan.

## Demo

🌐 **Live Website:**
https://senja-kopi-alpha.vercel.app

## Repository

📦 **GitHub:**
https://github.com/SulthanAfif/SenjaKopi

## Features

### Customer

* Menampilkan daftar menu yang tersedia
* Melihat detail menu
* Filter menu berdasarkan kategori
* Mencari menu berdasarkan nama atau deskripsi
* Pagination daftar menu
* Menambahkan menu ke keranjang
* Mengubah jumlah menu dalam keranjang
* Menghapus menu dari keranjang
* Checkout pesanan
* Memilih metode pembayaran:

  * QRIS
  * Cash
  * Transfer
* Mendapatkan nomor antrean setelah checkout
* Melihat daftar pesanan
* Melihat detail pesanan
* Membatalkan pesanan yang masih berstatus pending
* Memesan kembali (reorder) pesanan sebelumnya
* Mengelola profil pengguna

Fitur katalog, pencarian, kategori, keranjang, checkout, dan pengelolaan pesanan tersedia pada route aplikasi dan controller terkait.

### Admin

* Dashboard admin
* Mengelola kategori
* Menambah, melihat, mengubah, dan menghapus produk
* Mengatur ketersediaan produk
* Melihat transaksi
* Filter transaksi berdasarkan:

  * Status
  * Metode pembayaran
  * Tanggal
* Mencari transaksi berdasarkan nomor antrean atau data pengguna
* Melihat detail transaksi
* Mengubah status pesanan

Akses admin dilindungi menggunakan authentication dan middleware `is_admin`.

## Payment Methods

SenjaKopi menyediakan beberapa pilihan metode pembayaran:

* **QRIS**
* **Cash**
* **Transfer**

Metode pembayaran divalidasi saat proses checkout sebelum pesanan dibuat.

## Order Status

Status pesanan yang digunakan dalam aplikasi:

* `pending`
* `diproses`
* `selesai`
* `dibatalkan`

Pelanggan hanya dapat membatalkan pesanan yang masih berstatus `pending`.

## Technologies

* **Laravel 12**
* **PHP 8.2+**
* **Tailwind CSS**
* **Vite**
* **Alpine.js**
* **MySQL / Database Laravel**
* **JavaScript**

Dependensi utama project tercatat menggunakan Laravel 12, PHP ^8.2, Tailwind CSS, Vite, dan Alpine.js.

## Installation

Clone repository:

```bash
git clone https://github.com/SulthanAfif/SenjaKopi.git
```

Masuk ke folder project:

```bash
cd SenjaKopi
```

Install dependency Laravel:

```bash
composer install
```

Install dependency frontend:

```bash
npm install
```

Buat file `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Konfigurasikan database pada file `.env`.

Jalankan migration:

```bash
php artisan migrate
```

Jalankan aplikasi Laravel:

```bash
php artisan serve
```

Pada terminal lain, jalankan Vite:

```bash
npm run dev
```

Untuk membuat build frontend:

```bash
npm run build
```

Project juga menyediakan script setup dan development melalui Composer.

## Screenshots

### Home

Tambahkan screenshot halaman utama SenjaKopi di sini.

### Menu

Tambahkan screenshot halaman daftar menu di sini.

### Detail Menu

Tambahkan screenshot halaman detail menu di sini.

### Keranjang

Tambahkan screenshot halaman keranjang di sini.

### Checkout

Tambahkan screenshot halaman checkout di sini.

### Pesanan

Tambahkan screenshot halaman pesanan di sini.

### Admin Dashboard

Tambahkan screenshot dashboard admin di sini.

### Admin Transactions

Tambahkan screenshot halaman transaksi admin di sini.

## Project Structure

Project menggunakan struktur Laravel dengan komponen utama:

```text
SenjaKopi/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── artisan
├── composer.json
├── package.json
├── vite.config.js
└── tailwind.config.js
```

Struktur repository saat ini juga mencakup folder `app`, `database`, `resources`, `routes`, `storage`, dan `tests`.

## Testing

Pengujian dilakukan dengan menjalankan fitur utama aplikasi, yaitu:

* Registrasi dan login pengguna
* Menampilkan menu
* Pencarian menu
* Filter kategori
* Menambahkan produk ke keranjang
* Mengubah jumlah produk
* Menghapus produk dari keranjang
* Checkout
* Pemilihan metode pembayaran
* Melihat pesanan
* Membatalkan pesanan
* Reorder pesanan
* Pengelolaan produk oleh admin
* Pengelolaan kategori oleh admin
* Pengelolaan transaksi oleh admin
* Perubahan status pesanan

## Status

✅ **Project selesai dikembangkan dan telah dideploy sebagai aplikasi web SenjaKopi.**
