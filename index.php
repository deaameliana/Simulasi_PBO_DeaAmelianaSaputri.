<?php
// 1. Memanggil koneksi database
require_once 'koneksi.php';
 
// 2. Memanggil definisi kelas
require_once 'Pendaftaran.php';
require_once 'PendaftaranReguler.php';
require_once 'PendaftaranPrestasi.php';
require_once 'PendaftaranKedinasan.php';

// ==============================================================================
// TAHAP PENGAMBILAN DATA DAN INSTANSIASI OBJEK
// ==============================================================================

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

// Menghitung total data untuk widget Dashboard
$totalReguler = count($listReguler);
$totalPrestasi = count($listPrestasi);
$totalKedinasan = count($listKedinasan);
$totalSemua = $totalReguler + $totalPrestasi + $totalKedinasan;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pendaftaran Mahasiswa Baru</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* === RESET & BASE STYLES === */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f4f7f6; color: #333; display: flex; flex-direction: column; min-height: 100vh; }

        /* === LAYOUT === */
        .wrapper { display: flex; flex: 1; overflow: hidden; margin-top: 60px; }
        .main-content { flex: 1; padding: 30px; overflow-y: auto; background-color: #f4f7f6; margin-left: 260px;}

        /* === NAVBAR === */
        .navbar {
            position: fixed; top: 0; width: 100%; height: 60px;
            background: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex; justify-content: space-between; align-items: center;
            padding: 0 30px; z-index: 1000;
        }
        .navbar .brand { font-size: 22px; font-weight: 700; color: #2c3e50; display: flex; align-items: center; gap: 10px; }
        .navbar .brand i { color: #3498db; }
        .navbar .user-profile { display: flex; align-items: center; gap: 10px; font-weight: 500; color: #7f8c8d; cursor: pointer;}
        .navbar .user-profile img { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #3498db;}

        /* === SIDEBAR === */
        .sidebar {
            width: 260px; background: #2c3e50; color: #fff;
            display: flex; flex-direction: column; padding-top: 20px;
            transition: all 0.3s ease; height: calc(100vh - 60px); position: fixed;
        }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu li { margin-bottom: 5px; }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 15px; padding: 15px 25px;
            color: #bdc3c7; text-decoration: none; font-weight: 500; transition: 0.3s;
            cursor: pointer;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: #34495e; color: #fff; border-left: 4px solid #3498db;
        }
        .sidebar-menu a i { width: 20px; text-align: center; font-size: 18px; }

        /* === CONTENT HEADER === */
        .content-header { margin-bottom: 30px; }
        .content-header h1 { font-size: 24px; color: #2c3e50; }
        .content-header p { color: #7f8c8d; font-size: 14px; margin-top: 5px; }

        /* === TAB SYSTEM === */
        .content-section { display: none; animation: fadeIn 0.4s ease-in-out; }
        .content-section.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* === WIDGETS === */
        .widget-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;}
        .widget { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 20px;}
        .widget-icon { width: 60px; height: 60px; border-radius: 15px; display: flex; justify-content: center; align-items: center; font-size: 24px; }
        .widget-icon.blue { background: rgba(52, 152, 219, 0.1); color: #3498db; }
        .widget-icon.orange { background: rgba(243, 156, 18, 0.1); color: #f39c12; }
        .widget-icon.red { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
        .widget-icon.green { background: rgba(46, 204, 113, 0.1); color: #2ecc71; }
        .widget-info h3 { font-size: 28px; color: #2c3e50; margin-bottom: 5px;}
        .widget-info p { color: #7f8c8d; font-size: 13px; font-weight: 500;}

        /* === CARDS & TABLES === */
        .card { background: #fff; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 30px; padding: 20px 25px; overflow-x: auto;}
        .card-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f2f6; padding-bottom: 15px; margin-bottom: 15px;}
        .card-header h2 { font-size: 18px; color: #2c3e50; display: flex; align-items: center; gap: 10px; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 14px 15px; text-align: left; font-size: 14px; border-bottom: 1px solid #f1f2f6; }
        th { background-color: #f8f9fa; color: #2c3e50; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; }
        tr:hover { background-color: #fcfcfc; }
        
        /* === BADGES === */
        .badge { padding: 5px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;}
        .badge.primary { background: rgba(52, 152, 219, 0.1); color: #3498db; }
        .badge.success { background: rgba(46, 204, 113, 0.1); color: #27ae60; }
        .badge.warning { background: rgba(243, 156, 18, 0.1); color: #d35400; }
        .badge.danger { background: rgba(231, 76, 60, 0.1); color: #c0392b; }
        
        .id-text { color: #7f8c8d; font-family: monospace; background: #f4f7f6; padding: 3px 8px; border-radius: 4px; }
        .money { font-weight: 600; color: #2c3e50; }
        .info-cell { color: #7f8c8d; font-size: 13px; line-height: 1.6;}
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="brand">
            <i class="fas fa-graduation-cap"></i> SiPMa
        </div>
        <div class="user-profile">
            <span>Admin Akademik</span>
            <img src="https://ui-avatars.com/api/?name=Admin+Akademik&background=3498db&color=fff" alt="User">
        </div>
    </nav>

    <div class="wrapper">
        
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a class="nav-link active" onclick="switchTab('sec-dashboard', this)"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a class="nav-link" onclick="switchTab('sec-reguler', this)"><i class="fas fa-users"></i> Jalur Reguler</a></li>
                <li><a class="nav-link" onclick="switchTab('sec-prestasi', this)"><i class="fas fa-trophy"></i> Jalur Prestasi</a></li>
                <li><a class="nav-link" onclick="switchTab('sec-kedinasan', this)"><i class="fas fa-building"></i> Jalur Kedinasan</a></li>
            </ul>
        </aside>

        <main class="main-content">
            
            <div class="content-header">
                <h1 id="page-title">Dashboard Utama</h1>
                <p>Sistem Informasi Pendaftaran Mahasiswa Baru</p>
            </div>

            <div id="sec-dashboard" class="content-section active">
                <div class="widget-container">
                    <div class="widget">
                        <div class="widget-icon green"><i class="fas fa-user-graduate"></i></div>
                        <div class="widget-info">
                            <h3><?= $totalSemua; ?></h3>
                            <p>Total Pendaftar</p>
                        </div>
                    </div>
                    <div class="widget">
                        <div class="widget-icon blue"><i class="fas fa-users"></i></div>
                        <div class="widget-info">
                            <h3><?= $totalReguler; ?></h3>
                            <p>Jalur Reguler</p>
                        </div>
                    </div>
                    <div class="widget">
                        <div class="widget-icon orange"><i class="fas fa-trophy"></i></div>
                        <div class="widget-info">
                            <h3><?= $totalPrestasi; ?></h3>
                            <p>Jalur Prestasi</p>
                        </div>
                    </div>
                    <div class="widget">
                        <div class="widget-icon red"><i class="fas fa-building"></i></div>
                        <div class="widget-info">
                            <h3><?= $totalKedinasan; ?></h3>
                            <p>Jalur Kedinasan</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="sec-reguler" class="content-section active">
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-users" style="color: #3498db;"></i> Data Pendaftar - Jalur Reguler</h2>
                        <span class="badge primary">Standar</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID Daftar</th>
                                <th>Nama Calon</th>
                                <th>Asal Sekolah</th>
                                <th>Skor</th>
                                <th>Informasi Spesifik Jalur</th>
                                <th>Total Biaya Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listReguler as $mhs): ?>
                            <tr>
                                <td><span class="id-text">#REG-<?= str_pad($mhs->getIdPendaftaran(), 4, '0', STR_PAD_LEFT); ?></span></td>
                                <td><strong><?= $mhs->getNamaCalon(); ?></strong></td>
                                <td><?= $mhs->getAsalSekolah(); ?></td>
                                <td><strong><?= $mhs->getNilaiUjian(); ?></strong></td>
                                <td class="info-cell"><?= $mhs->tampilkanInfoJalur(); ?></td>
                                <td class="money">Rp <?= number_format($mhs->hitungTotalBiaya(), 0, ',', '.'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="sec-prestasi" class="content-section active">
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-trophy" style="color: #f39c12;"></i> Data Pendaftar - Jalur Prestasi</h2>
                        <span class="badge success">Diskon Rp 50.000</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID Daftar</th>
                                <th>Nama Calon</th>
                                <th>Asal Sekolah</th>
                                <th>Skor</th>
                                <th>Informasi Spesifik Jalur</th>
                                <th>Total Biaya Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listPrestasi as $mhs): ?>
                            <tr>
                                <td><span class="id-text">#PRS-<?= str_pad($mhs->getIdPendaftaran(), 4, '0', STR_PAD_LEFT); ?></span></td>
                                <td><strong><?= $mhs->getNamaCalon(); ?></strong></td>
                                <td><?= $mhs->getAsalSekolah(); ?></td>
                                <td><strong><?= $mhs->getNilaiUjian(); ?></strong></td>
                                <td class="info-cell"><?= $mhs->tampilkanInfoJalur(); ?></td>
                                <td class="money">Rp <?= number_format($mhs->hitungTotalBiaya(), 0, ',', '.'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="sec-kedinasan" class="content-section active">
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-building" style="color: #e74c3c;"></i> Data Pendaftar - Jalur Kedinasan</h2>
                        <span class="badge danger">Surcharge 25%</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID Daftar</th>
                                <th>Nama Calon</th>
                                <th>Asal Sekolah</th>
                                <th>Skor</th>
                                <th>Informasi Spesifik Jalur</th>
                                <th>Total Biaya Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listKedinasan as $mhs): ?>
                            <tr>
                                <td><span class="id-text">#KED-<?= str_pad($mhs->getIdPendaftaran(), 4, '0', STR_PAD_LEFT); ?></span></td>
                                <td><strong><?= $mhs->getNamaCalon(); ?></strong></td>
                                <td><?= $mhs->getAsalSekolah(); ?></td>
                                <td><strong><?= $mhs->getNilaiUjian(); ?></strong></td>
                                <td class="info-cell"><?= $mhs->tampilkanInfoJalur(); ?></td>
                                <td class="money">Rp <?= number_format($mhs->hitungTotalBiaya(), 0, ',', '.'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <script>
        function switchTab(sectionId, clickedElement) {
            // 1. Sembunyikan SEMUA section terlebih dahulu
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(sec => sec.classList.remove('active'));

            // 2. Hapus class 'active' dari semua tombol menu di sidebar
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => link.classList.remove('active'));

            // 3. Logika Menampilkan Konten
            const pageTitle = document.getElementById('page-title');

            if (sectionId === 'sec-dashboard') {
                // JIKA DASHBOARD: Tampilkan Widget DAN Ketiga Tabel Sekaligus
                document.getElementById('sec-dashboard').classList.add('active');
                document.getElementById('sec-reguler').classList.add('active');
                document.getElementById('sec-prestasi').classList.add('active');
                document.getElementById('sec-kedinasan').classList.add('active');
                pageTitle.innerText = 'Dashboard Utama';
            } else {
                // JIKA MENU JALUR: Tampilkan HANYA tabel yang dipilih
                document.getElementById(sectionId).classList.add('active');
                
                if(sectionId === 'sec-reguler') pageTitle.innerText = 'Data Pendaftar Jalur Reguler';
                if(sectionId === 'sec-prestasi') pageTitle.innerText = 'Data Pendaftar Jalur Prestasi';
                if(sectionId === 'sec-kedinasan') pageTitle.innerText = 'Data Pendaftar Jalur Kedinasan';
            }

            // 4. Beri warna pada menu sidebar yang sedang diklik
            clickedElement.classList.add('active');
        }
    </script>

</body>
</html>