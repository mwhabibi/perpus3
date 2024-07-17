<?php
include("koneksi.php");

if(isset($_POST['id'])){
    $id = $_POST['id'];

    // Query untuk menghapus data buku berdasarkan ID
    $sql = "DELETE FROM buku WHERE id = '$id'";
    if(mysqli_query($db, $sql)){
        $_SESSION['notif'] = "ShowNotif('Buku berhasil dihapus.');";
    } else {
        $_SESSION['notif'] = "ShowNotif('Gagal menghapus buku.');";
    }
    header("Location: index.php");
}
?>
