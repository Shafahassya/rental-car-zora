<?php

$rentals = [
    ["Fortuner", 1000000, "fortuner.jpeg"],
    ["Creta", 900000, "creta.jpeg"],
    ["CRV", 700000, "crv.jpeg"]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Rental Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <style>
        /* Menyesuaikan tampilan kartu produk */
        .product-card {
            text-align: center;
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        /* Menyesuaikan tampilan gambar di carousel */
        .carousel-item img {
            height: 450px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Rental Kami</a> <!-- Logo navbar -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span> <!-- Tombol menu pada mode mobile -->
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li> <!-- Link ke produk -->
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang Kami</a></li> <!-- Link ke tentang kami -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner Mobil (Carousel) -->
    <div id="bannerKamar" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php foreach ($rentals as $indexarray => $nilai) { ?>
                <!-- Tombol indikator untuk carousel -->
                <button type="button" data-bs-target="#bannerMobil" data-bs-slide-to="<?= $indexarray ?>" class="<?= $indexarray === 0 ? 'active' : '' ?>" aria-label="Slide <?= $indexarray + 1 ?>"></button>
            <?php } ?>
        </div>
        <div class="carousel-inner">
            <?php foreach ($rentals as $indexarray => $nilai) { ?>
                <div class="carousel-item <?= $indexarray === 0 ? 'active' : '' ?>">
                    <img src="img/<?= $nilai[2] ?>" class="d-block w-100" alt="<?= $nilai[0] ?>"> <!-- Menampilkan gambar mobil -->
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                        <h3><?= $nilai[0] ?></h3>
                        <p>Harga mulai dari Rp <?= $nilai[1] ?> per malam.</p> <!-- Menampilkan harga rental -->
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- Tombol navigasi carousel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerKamar" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerKamar" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container mt-5">
        <section id="produk">
            <h2 class="text-center">Jenis Kamar</h2> <!-- Judul bagian produk -->
            <div class="row">
                <?php foreach ($rentals as $indexarray => $nilai) { ?>
                <div class="col-md-4">
                    <div class="product-card">
                        <img src="img/<?= $nilai[2] ?>" alt="<?= $nilai[0] ?>"> <!-- Gambar mobil -->
                        <h5 class="mt-2"><?= $nilai[0] ?></h5> <!-- Nama mobil -->
                        <h5 class="mt-2">Rp <?= number_format($nilai[1], 0, ',', '.') ?></h5> <!-- Harga mobil -->
                        <a href="pesan.php?indexarray=<?= $indexarray ?>" class="btn btn-primary mt-2">Pesan</a> <!-- Tombol pesan -->
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>
    </div>

    <!-- Tentang Kami -->
    <div class="container mt-5">
        <section id="tentang">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h2 class="card-title">Tentang Kami</h2>
                    <p class="card-text">Selamat datang di <strong>Rental Kami</strong>, penyedia layanan rental terpercaya yang siap memenuhi kebutuhan transportasi Anda.</p>
                    <p class="card-text">Kami berlokasi di <strong>Jalan Flamboyan III</strong>, dengan berbagai pilihan kendaraan yang nyaman, terawat, dan siap digunakan untuk perjalanan bisnis, wisata, atau keperluan pribadi.</p>
                    <p class="card-text">Kami selalu mengutamakan kepuasan pelanggan dengan menyediakan layanan profesional, harga kompetitif, serta kemudahan dalam proses penyewaan.</p>
                    <hr>
                    <h5>Hubungi Kami</h5>
                    <p><strong>📍 Alamat:</strong> Jalan Flamboyan III</p>
                    <p><strong>📞 Telepon:</strong> <a href="tel:[+62895383875089]">+62895383875089</a></p>
                    <p><strong>📧 Email:</strong> <a href="mailto:[rentalkami@gmail.com]">rentalkami@gmail.com</a></p>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Rental.</p>
    </footer>

    <!-- Memuat Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
