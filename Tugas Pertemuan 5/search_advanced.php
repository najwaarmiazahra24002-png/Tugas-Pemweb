<?php
// Data buku (minimal 10)
$buku_list = [
    // TODO: Isi dengan 10+ data buku
    ["kode"=>"B001","judul"=>"Belajar PHP","kategori"=>"Programming","pengarang"=>"Andi","penerbit"=>"Informatika","tahun"=>2020,"harga"=>75000,"stok"=>5],
    ["kode"=>"B002","judul"=>"Dasar Java","kategori"=>"Programming","pengarang"=>"Budi","penerbit"=>"Elex","tahun"=>2019,"harga"=>85000,"stok"=>0],
    ["kode"=>"B003","judul"=>"MySQL Mastery","kategori"=>"Database","pengarang"=>"Citra","penerbit"=>"Andi","tahun"=>2021,"harga"=>95000,"stok"=>3],
    ["kode"=>"B004","judul"=>"UI UX Design","kategori"=>"Design","pengarang"=>"Dewi","penerbit"=>"Gramedia","tahun"=>2022,"harga"=>120000,"stok"=>2],
    ["kode"=>"B005","judul"=>"Jaringan Komputer","kategori"=>"Networking","pengarang"=>"Eko","penerbit"=>"Elex","tahun"=>2018,"harga"=>65000,"stok"=>0],
    ["kode"=>"B006","judul"=>"Python Dasar","kategori"=>"Programming","pengarang"=>"Fajar","penerbit"=>"Informatika","tahun"=>2023,"harga"=>110000,"stok"=>7],
    ["kode"=>"B007","judul"=>"Algoritma","kategori"=>"Programming","pengarang"=>"Gita","penerbit"=>"Andi","tahun"=>2017,"harga"=>70000,"stok"=>1],
    ["kode"=>"B008","judul"=>"Data Science","kategori"=>"Data","pengarang"=>"Hadi","penerbit"=>"Gramedia","tahun"=>2022,"harga"=>150000,"stok"=>4],
    ["kode"=>"B009","judul"=>"Machine Learning","kategori"=>"Data","pengarang"=>"Indra","penerbit"=>"Elex","tahun"=>2023,"harga"=>175000,"stok"=>0],
    ["kode"=>"B010","judul"=>"Web Design","kategori"=>"Design","pengarang"=>"Joko","penerbit"=>"Informatika","tahun"=>2021,"harga"=>90000,"stok"=>6],
];
 
// Ambil parameter GET
$keyword = $_GET['keyword'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$status = $_GET['status'] ?? 'semua';
$sort = $_GET['sort'] ?? 'judul';
$page = $_GET['page'] ?? 1;
 
// Validasi
$errors = [];
 
if (!empty($min_harga) && !empty($max_harga)) {
    if ($min_harga > $max_harga) {
        $errors[] = "Harga minimum tidak boleh lebih besar dari harga maksimum";
    }
}

if (!empty($tahun) && ($tahun < 1900 || $tahun > date('Y'))) {
    $errors[] = "Tahun tidak valid";
}
 
// TODO: Filter
$hasil = [];

foreach ($buku_list as $b) {

    if ($keyword && !stripos($b['judul'].$b['pengarang'], $keyword)) continue;
    if ($kategori && $b['kategori'] != $kategori) continue;
    if ($min_harga && $b['harga'] < $min_harga) continue;
    if ($max_harga && $b['harga'] > $max_harga) continue;
    if ($tahun && $b['tahun'] != $tahun) continue;

    if ($status == 'tersedia' && $b['stok'] <= 0) continue;
    if ($status == 'habis' && $b['stok'] > 0) continue;

    $hasil[] = $b;
}

// TODO: sorting
usort($hasil, function($a, $b) use ($sort) {
    return $a[$sort] <=> $b[$sort];
});

// pagination
$perPage = 10;
$totalData = count($hasil);
$totalPage = ceil($totalData / $perPage);
$start = ($page - 1) * $perPage;
$hasil = array_slice($hasil, $start, $perPage);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Advanced</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-4">
        <h3>Pencarian Buku</h3>
        <!-- FORM -->
        <form method="GET" class="row g-2 mb-3">
            <input type="text" name="keyword" class="form-control col" placeholder="Keyword" value="<?= $keyword ?>">
            <select name="kategori" class="form-control col">
                <option value="">Semua Kategori</option>
                <option <?= ($kategori=="Programming")?'selected':'' ?>>Programming</option>
                <option <?= ($kategori=="Database")?'selected':'' ?>>Database</option>
                <option <?= ($kategori=="Design")?'selected':'' ?>>Design</option>
                <option <?= ($kategori=="Data")?'selected':'' ?>>Data</option>
            </select>
            
            <input type="number" name="min_harga" placeholder="Min Harga" value="<?= $min_harga ?>">
            <input type="number" name="max_harga" placeholder="Max Harga" value="<?= $max_harga ?>">
            <input type="number" name="tahun" placeholder="Tahun" value="<?= $tahun ?>">

            <!-- STATUS RADIO -->
            <div>
            <input type="radio" name="status" value="semua" <?= ($status=="semua")?'checked':'' ?>> Semua
            <input type="radio" name="status" value="tersedia" <?= ($status=="tersedia")?'checked':'' ?>> Tersedia
            <input type="radio" name="status" value="habis" <?= ($status=="habis")?'checked':'' ?>> Habis
            </div>

            <select name="sort">
            <option value="judul">Judul</option>
            <option value="harga">Harga</option>
            <option value="tahun">Tahun</option>
            </select>

            <button class="btn btn-primary">Cari</button>
            </form>
            
            <!-- ERROR -->
            <?php if ($errors): ?>
            <div class="alert alert-danger">
            <?php foreach ($errors as $e) echo "<div>$e</div>"; ?>
            </div>
            <?php endif; ?>

            <!-- HASIL -->
            <p><b><?= $totalData ?></b> hasil ditemukan</p>

            <table class="table table-bordered">
                <tr>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Harga</th>
                    <th>Status</th>
                </tr>
                
                <?php foreach ($hasil as $h): ?>
                    <tr>
                        <td><?= $h['kode'] ?></td>
                        <td><?= $h['judul'] ?></td>
                        <td><?= $h['kategori'] ?></td>
                        <td><?= $h['pengarang'] ?></td>
                        <td><?= $h['penerbit'] ?></td>
                        <td><?= $h['tahun'] ?></td>
                        <td><?= $h['harga'] ?></td>
                        <td><?= $h['stok'] > 0 ? 'Tersedia' : 'Habis' ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <!-- PAGINATION -->
            <?php for ($i=1; $i <= $totalPage; $i++): ?>
                <a href="?page=<?= $i ?>&keyword=<?= $keyword ?>&kategori=<?= $kategori ?>&status=<?= $status ?>"
                class="btn btn-sm btn-secondary"><?= $i ?></a>
            <?php endfor; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>