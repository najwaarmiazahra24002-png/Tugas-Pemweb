<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <?php
    // Include functions
    require_once 'functions_anggota.php';
    
    // Data anggota
    $anggota_list = [
        // TODO: Isi data anggota minimal 5
        ["id"=>"AGT-001","nama"=>"Budi Santoso","email"=>"budi@email.com","telepon"=>"0812","alamat"=>"Jakarta","tanggal_daftar"=>"2024-01-15","status"=>"Aktif","total_pinjaman"=>5],
        ["id"=>"AGT-002","nama"=>"Siti Aminah","email"=>"siti@email.com","telepon"=>"0822","alamat"=>"Bandung","tanggal_daftar"=>"2024-02-10","status"=>"Aktif","total_pinjaman"=>8],
        ["id"=>"AGT-003","nama"=>"Andi Wijaya","email"=>"andi@email.com","telepon"=>"0833","alamat"=>"Surabaya","tanggal_daftar"=>"2024-03-05","status"=>"Non-Aktif","total_pinjaman"=>2],
        ["id"=>"AGT-004","nama"=>"Dewi Lestari","email"=>"dewi@email.com","telepon"=>"0844","alamat"=>"Jogja","tanggal_daftar"=>"2024-01-20","status"=>"Aktif","total_pinjaman"=>12],
        ["id"=>"AGT-005","nama"=>"Rudi Hartono","email"=>"rudi@email.com","telepon"=>"0855","alamat"=>"Semarang","tanggal_daftar"=>"2024-02-25","status"=>"Non-Aktif","total_pinjaman"=>4],
    ];

    // function sort anggota by nama
    function sort_by_nama($data) {
        usort($data, function($a, $b) {
            return strcmp($a['nama'], $b['nama']);
        });
        return $data;
    }

    function search_by_nama($data, $keyword) {
        $hasil = [];
        foreach ($data as $d) {
            if (stripos($d['nama'], $keyword) !== false) {
                $hasil[] = $d;
            }
        }
        return $hasil;
    }

    // implementasi sort
    $anggota_list = sort_by_nama($anggota_list);

    // implementasi search
    if (isset($_GET['search']) && $_GET['search'] != "") {
        $anggota_list = search_by_nama($anggota_list, $_GET['search']);
    }

    // Statistik pakai function
    $total = hitung_total_anggota($anggota_list);
    $aktif = hitung_anggota_aktif($anggota_list);
    $nonaktif = $total - $aktif;
    $rata = hitung_rata_rata_pinjaman($anggota_list);
    $teraktif = cari_anggota_teraktif($anggota_list);

    $persen_aktif = ($total > 0) ? ($aktif/$total)*100 : 0;
    $persen_nonaktif = ($total > 0) ? ($nonaktif/$total)*100 : 0;
    ?>
    
    <div class="container mt-5">
        <h1 class="mb-4"><i class="bi bi-people"></i> Sistem Anggota Perpustakaan</h1>

        <!-- search -->
        <form method="GET" class="mb-3">
            <input type="text" name="search" class="form-control" placeholder="Cari nama anggota...">
        </form>
        
        <!-- Dashboard Statistik -->
        <div class="row mb-4">
            <!-- TODO: Cards statistik -->
             <div class="col-md-3">
                <div class="card text-bg-primary p-3">
                    <h6>Total Anggota</h6>
                    <h3><?= $total ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-success p-3">
                    <h6>Aktif (%)</h6>
                    <h3><?= round($persen_aktif) ?>%</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-danger p-3">
                    <h6>Non-Aktif (%)</h6>
                    <h3><?= round($persen_nonaktif) ?>%</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-warning p-3">
                    <h6>Rata Pinjaman</h6>
                    <h3><?= number_format($rata,1) ?></h3>
                </div>
            </div>
        </div>
        
        <!-- Tabel Anggota -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Anggota</h5>
            </div>
            <div class="card-body">
                <!-- TODO: Tabel anggota -->
                 <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Total Pinjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($anggota_list as $a) { ?>
                        <tr>
                            <td><?= $a['id'] ?></td>
                            <td><?= $a['nama'] ?></td>
                            <td><?= $a['email'] ?></td>
                            <td>
                                <?php if ($a['status']=="Aktif") { ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">Non-Aktif</span>
                                <?php } ?>
                            </td>
                            <td><?= $a['total_pinjaman'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table> 
            </div>
        </div>
        
        <!-- Anggota Teraktif -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Anggota Teraktif</h5>
            </div>
            <div class="card-body">
                <!-- TODO: Info anggota teraktif -->
                <h5><?= $teraktif['nama'] ?></h5>
                <p>ID: <?= $teraktif['id'] ?></p>
                <p>Total Pinjaman: <b><?= $teraktif['total_pinjaman'] ?></b></p> 
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>