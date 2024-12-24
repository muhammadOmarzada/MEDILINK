<?php
include "koneksi.php";

$sql = "SELECT * FROM obat ORDER BY id_obat DESC";
$hasil = mysqli_query($koneksi, $sql);

if (!$hasil) {
    die("Query gagal: " . mysqli_error($koneksi));
}

while ($data = mysqli_fetch_array($hasil)) {
?>
    <tr>
        <td><?php echo $data["id_obat"]; ?></td>
        <td><?php echo htmlspecialchars($data["nama_obat"]); ?></td>
        <td><?php echo htmlspecialchars($data["jenis_obat"]); ?></td>
        <td><?php echo htmlspecialchars($data["stok"]); ?></td>
        <td><?php echo htmlspecialchars($data["harga"]); ?></td>
        <td><?php echo htmlspecialchars($data["deskripsi"]); ?></td>
        <td><?php echo htmlspecialchars($data["tanggal_ditambahkan"]); ?></td>
        <td>
            <a href="obat_update.php?id_obat=<?php echo htmlspecialchars($data['id_obat']); ?>" class="btn btn-warning btn-sm">Update</a>
            <a href="obat_index.php?id_obat=<?php echo htmlspecialchars($data['id_obat']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
        </td>
    </tr>
<?php
}
?>