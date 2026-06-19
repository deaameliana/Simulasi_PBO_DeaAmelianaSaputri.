<?php

// Menggunakan keyword 'abstract' untuk menandakan kelas ini tidak bisa diinstansiasi langsung
abstract class Pendaftaran {
    
    // =========================================================================
    // 3. Properti/Atribut Terenkapsulasi (protected)
    // Atribut ini hanya bisa diakses oleh kelas ini sendiri dan kelas turunannya (anak)
    // =========================================================================
    protected $id_pendaftaran;
    protected $nama_calon;
    protected $asal_sekolah;
    protected $nilai_ujian;
    protected $biayaPendaftaranDasar; // Memetakan kolom 'biaya_pendaftaran_dasar' dari DB

    // Magic Method Constructor untuk memetakan data dari database ke properti objek
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar) {
        $this->id_pendaftaran = $id_pendaftaran;
        $this->nama_calon = $nama_calon;
        $this->asal_sekolah = $asal_sekolah;
        $this->nilai_ujian = $nilai_ujian;
        $this->biayaPendaftaranDasar = $biayaPendaftaranDasar;
    }

    // =========================================================================
    // 4. Metode Abstrak (Tanpa Isi/Body)
    // Wajib diimplementasikan (override) oleh semua kelas anak/turunannya
    // =========================================================================
    
    /**
     * Menghitung total biaya pendaftaran berdasarkan jalur spesifik.
     * Masing-masing kelas anak (Reguler, Prestasi, Kedinasan) akan memiliki rumus yang berbeda.
     */
    abstract public function hitungTotalBiaya();

    /**
     * Menampilkan informasi spesifik mengenai jalur pendaftaran yang dipilih.
     */
    abstract public function tampilkanInfoJalur();


    // =========================================================================
    // Getter Methods (Opsional namun direkomendasikan dalam Enkapsulasi)
    // Digunakan agar kelas luar (seperti file tampilan/view) tetap bisa membaca data protected
    // =========================================================================
    public function getIdPendaftaran() {
        return $this->id_pendaftaran;
    }

    public function getNamaCalon() {
        return $this->nama_calon;
    }

    public function getAsalSekolah() {
        return $this->asal_sekolah;
    }

    public function getNilaiUjian() {
        return $this->nilai_ujian;
    }

    public function getBiayaPendaftaranDasar() {
        return $this->biayaPendaftaranDasar;
    }
}