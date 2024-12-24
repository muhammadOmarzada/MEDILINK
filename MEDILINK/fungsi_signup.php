<?php
    session_start();
    include_once "koneksi.php";
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    
    if(!empty($nama_lengkap) && !empty($username) && !empty($password)){
        // Cek username sudah ada atau belum
        $sql = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '{$username}'");
        if(mysqli_num_rows($sql) > 0){
            echo "$username - Username ini sudah digunakan!";
        }else{
            // Proses upload gambar jika ada
            if(isset($_FILES['image'])){
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];
                
                $img_explode = explode('.',$img_name);
                $img_ext = end($img_explode);

                $extensions = ["jpeg", "png", "jpg"];
                if(in_array($img_ext, $extensions) === true){
                    $types = ["image/jpeg", "image/jpg", "image/png"];
                    if(in_array($img_type, $types) === true){
                        $time = time();
                        $new_img_name = $time.$img_name;
                        if(move_uploaded_file($tmp_name,"images/".$new_img_name)){
                            // Generate unique ID
                            $ran_id = rand(time(), 100000000);
                            $status = "Active now";
                            $encrypt_pass = md5($password);
                            
                            // Query insert dengan struktur tabel yang benar
                            $insert_query = mysqli_query($koneksi, "INSERT INTO users (unique_id, nama_lengkap, username, password, img, status)
                            VALUES ({$ran_id}, '{$nama_lengkap}', '{$username}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                            
                            if($insert_query){
                                $select_sql2 = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '{$username}'");
                                if(mysqli_num_rows($select_sql2) > 0){
                                    $result = mysqli_fetch_assoc($select_sql2);
                                    $_SESSION['unique_id'] = $result['unique_id'];
                                    echo "success";
                                }else{
                                    echo "Username tidak ditemukan!";
                                }
                            }else{
                                echo "Terjadi kesalahan saat mendaftar. Silakan coba lagi!";
                            }
                        }else{
                            echo "Gagal mengupload gambar!";
                        }
                    }else{
                        echo "Upload gambar dengan format - jpeg, png, jpg";
                    }
                }else{
                    echo "Upload gambar dengan format - jpeg, png, jpg";
                }
            }else{
                // Jika tidak ada upload gambar, gunakan gambar default
                $new_img_name = "default.png"; // Pastikan ada file default.png di folder images
                $ran_id = rand(time(), 100000000);
                $status = "Active now";
                $encrypt_pass = md5($password);
                
                $insert_query = mysqli_query($koneksi, "INSERT INTO users (unique_id, nama_lengkap, username, password, img, status)
                VALUES ({$ran_id}, '{$nama_lengkap}', '{$username}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                
                if($insert_query){
                    $select_sql2 = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '{$username}'");
                    if(mysqli_num_rows($select_sql2) > 0){
                        $result = mysqli_fetch_assoc($select_sql2);
                        $_SESSION['unique_id'] = $result['unique_id'];
                        echo "success";
                    }else{
                        echo "Username tidak ditemukan!";
                    }
                }else{
                    echo "Terjadi kesalahan saat mendaftar. Silakan coba lagi!";
                }
            }
        }
    }else{
        echo "Semua field harus diisi!";
    }
?>