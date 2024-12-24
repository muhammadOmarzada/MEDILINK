<?php
include "koneksi.php";

$sql = "SELECT * FROM nomor_darurat ORDER BY id_nomordarurat DESC";
$hasil = mysqli_query($koneksi, $sql);

if (!$hasil) {
    die("Query gagal: " . mysqli_error($koneksi));
}

while ($data = mysqli_fetch_array($hasil)) {
?>
    <tr>
        <td><?php echo $data["id_nomordarurat"]; ?></td>
        <td><?php echo htmlspecialchars($data["nama_rs"]); ?></td>
        <td><?php echo htmlspecialchars($data["nomor_rs"]); ?></td>
        
        <td>
            <a href="nomor_darurat_update.php?id_nomordarurat=<?php echo htmlspecialchars($data['id_nomordarurat']); ?>" class="btn btn-warning btn-sm">Update</a>
            <a href="nomor_darurat_index.php?id_nomordarurat=<?php echo htmlspecialchars($data['id_nomordarurat']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
        </td>
    </tr>
<?php
}
?>