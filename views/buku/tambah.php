<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Tambah Buku</title>
</head>
<body>

<h2>Tambah Buku</h2>

<form method="POST" action="../../controllers/BukuController.php" enctype="multipart/form-data">

<input type="file" name="gambar">
<input type="text" name="judul" placeholder="Judul Buku" required>
<input type="text" name="penulis" placeholder="Penulis" required>
<input type="text" name="penerbit" placeholder="Penerbit" required>
<input type="number" name="tahun" placeholder="Tahun Terbit" required>
<input type="number" name="stok" placeholder="Stok" required>

<button name="tambah">Simpan</button>
<a href="list.php" class="back">Kembali</a>

</form>

</body>
</html>