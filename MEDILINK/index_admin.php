<?php
include 'koneksi.php'; // Pastikan file koneksi sudah di-include

// Query untuk menghitung jumlah artikel
$queryArtikel = "SELECT COUNT(*) AS total FROM artikel";
$resultArtikel = mysqli_query($koneksi, $queryArtikel);
$rowArtikel = mysqli_fetch_assoc($resultArtikel);
$totalArtikel = $rowArtikel['total'];

// Query untuk menghitung jumlah obat
$queryObat = "SELECT COUNT(*) AS total FROM obat";
$resultObat = mysqli_query($koneksi, $queryObat);
$rowObat = mysqli_fetch_assoc($resultObat);
$totalObat = $rowObat['total'];

// Query untuk menghitung jumlah nomor darurat
$queryNomorDarurat = "SELECT COUNT(*) AS total FROM nomor_darurat";
$resultNomorDarurat = mysqli_query($koneksi, $queryNomorDarurat);
$rowNomorDarurat = mysqli_fetch_assoc($resultNomorDarurat);
$totalNomorDarurat = $rowNomorDarurat['total'];
?>

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

        /* CSS untuk kartu jumlah data */
        .dashboard {
            display: flex;
            flex-direction: row;
            justify-content: center;
            margin-top: 20px;
            gap: 20px;
        }

        .card {
            color: white;
            border: none;
            border-radius: 10px;
            width: 18rem;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card.green {
            background-color: #28a745;
        }

        .card.blue {
            background-color: #007bff;
        }

        .card.red {
            background-color: #dc3545;
        }

        .card .card-content h2 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .card .card-content p {
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .card .card-link {
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s;
        }

        .card .card-link:hover {
            color: rgba(255, 255, 255, 0.8);
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
            <a href="index_admin.php" class="list-group-item list-group-item-action bg-dark text-white active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="obat_index.php" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-pills"></i> Data Obat
            </a>
            <a href="artikel_index.php" class="list-group-item list-group-item-action bg-dark text-white">
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
        <div class="dashboard">
            <!-- Kartu Jumlah Artikel -->
            <div class="card green">
                <div class="card-content">
                    <h2><?php echo $totalArtikel; ?></h2>
                    <p>Jumlah Artikel</p>
                </div>
                <a href="artikel_index.php" class="card-link">More info <span>&rarr;</span></a>
            </div>

            <!-- Kartu Jumlah Obat -->
            <div class="card blue">
                <div class="card-content">
                    <h2><?php echo $totalObat; ?></h2>
                    <p>Jumlah Obat</p>
                </div>
                <a href="obat_index.php" class="card-link">More info <span>&rarr;</span></a>
            </div>

            <!-- Kartu Jumlah Nomor Darurat -->
            <div class="card red">
                <div class="card-content">
                    <h2><?php echo $totalNomorDarurat; ?></h2>
                    <p>Jumlah Nomor Darurat</p>
                </div>
                <a href="nomor_darurat_index.php" class="card-link">More info <span>&rarr;</span></a>
            </div>
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
    fetch('get_table_data.php')
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
