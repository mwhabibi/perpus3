<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'db_perpus');

if (!$db) {
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
}
