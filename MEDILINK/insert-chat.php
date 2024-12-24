<?php
session_start();
include "koneksi.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug
error_log("POST data: " . print_r($_POST, true));
error_log("Session data: " . print_r($_SESSION, true));

if(isset($_SESSION['id_pengguna']) && isset($_POST['incoming_id']) && isset($_POST['message'])){
    $outgoing_id = $_SESSION['id_pengguna'];
    $incoming_id = mysqli_real_escape_string($koneksi, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($koneksi, $_POST['message']);
    
    error_log("Attempting to insert message: $message from $outgoing_id to $incoming_id");
    
    if(!empty($message)){
        $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) 
                VALUES (?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        
        if($stmt){
            $stmt->bind_param("iis", $incoming_id, $outgoing_id, $message);
            $result = $stmt->execute();
            
            if($result){
                echo "Message sent successfully";
            } else {
                echo "Error executing statement: " . $stmt->error;
            }
        } else {
            echo "Error preparing statement: " . $koneksi->error;
        }
    }
} else {
    echo "Missing required data";
    error_log("Missing data - SESSION: " . isset($_SESSION['id_pengguna']) . 
              ", incoming_id: " . isset($_POST['incoming_id']) . 
              ", message: " . isset($_POST['message']));
}
?>