<?php
include("koneksi.php");

if (isset($_POST['submitPinjam'])) {
    $idPengunjung = $_POST['idPengunjung'];
    $query_check = "SELECT * FROM pinjam WHERE idPengunjung = '$idPengunjung' AND diPinjam = 1";
    $result_check = mysqli_query($db, $query_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Jika true tampilkan ShowNotif, "Gagal Menambahkan, karena Setiap Pengunjung yang diperbolehkan meminjam satu buku"
        $_SESSION['notif'] = "ShowNotif('Gagal Menambahkan, karena setiap pengunjung hanya diperbolehkan meminjam satu buku pada satu waktu.', 'error')";
        header('location:index.php');

        die();
    } else {
        $query_check_qty = "SELECT qty FROM buku WHERE id = '" . $_POST['idBuku'] . "'";
        $result_check_qty = mysqli_query($db, $query_check_qty);
        $row = mysqli_fetch_assoc($result_check_qty);

        if ($row['qty'] <= 0) {
            $_SESSION['notif'] = "ShowNotif('Gagal Menambahkan, karena buku yang ingin dipinjam sudah habis.', 'error')";
            header('location:index.php');
            die();
        } else {
            // Cek pada qty tabel buku, jika qty = 0, gagal meminjam, jika > 0 jalankan kode dibawah 
            $sql = "INSERT INTO pinjam (idBuku, idPengunjung) VALUE ('" . $_POST['idBuku'] . "', '" . $_POST['idPengunjung'] . "')";
            $_SESSION['notif'] = "ShowNotif('Data peminjam berhasil ditambah.')";

            $sql_update_buku = "UPDATE buku SET qty = qty - 1 WHERE id = '" . $_POST['idBuku'] . "'";
            mysqli_query($db, $sql_update_buku);
        }
    }
} elseif (isset($_POST['editPinjam'])) {
    $sql = "UPDATE pinjam SET idBuku='" . $_POST['idBuku'] . "', idPengunjung='" . $_POST['idPengunjung'] . "', diPinjam='" . $_POST['status'] . "' WHERE idPinjam='" . $_POST['idPinjam'] . "'";
    $sql_plus_buku = "UPDATE buku SET qty = qty + 1 WHERE id = '" . $_POST['idBuku'] . "'";
    mysqli_query($db, $sql_plus_buku);
    $_SESSION['notif'] = "ShowNotif('Data peminjam berhasil diubah.')";
} elseif (isset($_POST['submitBuku'])) {
    $sql = "INSERT INTO buku (judul, kategori, qty) VALUE ('" . $_POST['judul'] . "','" . $_POST['kategori'] . "', '" . $_POST['qty'] . "')";
    $_SESSION['notif'] = "ShowNotif('Data buku berhasil ditambah.')";
} elseif (isset($_POST['editBuku'])) {
    $sql = "UPDATE buku SET judul='" . $_POST['judul'] . "', kategori='" . $_POST['kategori'] . "', qty='" . $_POST['qty'] . "' WHERE id='" . $_POST['id'] . "'";
    $_SESSION['notif'] = "ShowNotif('Data buku berhasil diubah.')";
} elseif (isset($_POST['submitPengunjung'])) {
    $sql = "INSERT INTO pengunjung (nama) VALUE ('" . $_POST['nama'] . "')";
    $_SESSION['notif'] = "ShowNotif('Data pengunjung berhasil ditambah.')";
} elseif (isset($_POST['editPengunjung'])) {
    $sql = "UPDATE pengunjung SET nama='" . $_POST['nama'] . "' WHERE idPengunjung='" . $_POST['idPengunjung'] . "'";
    $_SESSION['notif'] = "ShowNotif('Data pengunjung berhasil diubah.')";
}

$query = mysqli_query($db, $sql);
header('location:index.php');
