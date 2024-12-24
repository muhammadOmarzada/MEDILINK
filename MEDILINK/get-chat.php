<?php 
session_start(); // Tambahkan ini
include "koneksi.php";

function image_check($image, $folder = '', $default = 'default.png') {
    $path = "uploads/$image";
    return file_exists($path) ? $path : "uploads/$default";
}

    if(isset($_SESSION['id_pengguna'])){
        $outgoing_id = $_SESSION['id_pengguna'];
        $incoming_id = mysqli_real_escape_string($koneksi, $_POST['incoming_id']);
        $output = "";
        $sql = "SELECT messages.*, pengguna.img_path FROM messages 
        LEFT JOIN pengguna ON pengguna.id_pengguna = messages.outgoing_msg_id
        WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
        OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) 
        ORDER BY msg_id";   
        $query = mysqli_query($koneksi, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] == $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg']  .'</p>
                                </div>
                                </div>';
                }else{
                    $output .= '<div class="chat incoming">
                                <div class="details">
                                    <p>'. $row['msg'].'</p>
                                </div>
                                </div>';
                }
            }
        }else{
            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
        }
        echo $output;
    }else{
        header("location: loginP.php ");
    }
?>