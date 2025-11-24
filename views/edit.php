<h2>Edit Data</h2>
<form action="index.php?action=edit&id=<?php echo $user['id']; ?>" method="POST">
    <div class="form-group">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo $user['nama']; ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
    </div>
    <div class="form-group">
        <label for="telepon">Telepon:</label>
        <input type="text" id="telepon" name="telepon" value="<?php echo $user['telepon']; ?>" required>
    </div>
    <div class="form-group">
        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" required><?php echo $user['alamat']; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-cancel">Batal</a>
</form>