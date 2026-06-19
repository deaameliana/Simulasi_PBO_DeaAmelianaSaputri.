<?php
// 1. Memanggil koneksi database
require_once 'koneksi.php';

// 2. Memanggil definisi kelas (Sesuaikan jika Anda menggabungkannya dalam 1 file atau terpisah)
require_once 'Pendaftaran.php';
require_once 'PendaftaranReguler.php';
require_once 'PendaftaranPrestasi.php';
require_once 'PendaftaranKedinasan.php';

// ==============================================================================
// TAHAP PENGAMBILAN DATA DAN INSTANSIASI OBJEK
// ==============================================================================

// Array penampung objek
$listReguler = [];
$listPrestasi = [];
$listKedinasan = [];

// Fetch Jalur Reguler
$dataReguler = PendaftaranReguler::getDaftarReguler($koneksi);
foreach ($dataReguler as $row) {
    $listReguler[] = new PendaftaranReguler(
        $row['id_pendaftaran'], $row['nama_calon'], $row['asal_sekolah'], 
        $row['nilai_ujian'], $row['biaya_pendaftaran_dasar'], 
        $row['pilihan_prodi'], $row['lokasi_kampus']
    );
}

// Fetch Jalur Prestasi
$dataPrestasi = PendaftaranPrestasi::getDaftarPrestasi($koneksi);
foreach ($dataPrestasi as $row) {
    $listPrestasi[] = new PendaftaranPrestasi(
        $row['id_pendaftaran'], $row['nama_calon'], $row['asal_sekolah'], 
        $row['nilai_ujian'], $row['biaya_pendaftaran_dasar'], 
        $row['jenis_prestasi'], $row['tingkat_prestasi']
    );
}

// Fetch Jalur Kedinasan
$dataKedinasan = PendaftaranKedinasan::getDaftarKedinasan($koneksi);
foreach ($dataKedinasan as $row) {
    $listKedinasan[] = new PendaftaranKedinasan(
        $row['id_pendaftaran'], $row['nama_calon'], $row['asal_sekolah'], 
        $row['nilai_ujian'], $row['biaya_pendaftaran_dasar'], 
        $row['sk_ikatan_dinas'], $row['instansi_sponsor']
    );
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pendaftaran Mahasiswa Baru</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 20px; background-color: #f9f9f9; color: #333; }
        h1 { text-align: center; color: #2c3e50; }
        h2 { border-bottom: 2px solid #3498db; padding-bottom: 5px; color: #2980b9; margin-top: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background-color: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #e0e0e0; padding: 12px; text-align: left; }
        th { background-color: #34495e; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .badge { background-color: #e74c3c; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .info-cell { line-height: 1.5; }
    </style>
</head>
<body>

    <h1>Sistem Informasi Pendaftaran Mahasiswa Baru</h1>
    <p style="text-align: center;">Simulasi Pemrograman Berorientasi Objek (PBO) - PHP & MySQL</p>

    <h2>1. Data Pendaftar - Jalur Reguler</h2>
    <table>
        <thead>
            <tr>
                <th>No Pendaftaran</th>
                <th>Nama Calon</th>
                <th>Asal Sekolah</th>
                <th>Nilai Ujian</th>
                <th>Informasi Spesifik Jalur (Polimorfisme)</th>
                <th>Total Biaya Akhir (Polimorfisme)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listReguler as $mhs): ?>
            <tr>
                <td>#REG-<?= str_pad($mhs->getIdPendaftaran(), 4, '0', STR_PAD_LEFT); ?></td>
                <td><strong><?= $mhs->getNamaCalon(); ?></strong></td>
                <td><?= $mhs->getAsalSekolah(); ?></td>
                <td><?= $mhs->getNilaiUjian(); ?></td>
                <td class="info-cell"><?= $mhs->tampilkanInfoJalur(); ?></td>
                <td>Rp <?= number_format($mhs->hitungTotalBiaya(), 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>2. Data Pendaftar - Jalur Prestasi <span class="badge">Diskon Rp50.000</span></h2>
    <table>
        <thead>
            <tr>
                <th>No Pendaftaran</th>
                <th>Nama Calon</th>
                <th>Asal Sekolah</th>
                <th>Nilai Ujian</th>
                <th>Informasi Spesifik Jalur (Polimorfisme)</th>
                <th>Total Biaya Akhir (Polimorfisme)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listPrestasi as $mhs): ?>
            <tr>
                <td>#PRS-<?= str_pad($mhs->getIdPendaftaran(), 4, '0', STR_PAD_LEFT); ?></td>
                <td><strong><?= $mhs->getNamaCalon(); ?></strong></td>
                <td><?= $mhs->getAsalSekolah(); ?></td>
                <td><?= $mhs->getNilaiUjian(); ?></td>
                <td class="info-cell"><?= $mhs->tampilkanInfoJalur(); ?></td>
                <td>Rp <?= number_format($mhs->hitungTotalBiaya(), 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>3. Data Pendaftar - Jalur Kedinasan <span class="badge">Surcharge 25%</span></h2>
    <table>
        <thead>
            <tr>
                <th>No Pendaftaran</th>
                <th>Nama Calon</th>
                <th>Asal Sekolah</th>
                <th>Nilai Ujian</th>
                <th>Informasi Spesifik Jalur (Polimorfisme)</th>
                <th>Total Biaya Akhir (Polimorfisme)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listKedinasan as $mhs): ?>
            <tr>
                <td>#KED-<?= str_pad($mhs->getIdPendaftaran(), 4, '0', STR_PAD_LEFT); ?></td>
                <td><strong><?= $mhs->getNamaCalon(); ?></strong></td>
                <td><?= $mhs->getAsalSekolah(); ?></td>
                <td><?= $mhs->getNilaiUjian(); ?></td>
                <td class="info-cell"><?= $mhs->tampilkanInfoJalur(); ?></td>
                <td>Rp <?= number_format($mhs->hitungTotalBiaya(), 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>