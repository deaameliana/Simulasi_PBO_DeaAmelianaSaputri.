<?php
// Konfigurasi Database
$host     = "localhost";
$username = "root";         // Sesuaikan dengan username MySQL Anda (bawaan XAMPP: root)
$password = "";             // Sesuaikan dengan password MySQL Anda (bawaan XAMPP: kosong)
$dbname   = "DB_SIMULASI_PBO_TRPL1A_Dea";

try {
    // Membuat koneksi menggunakan PDO
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $koneksi = new PDO($dsn, $username, $password);
    
    // Mengatur atribut PDO untuk menampilkan error/exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Mengatur default fetch mode menjadi object atau associative array
    $koneksi->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Catatan: Baris di bawah ini bisa dihapus jika sudah masuk tahap produksi (production)
    // echo "Koneksi ke database berhasil!"; 
    
} catch (PDOException $e) {
    // Menampilkan pesan jika koneksi gagal
    die("Koneksi database gagal: " . $e->getMessage());
}
?>