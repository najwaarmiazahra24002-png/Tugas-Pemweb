<?php
// 1. Function untuk hitung total anggota
function hitung_total_anggota($anggota_list) {
    return count($anggota_list);
}

// 2. Function untuk hitung anggota aktif
function hitung_anggota_aktif($anggota_list) {
    $total = 0;
    foreach ($anggota_list as $agt) {
        if ($agt['status'] == "Aktif") {
            $total++;
        }
    }
    return $total;
}

// 3. Function untuk hitung rata-rata pinjaman
function hitung_rata_rata_pinjaman($anggota_list) {
    $total = 0;
    $jumlah = count($anggota_list);

    foreach ($anggota_list as $agt) {
        $total += $agt['total_pinjaman'];
    }

    return ($jumlah > 0) ? $total / $jumlah : 0;
}

// 4. Function untuk cari anggota by ID
function cari_anggota_by_id($anggota_list, $id) {
    foreach ($anggota_list as $agt) {
        if ($agt['id'] == $id) {
            return $agt;
        }
    }
    return null;
}

// 5. Function untuk cari anggota teraktif
function cari_anggota_teraktif($anggota_list) {
    $teraktif = $anggota_list[0];

    foreach ($anggota_list as $agt) {
        if ($agt['total_pinjaman'] > $teraktif['total_pinjaman']) {
            $teraktif = $agt;
        }
    }

    return $teraktif;
}

// 6. Function untuk filter by status
function filter_by_status($anggota_list, $status) {
    $hasil = [];

    foreach ($anggota_list as $agt) {
        if ($agt['status'] == $status) {
            $hasil[] = $agt;
        }
    }

    return $hasil;
}

// 7. Function untuk validasi email
function validasi_email($email) {
    if (empty($email)) {
        return false;
    }

    if (strpos($email, '@') === false) {
        return false;
    }

    if (strpos($email, '.') === false) {
        return false;
    }

    return true;
}

// 8. Function untuk format tanggal Indonesia
function format_tanggal_indo($tanggal) {
    $bulan = [
        1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    $pecah = explode('-', $tanggal);
    $tahun = $pecah[0];
    $bulan_ke = (int)$pecah[1];
    $hari = $pecah[2];

    return $hari . " " . $bulan[$bulan_ke] . " " . $tahun;
}
?>