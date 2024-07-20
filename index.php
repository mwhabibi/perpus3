<?php
include("koneksi.php");
?>
<html>

<head>
    <title>BackEnd-Data Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <div class="col-md-12 mt-3">
            <p>
                Buku paling sering di Pinjam:
                <?php
                $sql = "
                        SELECT b.id, b.judul, b.kategori, b.qty, COUNT(p.idBuku) AS jumlah_peminjaman
                        FROM buku b
                        JOIN pinjam p ON b.id = p.idBuku
                        GROUP BY b.id, b.judul, b.kategori, b.qty
                        ORDER BY jumlah_peminjaman DESC
                        LIMIT 1;
                        ";
                $query = mysqli_query($db, $sql);

                while ($favBook = mysqli_fetch_array($query)) {
                    echo "
                            <b>
                                " . $favBook['judul'] . "
                            </b>
                            ";
                }
                ?>
            </p>
            <p>
                Pengunjung paling aktif adalah :
                <?php
                $sql = "
                    SELECT 
    p.idPengunjung, 
    p.nama, 
    COUNT(pm.idPinjam) AS jumlah_pinjam
FROM 
    pinjam pm
JOIN 
    pengunjung p ON pm.idPengunjung = p.idPengunjung
GROUP BY 
    p.idPengunjung, p.nama
ORDER BY 
    jumlah_pinjam DESC
LIMIT 1;

                    ";
                $query = mysqli_query($db, $sql);

                while ($bestPengunjung = mysqli_fetch_array($query)) {
                    echo "
                            <b>
                                " . $bestPengunjung['nama'] . "
                            </b>
                            ";
                }
                ?>
            </p>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <h1 class="fw-bold">DATA BUKU</h1>
                <div class="col-md-12 text-right mt-3 mb-3">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-input" onclick="ResetInput()">Tambah Buku</button>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Jumlah Buku</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM buku";
                        $query = mysqli_query($db, $sql);
                        while ($data = mysqli_fetch_array($query)) {
                            echo "<tr>
								<td>" . $data['id'] . "</td>
								<td>" . $data['judul'] . "</td>
								<td>" . $data['kategori'] . "</td>
								<td>" . $data['qty'] . "</td>
								<td>
									<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#modal-input' onclick='SetInput(" . json_encode($data) . ")' title='Ubah'><i class='fa fa-edit'></i></button> 
									<button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modal-hapus' onclick='SetHapus(" . json_encode($data) . ")' title='Hapus'><i class='fa fa-trash'></i></button>
								</td>
							</tr>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>

            <div class="col-md-12 mt-3">
                <h1 class="fw-bold">DATA PENGUNGJUNG/PEMINJAM</h1>
                <div class="col-md-12 text-right mt-3 mb-3">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalPengunjung" onclick="resetInputPengunjung()">Tambah Pengunjung</button>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pengunjung</th>
                            <th>Nama Pengunjung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM pengunjung";
                        $query = mysqli_query($db, $sql);
                        $no = 1;
                        while ($data = mysqli_fetch_array($query)) {
                            echo "<tr>
                                        <td>" . $data['idPengunjung'] . "</td>
                                        <td>" . $data['nama'] . "</td>
                                        <td>
                                            <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#modalPengunjung' onclick='setInputPengunjung(" . json_encode($data) . ")' title='Ubah'><i class='fa fa-edit'></i></button> 
                                        </td>
                                    </tr>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>

            <div class="col-md-12 mt-3">
                <h1 class="fw-bold">DATA PEMINJAMAN</h1>
                <div class="col-md-12 text-right mt-3 mb-3">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalPinjam" onclick="resetInputPinjam()">Tambah Peminjaman</button>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pinjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>ID Buku</th>
                            <th>ID Pengunjung</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM pinjam";
                        $query = mysqli_query($db, $sql);
                        while ($data = mysqli_fetch_array($query)) {
                            echo "<tr>
        <td>" . $data['idPinjam'] . "</td>
        <td>" . $data['tanggal'] . "</td>
        <td>" . $data['idBuku'] . "</td>
        <td>" . $data['idPengunjung'] . "</td>
        <td>" . ($data['diPinjam'] == 1 ? 'Pinjam' : 'Kembali') . "</td>
        <td>
        " .
                                ($data['diPinjam'] == 1 ? "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#modalPinjam' onclick='setInputPinjam(" . json_encode($data) . ")' title='Ubah'><i class='fa fa-edit'></i></button> " : '')
                                . "
        </td>
    </tr>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-input" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="simpan.php" method="post">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-md-4 form-label">Judul Buku</label>
                            <div class="col-md-8">
                                <input type="hidden" id="id" name="id">
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 form-label">Kategori</label>
                            <div class="col-md-8">
                                <select class="form-control" id="kategori" name="kategori" required>
                                    <option value="Fiksi">Fiksi</option>
                                    <option value="Non-Fiksi">Non-Fiksi</option>
                                    <option value="Biografi">Biografi</option>
                                    <option value="Sejarah">Sejarah</option>
                                    <option value="Sains">Sains</option>
                                    <option value="Teknologi">Teknologi</option>
                                    <option value="Fantasi">Fantasi</option>
                                    <option value="Misteri">Misteri</option>
                                    <option value="Romansa">Romansa</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 form-label" for="qty">Jumlah Buku</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" id="qty" name="qty" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="submitBuku" name="submitBuku">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPinjam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalPinjam"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="simpan.php" method="post">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-md-4 form-label">Buku</label>
                            <div class="col-md-8">
                                <input type="hidden" class="form-control" id="idPinjam" name="idPinjam" required>
                                <!-- <input type="text" class="form-control" id="idBuku" name="idBuku" required> -->
                                <select class="form-control" id="idBuku" name="idBuku" required>
                                    <?php
                                    $sql = "SELECT * FROM buku";
                                    $query = mysqli_query($db, $sql);
                                    while ($data = mysqli_fetch_array($query)) {
                                        echo "
                                            <option value='" . $data['id'] . "'>" . $data['judul'] . "</option>
                                            ";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 form-label">Peminjam</label>
                            <div class="col-md-8">
                                <!-- <input type="text" class="form-control" id="peminjam" name="peminjam" required> -->
                                <select class="form-control" id="idPengunjungPinjam" name="idPengunjung" required>
                                    <?php
                                    $sql = "SELECT * FROM pengunjung";
                                    $query = mysqli_query($db, $sql);
                                    while ($data = mysqli_fetch_array($query)) {
                                        echo "
                                            <option value='" . $data['idPengunjung'] . "'>" . $data['nama'] . "</option>
                                            ";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 form-label">Status</label>
                            <div class="col-md-8">
                                <!-- <input type="text" class="form-control" id="peminjam" name="peminjam" required> -->
                                <select class="form-control" name="status" required>
                                    <option value="1">Di Pinjam</option>
                                    <option value="0">Di Kembalikan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="submitPinjam" id="submitPinjam" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPengunjung" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalPengunjung"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="simpan.php" method="post">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-md-4 form-label">Nama Pengunjung</label>
                            <div class="col-md-8">
                                <input type="hidden" class="form-control" id="idPengunjung" name="idPengunjung" required>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="submitPengunjung" id="submitPengunjung" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="modal-hapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="hapus.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="idHapus" name="id">
                        <p id="pesan"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-success">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function ResetInput() {
            $('#title').html('Tambah Buku');
            $('#id').val(null);
            $('#judul').val(null);
            $('#kategori').val('Fiksi');
            $('#qty').val(null);
        }

        function resetInputPinjam() {
            $('#titleModalPinjam').html('Tambah Peminjaman');
            $('#idBuku').val(null);
            $('#idPengunjungPinjam').val(null);

        }

        function resetInputPengunjung() {
            $('#titleModalPengunjung').html('Tambah Pengunjung');
            $('#nama').val(null);
        }

        function SetInput(buku) {
            $('#title').html('Ubah Buku');
            $('#id').val(buku['id']);
            $('#judul').val(buku['judul']);
            $('#kategori').val(buku['kategori']);
            $('#qty').val(buku['qty']);

            document.getElementById("submitBuku").name = "editBuku";

        }

        function setInputPinjam(pinjam) {
            $('#titleModalPinjam').html('Ubah Pinjam');
            $('#idBuku').val(pinjam['idBuku']);
            $('#idPinjam').val(pinjam['idPinjam']);
            $('#idPengunjung').val(pinjam['idPengunjung']);

            document.getElementById("submitPinjam").name = "editPinjam";
        }

        function setInputPengunjung(pinjam) {
            $('#titleModalPengunjung').html('Ubah Pengunjung');
            $('#idPengunjung').val(pinjam['idPengunjung']);
            $('#nama').val(pinjam['nama']);

            document.getElementById("submitPengunjung").name = "editPengunjung";
        }

        function SetHapus(buku) {
            $('#pesan').html('Apakah anda yakin ingin menghapus Buku ' + buku['judul'] + '?');
            $('#idHapus').val(buku['id']);
        }

        $('button').tooltip();

        function ShowNotif(notif, status = "success") {
            Swal.fire({
                title: status == "success" ? "Berhasil" : "Gagal",
                text: notif,
                showCancelButton: false,
                showConfirmButton: false,
                timer: 5000,
                icon: status
            });
        }

        <?php
        if (isset($_SESSION['notif'])) {
            echo $_SESSION['notif'];
            unset($_SESSION['notif']);
        }
        ?>



        function SetHapus2(pinjam) {
            $('#pesan').html('Apakah anda yakin ingin menghapus Data Peminjaman dari ' + pinjam['peminjam'] + '?');
            $('#idHapus').val(pinjam['idBuku']);
        }
    </script>
</body>

</html>