<div class="navigation">
    <a href="index.php?action=create" class="btn btn-primary">Tambah Data Baru</a>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$no}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['telepon']}</td>";
            echo "<td>{$row['alamat']}</td>";
            echo "<td>
                    <a href='index.php?action=edit&id={$row['id']}' class='btn btn-edit'>Edit</a>
                    <a href='index.php?action=delete&id={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Apakah Anda yakin?\")'>Hapus</a>
                  </td>";
            echo "</tr>";
            $no++;
        }
        ?>
    </tbody>
</table>