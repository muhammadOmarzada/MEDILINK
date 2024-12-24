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

<?php
include "koneksi.php";

// Proses delete harus di atas sebelum ada output HTML
if (isset($_GET['id_nomordarurat'])) {
    $id_obat = htmlspecialchars($_GET["id_nomordarurat"]);

    // Ambil informasi gambar sebelum menghapus
    $query = "SELECT img_path FROM nomor_darurat WHERE id_nomordarurat = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_obat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    // Hapus file gambar jika ada
    if ($data && !empty($data['img_path'])) {
        $file_path = "uploads/" . $data['img_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Hapus data dari database
    $sql = "DELETE FROM nomor_darurat WHERE id_nomordarurat = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_obat);
    $hasil = mysqli_stmt_execute($stmt);

    if ($hasil) {
        header("Location: nomor_darurat_index.php");
        exit();
    } else {
        $error_message = "Data Gagal dihapus.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Medilink</title>
    <!-- ... style CSS tetap sama ... -->
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
            <a href="artikel_index.php" class="list-group-item list-group-item-action bg-dark text-white ">
                <i class="fas fa-newspaper"></i> Artikel
            </a>
            <a href="nomor_darurat_index.php" class="list-group-item list-group-item-action bg-dark text-white active">
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
            <h4 class="mt-4">Data Obat</h4>
            <?php
            if (isset($error_message)) {
                echo "<div class='alert alert-danger'>" . $error_message . "</div>";
            }
            ?>

            <div id="tableContainer">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID Nomor Darurat</th>
                            <th>Nama RS</th>
                            <th>Nomor RS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php include 'nomor_darurat_getData.php'; ?>
                    </tbody>
                </table>
            </div>
            <a href="nomor_darurat_create.php" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>
</div>
            
</body>
</html>

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
        refreshInterval = setInterval(refreshTable, 15000);
    } else {
        button.textContent = 'Auto Refresh: Off';
        button.classList.replace('btn-success', 'btn-secondary');
        clearInterval(refreshInterval);
    }
    localStorage.setItem('autoRefreshState', isAutoRefreshOn);
}

function refreshTable() {
    fetch('nomor_darurat_getData.php')
        .then(response => response.text())
        .then(html => {
            document.getElementById('tableBody').innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
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