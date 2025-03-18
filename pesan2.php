<?php
    // Daftar gedung beserta harga sewanya per hari
    $building = [
    ["VIP", 50000000, "VIP.jpg"], // Array menyimpan nama, harga, dan gambar gedung
    ["Ballroom", 40000000, "ballroom.jpeg"],
    ["Outdoor", 30000000, "outdoor.jpeg"]
];


     // Inisialisasi variabel default
     $pilih_gedung = $building[0][0];
     $pilih_harga = $building[0][1];
     $catering = false;
     $durasi = '';
     $total_bayar = 0;
     $errors = [];
 

    // Mengecek apakah form telah dikirim (dengan metode POST)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validasi input
        // Mengambil mobil yang dipilih dari form, jika tidak ada input, default ke gedung pertama dalam daftar
        $pilih_gedung = $_POST['building'] ?? $building[0][0];  

        // Mendapatkan harga gedung yang dipilih dari array berdasarkan nama mobil
        $pilih_harga = array_column($building, 1, 0)[$pilih_gedung];  

        // Mengecek apakah checkbox catering dipilih (true jika dipilih, false jika tidak)
        $catering = isset($_POST['catering']);  

        // Mengambil input durasi sewa, jika kosong default ke string kosong
        $durasi = $_POST['durasi'] ?? '';  

        // Mengambil nomor identitas dari form, jika kosong default ke string kosong
        $identitas = $_POST['identitas'] ?? '';  

        // Validasi: Durasi harus berupa angka
        if (!is_numeric($durasi)) {  
            $errors[] = "Durasi harus berupa angka lebih dari 0";  
        }

        // Validasi: Nomor identitas harus berupa angka
        if (!is_numeric($_POST['identitas'])) {  
            $errors[] = "Identitas harus berupa angka";  
        }

        
        // Validasi: Nomor identitas harus 16 digit angka
        // strlen untuk menghitung jumlah karakter yang diinputkan pada input dengan name identitas
        if (strlen($_POST['identitas']) !== 16) {
            $errors[] = "Nomor Identitas harus 16 digit angka.";
        }

        // Jika tidak ada error validasi, hitung total pembayaran
        if (empty($errors)) {
            // Menghitung biaya sewa gedung total berdasarkan durasi
            $total_harga_gedung = $pilih_harga * $durasi;

            // Memberikan diskon 10% jika durasi sewa 3 hari atau lebih
            $diskon = ($durasi >= 3) ? 0.1 * $total_harga_gedung : 0;

            // Menghitung biaya tambahan untuk catering jika dipilih (Rp 100.000 per hari)
            $biaya_catering = $catering ? 100000 * $durasi : 0;

            // Menghitung total pembayaran setelah dikurangi diskon dan ditambah biaya catering
            $total_bayar = $total_harga_gedung - $diskon + $biaya_catering;
        }

        if (isset($_POST['simpan'])) { // Mengecek apakah tombol "Simpan" telah ditekan
            $nama = $_POST['nama']; // Mengambil input nama dari form
            $identitas = $_POST['identitas']; // Mengambil input nomor identitas dari form
            $gender = $_POST['gender']; // Mengambil input jenis kelamin dari form
            $building = $_POST['building']; // Mengambil input jenis gedung yang dipilih dari form
            $check = $catering ? 'Ya' : 'Tidak'; // Mengecek apakah pengguna memilih opsi catering
        
            // Membuat array untuk menyimpan detail pesanan
            $pesanan = [
                "Nama" => $nama,
                "Nomor Identitas" => $identitas,
                "Jenis Kelamin" => $gender,
                "Jenis Gedung" => $building,
                "Catering" => $check,
                "Durasi" => $durasi,
                "Diskon" => $diskon,
                "Total Bayar" => number_format($total_bayar, 0, ',', '.') // Format angka untuk tampilan lebih rapi
            ];
        
        
            // Membuat string detail pesanan untuk ditampilkan dalam alert
            $detail_pesanan = "Pesanan Berhasil!\n\n";
            foreach ($pesanan as $key => $value) { // Looping untuk menyusun detail pesanan
                $detail_pesanan .= "$key: $value\n"; // Menambahkan setiap item pesanan ke dalam string
            }
        
            // Menampilkan alert dengan detail pesanan dan mengarahkan kembali ke halaman utama
            echo "<script>
                alert(`$detail_pesanan`);
                window.location.href = 'index.php';
            </script>";
            exit(); // Menghentikan eksekusi kode setelah redirect
        }
        
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e3f2fd; /* Soft blue */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-dark text-white text-center">
                <h5>Form Pemesanan</h5>
            </div>
            <div class="card-body">
                <?php if ($errors) { ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error) { echo "<li>$error</li>"; } ?>
                        </ul>
                    </div>
                <?php } ?>

                <form method="POST">
                    <input type="text" class="form-control mb-3" name="nama" placeholder="Nama Pemesan" value="<?= $_POST['nama'] ?? '' ?>" required>
                    
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label><br>
                        <input class="form-check-input" type="radio" name="gender" value="Laki-laki" <?= ($_POST['gender'] ?? '') === 'Laki-laki' ? 'checked' : '' ?>> Laki-laki
                        <input class="form-check-input ms-3" type="radio" name="gender" value="Perempuan" <?= ($_POST['gender'] ?? '') === 'Perempuan' ? 'checked' : '' ?>> Perempuan
                    </div>
                    
                    <input type="text" class="form-control mb-3" name="identitas" placeholder="Nomor Identitas (16 digit)" value="<?= $_POST['identitas'] ?? '' ?>" required>
                    
                    <select class="form-select mb-3" name="building" onchange="this.form.submit()">
                        <?php foreach  ($building as $indexarray => $nilai) { ?>
                            <option value="<?= $nilai[0] ?>" <?= ($nilai[0] === $pilih_gedung) ? 'selected' : '' ?>>
                                <?= $nilai[0] ?>
                            </option>
                        <?php }?>
                    </select>
                   
                   
                    <input type="text" class="form-control mb-3" name="harga" value="<?= number_format($pilih_harga, 0, ',', '.') ?>" readonly>
                    
                    <input type="date" class="form-control mb-3" name="tanggal" value="<?= $_POST['tanggal'] ?? '' ?>" required>
                    
                    <input type="number" class="form-control mb-3" name="durasi" placeholder="Durasi Sewa (hari)" value="<?= $durasi ?>" required>
                    
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" name="catering" <?= $catering ? 'checked' : '' ?>> Termasuk Catering (Rp 100.000/hari)
                    </div>

                    <input type="text" class="form-control mb-3" value="<?= $total_bayar ? number_format($total_bayar, 0, ',', '.') : '' ?>" placeholder="Total Bayar" readonly>
                    
                    <button type="submit" class="btn btn-primary">Hitung Total</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>