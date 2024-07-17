<?php
include("koneksi.php");

if (isset($_POST['submitPinjam'])) {
        $sql = "INSERT INTO pinjam (idBuku, peminjam) VALUE ('" . $_POST['idBuku'] . "', '" . $_POST['peminjam'] . "')";
        $_SESSION['notif'] = "ShowNotif('Data peminjam berhasil ditambah.')";
}
elseif (isset($_POST['editPinjam'])) {
    $sql = "UPDATE pinjam SET tanggal='" . $_POST['tanggal'] . "', idBuku='" . $_POST['idBuku'] . "', peminjam='" . $_POST['peminjam'] . "' WHERE idBuku='" . $_POST['idBuku'] . "'";
    $_SESSION['notif'] = "ShowNotif('Data peminjam berhasil diubah.')";
}
elseif (isset($_POST['submitBuku'])) {
    $sql = "INSERT INTO buku (judul, kategori, qty) VALUE ('" . $_POST['judul'] . "','" . $_POST['kategori'] . "', '" . $_POST['qty'] . "')";
    $_SESSION['notif'] = "ShowNotif('Data buku berhasil ditambah.')";
} elseif (isset($_POST['editBuku'])) {
    $sql = "UPDATE buku SET judul='" . $_POST['judul'] . "', kategori='" . $_POST['kategori'] . "', qty='" . $_POST['qty'] . "' WHERE id='" . $_POST['id'] . "'";
    $_SESSION['notif'] = "ShowNotif('Data buku berhasil diubah.')";
}

$query = mysqli_query($db, $sql);
header('location:index.php');