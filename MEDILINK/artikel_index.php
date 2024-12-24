<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Medilink</title>
    <style>
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            transition: margin .25s ease-out;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
        }

        #page-content-wrapper {
            min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        .list-group-item {
            border: none;
            padding: 1rem 1.25rem;
        }

        .list-group-item.active {
            background-color: #007bff;
            border-color: #007bff;
        }

        .list-group-item i {
            margin-right: 0.5rem;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 0 1rem 1rem;
        }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar-wrapper">
        <div class="sidebar-heading">Medilink</div>
        <div class="sidebar-divider"></div>
        <div class="list-group list-group-flush">
            <a href="index_admin.php" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="obat_index.php" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-pills"></i> Data Obat
            </a>
            <a href="artikel_index.php" class="list-group-item list-group-item-action bg-dark text-white active">
                <i class="fas fa-newspaper"></i> Artikel
            </a>
            <a href="nomor_darurat_index.php" class="list-group-item list-group-item-action bg-dark text-white">
            <i class="fas fa-phone-volume"></i> Nomor Darurat
            </a>
            <div class="sidebar-divider"></div>
            <a href="logout.php" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="btn btn-outline-light" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <button onclick="toggleAutoRefresh()" id="refreshButton" class="btn btn-secondary btn-sm mr-2">
                            Auto Refresh: Off
                        </button>
                    </li>
                    <li class="nav-item">
                        <button onclick="refreshTable()" class="btn btn-primary btn-sm">
                            Refresh Sekarang
                        </button>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid">
            <h4 class="mt-4">Data Artikel</h4>
            <?php
            include "koneksi.php";

            if (isset($_GET['id_artikel'])) {
                $id_artikel = htmlspecialchars($_GET["id_artikel"]);

                $sql = "DELETE FROM artikel WHERE id_artikel='$id_artikel'";
                $hasil = mysqli_query($koneksi, $sql);

                if ($hasil) {
                    header("Location: artikel_index.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
                }
            }
            ?>

            <div id="tableContainer">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id Artikel</th>
                            <th>Judul Artikel</th>
                            <th>Penulis Artikel</th>
                            <th>Isi</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php
                        $sql = "SELECT * FROM artikel ORDER BY id_artikel DESC";
                        $hasil = mysqli_query($koneksi, $sql);

                        if (!$hasil) {
                            die("Query gagal: " . mysqli_error($koneksi));
                        }

                        while ($data = mysqli_fetch_array($hasil)) {
                        ?>
                            <tr>
                                <td><?php echo $data["id_artikel"]; ?></td>
                                <td><?php echo htmlspecialchars($data["judulartikel"]); ?></td>
                                <td><?php echo htmlspecialchars($data["penulisartikel"]); ?></td>
                                <td><?php echo htmlspecialchars($data["isiartikel"]); ?></td>
                                <td><?php echo htmlspecialchars($data["tanggal"]); ?></td>
                                <td><?php echo htmlspecialchars($data["kategori"]); ?></td>
                                <td>
                                    <a href="artikel_update.php?id_artikel=<?php echo htmlspecialchars($data['id_artikel']); ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $data['id_artikel']; ?>)" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <a href="artikel_create.php" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
let refreshInterval;
let isAutoRefreshOn = false;

$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

function toggleAutoRefresh() {
    isAutoRefreshOn = !isAutoRefreshOn;
    const button = document.getElementById('refreshButton');
    
    if (isAutoRefreshOn) {
        button.textContent = 'Auto Refresh: On';
        button.classList.replace('btn-secondary', 'btn-success');
        refreshInterval = setInterval(refreshTable, 30000);
    } else {
        button.textContent = 'Auto Refresh: Off';
        button.classList.replace('btn-success', 'btn-secondary');
        clearInterval(refreshInterval);
    }
    localStorage.setItem('autoRefreshState', isAutoRefreshOn);
}

function refreshTable() {
    location.reload();
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        window.location.href = 'artikel_index.php?id_artikel=' + id;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const savedState = localStorage.getItem('autoRefreshState');
    if (savedState === 'true') {
        toggleAutoRefresh();
    }
});
</script>

</body>
</html>