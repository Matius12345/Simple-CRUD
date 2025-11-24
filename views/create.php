<h2>Tambah Data Baru</h2>
<form action="index.php?action=create" method="POST">
    <div class="form-group">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="telepon">Telepon:</label>
        <input type="text" id="telepon" name="telepon" required>
    </div>
    <div class="form-group">
        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="index.php" class="btn btn-cancel">Batal</a>
</form>