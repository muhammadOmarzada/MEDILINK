<?php
    $outgoing_id = $_SESSION['id_pengguna'];
    $sql = "SELECT * FROM pengguna WHERE NOT id_pengguna = {$outgoing_id} ORDER BY id_pengguna DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "Tidak ada pengguna tersedia";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>