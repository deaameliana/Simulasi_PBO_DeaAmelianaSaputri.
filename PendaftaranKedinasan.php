<?php

class PendaftaranKedinasan extends Pendaftaran {
    // Properti tambahan khusus jalur Kedinasan
    private $skIkatanDinas;
    private $instansiSponsor;

    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $skIkatanDinas, $instansiSponsor) {
        // Memanggil constructor dari class induk
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        
        $this->skIkatanDinas = $skIkatanDinas;
        $this->instansiSponsor = $instansiSponsor;
    }

    // Implementasi wajib dari metode abstrak
    public function hitungTotalBiaya() {
        // Asumsi: Jalur kedinasan digratiskan (Rp 0) karena ditanggung instansi
        return 0;
    }

    // Implementasi wajib dari metode abstrak
    public function tampilkanInfoJalur() {
        return "Jalur: Kedinasan | Instansi: {$this->instansiSponsor} | No. SK: {$this->skIkatanDinas}";
    }

    // Metode Query Spesifik
    public static function getDaftarKedinasan($db) {
        $query = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = 'Kedinasan'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>