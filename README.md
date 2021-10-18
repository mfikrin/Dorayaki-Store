# Tugas Besar I IF3110 WBD 2021 Kelompok 41 - GiantSun
> Monolithic Web App - Dorayaki Store

## Table of contents
  - [Deskripsi Aplikasi Web](#deskripsi-aplikasi-web)
  - [Requirements](#requirements)
  - [Cara Instalasi](#cara-instalasi)
  - [Cara Menjalankan Server](#cara-menjalankan-server)
  - [Screenshots](#screenshots)
  - [Pembagian Tugas](#pembagian-tugas)

## Deskripsi Aplikasi Web
Aplikasi Web Monolitik berbasiskan PHP, JavaScript, AJAX, dan dilengkapi basis data menggunakan SQLite. Aplikasi Web mensimulasikan online shop dorayaki sederhana yang menitikberatkan pada manajemen stok item-item dorayaki.
Fitur-fitur yang tersedia meliputi :
- Autentikasi Pengguna
- Pengelolaan Varian Dorayaki
- Manajemen Stok Dorayaki
- Melihat Daftar Varian Dorayaki
- Melihat Riwayat Perubahan Stok Dorayaki
- Pembelian Dorayaki
- Melihat Riwayat Pembelian Dorayaki

## Requirements
1. [XAMPP](https://www.apachefriends.org/download.html) , dilengkapi PHP dan SQLite
2. Web Browser

## Cara Instalasi
0. Download dan Install [XAMPP](https://www.apachefriends.org/download.html)
1. Pastikan PHP sudah berada pada Path pada Environment Variable : masukkan path direktori yang mengandung `php.exe` pada Path Environment Variable
2. Pastikan SQLite sudah di config pada `php.ini` yang dapat diakses pada bagian Config pada antarmuka XAMPP Module Apache , un-comment `extension=pdo_sqlite` dan `extension=sqlite3`
3. Download repositori ini (tugas-besar-1), taruh di dalam direktori instalasi XAMPP pada `xampp/htdocs`

## Cara Menjalankan Server
0. Run XAMPP, start module Apache dan MySQL
1. Run command line, change directory ke direktori tempat aplikasi web berada `xampp/htdocs/tugas-besar-1`, run command `php -S localhost:port-number`, jika port number yang digunakan adalah 8080 maka command yang digunakan `php -S localhost:8080`
2.  Untuk inisialisasi basis data, pergi ke URL `localhost:8080/db/init_db.php` dan `localhost:8080/db/init_sample.php` pada browser (untuk inisialisasi sampel data); Asumsi port yang digunakan = 8080
3.  Jika data sudah diinisialisasi, dapat mengakses aplikasi web dengan pergi ke URL `localhost:8080` pada browser
  
## Screenshots

## Pembagian Tugas
