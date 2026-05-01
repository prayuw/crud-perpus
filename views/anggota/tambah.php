<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Tambah Anggota</title>
</head>
<body>

<h2>➕ Tambah Anggota</h2>

<form method="POST" action="../../controllers/AnggotaController.php">

<input type="text" name="nama" placeholder="Nama" required>
<input type="text" name="alamat" placeholder="Alamat" required>
<input type="text" name="no_hp" placeholder="No HP" required>

<button name="tambah">Simpan</button>
<a href="list.php" class="back">Kembali</a>

</form>

</body>
</html>