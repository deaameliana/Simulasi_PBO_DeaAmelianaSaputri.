<?php

class PendaftaranPrestasi extends Pendaftaran {
    // Properti tambahan khusus jalur Prestasi
    private $jenisPrestasi;
    private $tingkatPrestasi;

    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $jenisPrestasi, $tingkatPrestasi) {
        // Memanggil constructor dari class induk
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        
        $this->jenisPrestasi = $jenisPrestasi;
        $this->tingkatPrestasi = $tingkatPrestasi;
    }

    // Implementasi wajib dari metode abstrak
    public function hitungTotalBiaya() {
        // Asumsi: Jalur prestasi mendapat potongan harga Rp 50.000
        $diskon = 50000;
        $total = $this->biayaPendaftaranDasar - $diskon;
        return ($total > 0) ? $total : 0;
    }

    // Implementasi wajib dari metode abstrak
    public function tampilkanInfoJalur() {
        return "Jalur: Prestasi | Jenis: {$this->jenisPrestasi} | Tingkat: {$this->tingkatPrestasi}";
    }

    // Metode Query Spesifik
    public static function getDaftarPrestasi($db) {
        $query = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = 'Prestasi'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>