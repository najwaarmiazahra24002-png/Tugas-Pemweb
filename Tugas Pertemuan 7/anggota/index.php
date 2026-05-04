<?php
$page_title = "Data Anggota";
require_once '../../config/database.php';
require_once '../../includes/header.php';

// Pagination
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? $_GET['search'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$jk = isset($_GET['jk']) ? $_GET['jk'] : '';

// Query
$query = "SELECT * FROM anggota WHERE 1=1";
if ($search != '') {
    $query .= " AND (
        nama LIKE '%$search%' OR
        email LIKE '%$search%' OR
        telepon LIKE '%$search%'
    )";
}

if ($status != '') {
    $query .= " AND status='$status'";
}
if ($jk != '') {
    $query .= " AND jenis_kelamin='$jk'";
}

$query .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Total data
$total_query = mysqli_query($conn,
"SELECT COUNT(*) as total FROM anggota WHERE 1=1");

if ($search != '') {
    $total_query = mysqli_query($conn,
    "SELECT COUNT(*) as total FROM anggota
     WHERE nama LIKE '%$search%'
     OR email LIKE '%$search%'
     OR telepon LIKE '%$search%'");
}

$total_rows = mysqli_fetch_assoc($total_query)['total'];
$total_pages = ceil($total_rows / $limit);
?>

<?php
$total_anggota = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT COUNT(*) as total FROM anggota")
)['total'];

$total_aktif = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT COUNT(*) as total FROM anggota
     WHERE status='Aktif'")
)['total'];

$total_nonaktif = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT COUNT(*) as total FROM anggota
     WHERE status='Nonaktif'")
)['total'];
?>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Total Anggota</h5>
                    <h2><?php echo $total_anggota; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Anggota Aktif</h5>
                    <h2><?php echo $total_aktif; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5>Anggota Nonaktif</h5>
                    <h2><?php echo $total_nonaktif; ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <h2><i class="bi bi-people"></i>Data Anggota</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="create.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>Tambah Anggota
            </a>
            <a href="export_excel.php" class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Cari nama/email/telepon"
                               value="<?php echo $search; ?>">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">-- Status --</option>
                            <option value="Aktif"
                            <?php echo ($status == 'Aktif') ? 'selected' : ''; ?>> Aktif
                            </option>

                            <option value="Nonaktif"
                            <?php echo ($status == 'Nonaktif') ? 'selected' : ''; ?>> Nonaktif
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="jk" class="form-select">
                            <option value="">-- JK --</option>
                            <option value="Laki-laki"
                            <?php echo ($jk == 'Laki-laki') ? 'selected' : ''; ?>> Laki-laki
                            </option>
                            <option value="Perempuan"
                            <?php echo ($jk == 'Perempuan') ? 'selected' : ''; ?>> Perempuan
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Cari
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="index.php"
                           class="btn btn-secondary w-100"> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header bg-primary text-white"> Data Anggota
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>JK</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $offset + 1;
                        while ($row = mysqli_fetch_assoc($result)) :
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php if ($row['foto'] != '') : ?>
                                <img src="uploads/<?php echo $row['foto']; ?>"width="60">
                                <?php else : ?> Tidak ada foto
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo $row['kode_anggota']; ?>
                            </td>
                            <td>
                                <?php echo $row['nama']; ?>
                            </td>
                            <td>
                                <?php echo $row['email']; ?>
                            </td>
                            <td>
                                <?php echo $row['telepon']; ?>
                            </td>
                            <td>
                                <?php if ($row['jenis_kelamin'] == 'Laki-laki') : ?>
                                    <span class="badge bg-primary">Laki-laki</span>
                                <?php else : ?>
                                    <span class="badge bg-info">Perempuan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == 'Aktif') : ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else : ?>
                                    <span class="badge bg-danger">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id_anggota']; ?>"
                                   class="btn btn-warning btn-sm"> Edit
                                </a>
                                <a href="delete.php?id=<?php echo $row['id_anggota']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin hapus?')"> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php for($i=1; $i<=$total_pages; $i++) : ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link"
                        href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>&status=<?php echo $status; ?>&jk=<?php echo $jk; ?>"><?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php
if (isset($stmt)) $stmt->close();
if (isset($stmt_count)) $stmt_count->close();
closeConnection();
?>