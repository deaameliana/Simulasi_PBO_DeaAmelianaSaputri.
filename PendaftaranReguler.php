<?php

class PendaftaranReguler extends Pendaftaran {
    // Properti tambahan khusus jalur Reguler
    private $pilihanProdi;
    private $lokasiKampus;

    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $pilihanProdi, $lokasiKampus) {
        // Memanggil constructor dari class induk (Pendaftaran)
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        
        $this->pilihanProdi = $pilihanProdi;
        $this->lokasiKampus = $lokasiKampus;
    }

    // Implementasi wajib dari metode abstrak
    public function hitungTotalBiaya() {
        // Asumsi: Jalur reguler membayar penuh biaya pendaftaran dasar
        return $this->biayaPendaftaranDasar;

        // Tarif standar murni tanpa biaya tambahan seleksi/tes laboratorium
        return $this->biayaPendaftaranDasar;
    }

    // Implementasi wajib dari metode abstrak
    public function tampilkanInfoJalur() {
        return "Jalur: Reguler | Program Studi: {$this->pilihanProdi} | Lokasi Kampus: {$this->lokasiKampus}";
    }

    // Metode Query Spesifik
    public static function getDaftarReguler($db) {
        $query = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = 'Reguler'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
}

?>