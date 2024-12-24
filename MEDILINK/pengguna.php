<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to MediLink!</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styleindex.css" />
    <style>
      body {
        padding-top: 50px; /* Memberi ruang untuk navbar fixed */
      }
    </style>
  </head>
  <body>
    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container d-flex align-items-center">
        <!-- Dropdown Logout di Kiri -->
        <div class="dropdown me-3">
          <button
            class="btn btn-secondary dropdown-toggle"
            type="button"
            id="logoutDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            Logout
          </button>
          <ul class="dropdown-menu" aria-labelledby="logoutDropdown">
            <li><a class="dropdown-item" href="logoutP.php">Logout</a></li>
            <li><a class="dropdown-item" href="profile.html">Profile</a></li>
          </ul>
        </div>

        <!-- Logo dan Nama -->
        <a class="navbar-brand" href="#">MEDILINK</a>

        <!-- Tombol Toggler untuk Menu di Kanan -->
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Navigasi -->
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="indexPengguna.php">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#menu">Layanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#proyek">Artikel</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header
      id="beranda"
      class="header-bg py-5"
      style="background-image: url(desain-rumah-sakit-uii-683x321.jpg)"
    >
      <div class="header-bg-overlay"></div>
      <div class="container">
        <h1 class="display-4 align-text-left mx-5" style="color: aliceblue">
          Medilink
        </h1>
        <p class="lead mx-5" style="color: aliceblue">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Error sed
          iusto explicabo ab soluta illum, atque accusamus quidem ducimus,
          deserunt quae quas non nostrum harum quibusdam! Expedita asperiores
          eum nesciunt!
        </p>
      </div>
    </header>

    <!-- Bagian Tentang Saya -->
    <section id="tentang" class="py-5">
      <div class="container" style="background-color: #f8f4ff">
        <div class="row">
          <div class="col-md-6">
            <img
              src="mike-meyers-FXYpXiVyM48-unsplash.jpg"
              alt="Foto Saya"
              class="img-fluid rounded-circle mb-1 mx-5"
              style="max-width: 55vh"
            />
          </div>
          <div class="col-md-6" style="padding-top: 150px;">
            <p>
              Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit
              perspiciatis molestiae modi fuga officiis sed doloremque,
              obcaecati quaerat distinctio iusto reiciendis perferendis facere
              laborum sapiente in alias nisi numquam ipsum!
            </p>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Voluptatum perferendis ullam adipisci repudiandae, incidunt
              quidem? Perferendis fugit porro, ipsum aut corrupti repudiandae
              fugiat, consectetur numquam facilis, impedit mollitia! Deserunt,
              eius!
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Menu -->
    <section id="menu" class="py-5">
      <div class="container menu">
        <h3 class="text-center mb-4">Layanan</h3>
        <div class="row">
          <div class="col">
            <div>
              <button class="custom-button">
                <div class="button-icon">
                  <img src="th (1).jpeg" alt="Icon Name" />
                </div>
                <div class="button-text">Marketplace</div>
              </button>
            </div>
          </div>
          <div class="col">
            <div>
              <button class="custom-button">
                <div class="button-icon">
                  <img src="th (1).jpeg" alt="Icon Name" />
                </div>
                <div class="button-text">Rumah Sakit Sekitar</div>
              </button>
            </div>
          </div>
          <div class="col">
            <div>
              <button class="custom-button">
                <div class="button-icon">
                  <img src="th (1).jpeg" alt="Icon Name" />
                </div>
                <div class="button-text">Nomor Darurat</div>
              </button>
            </div>
          </div>
          <div class="col">
            <div>
              <button class="custom-button">
                <div class="button-icon">
                  <img src="th (1).jpeg" alt="Icon Name" />
                </div>
                <div class="button-text">Konsultasi Dokter</div>
              </button>
            </div>
          </div>
          <div class="col">
            <div>
              <button class="custom-button">
                <div class="button-icon">
                  <img src="th (1).jpeg" alt="Icon Name" />
                </div>
                <div class="button-text">Riwayat</div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Carousel -->
    <section id="" class="col-md-12 justify-content-center">
      <div id="carouselExampleDark" class="carousel carousel-dark slide">
        <div class="carousel-indicators">
          <button
            type="button"
            data-bs-target="#carouselExampleDark"
            data-bs-slide-to="0"
            class="active"
            aria-current="true"
            aria-label="Slide 1"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleDark"
            data-bs-slide-to="1"
            aria-label="Slide 2"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleDark"
            data-bs-slide-to="2"
            aria-label="Slide 3"
          ></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active" data-bs-interval="10000">
            <img
              src="istockphoto-1364911473-612x612.webp"
              class="d-block w-100 carousel-img"
              alt="..."
            />
            <div class="carousel-caption d-none d-md-block">
              <h5>First slide label</h5>
              <p>
                Some representative placeholder content for the first slide.
              </p>
            </div>
          </div>
          <div class="carousel-item" data-bs-interval="2000">
            <img
              src="mike-meyers-FXYpXiVyM48-unsplash.jpg"
              class="d-block mx-auto carousel-img"
              alt="..."
            />
            <div class="carousel-caption d-none d-md-block">
              <h5>Second slide label</h5>
              <p>
                Some representative placeholder content for the second slide.
              </p>
            </div>
          </div>
          <div class="carousel-item">
            <img
              src="mike-meyers-IJyXoyGmiZY-unsplash.jpg"
              class="d-block w-100 carousel-img"
              alt="..."
            />
            <div class="carousel-caption d-none d-md-block">
              <h5>Third slide label</h5>
              <p>
                Some representative placeholder content for the third slide.
              </p>
            </div>
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#carouselExampleDark"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#carouselExampleDark"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </section>

    <!-- Bagian Proyek -->
    <section id="proyek" class="py-5 bg-light">
      <div class="container">
        <h2 class="text-center mb-5">Artikel</h2>
        <div class="row">
          <div class="col-md-3 mb-3">
            <div class="card">
              <img
                src="mike-meyers-IJyXoyGmiZY-unsplash.jpg"
                class="card-img-top"
                alt="Proyek 1"
              />
              <div class="card-body">
                <h5 class="card-title">Artikel 1</h5>
                <p class="card-text">Deskripsi</p>
                <a href="#" class="btn btn-primary">Lihat Detail</a>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card">
              <img
                src="istockphoto-1364911473-612x612.webp"
                class="card-img-top"
                alt="Proyek 2"
              />
              <div class="card-body">
                <h5 class="card-title">Artikel 2</h5>
                <p class="card-text">Deskripsi</p>
                <a href="#" class="btn btn-primary">Lihat Detail</a>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card">
              <img
                src="mike-meyers-FXYpXiVyM48-unsplash.jpg"
                class="card-img-top"
                alt="Proyek 3"
              />
              <div class="card-body">
                <h5 class="card-title">Artikel 3</h5>
                <p class="card-text">Deskripsi</p>
                <a href="#" class="btn btn-primary">Lihat Detail</a>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card">
              <img
                src="mike-meyers-FXYpXiVyM48-unsplash.jpg"
                class="card-img-top"
                alt="Proyek 3"
              />
              <div class="card-body">
                <h5 class="card-title">Artikel 3</h5>
                <p class="card-text">Deskripsi</p>
                <a href="#" class="btn btn-primary">Lihat Detail</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
      <p>&copy; 2023 [Nama Anda]. Hak Cipta Dilindungi.</p>
    </footer>

    <!-- JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
