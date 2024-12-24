    <?php
    include "koneksi.php";

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
        $password = trim($_POST['password']);

        // Query untuk mengambil data pengguna berdasarkan username
        $query = "SELECT * FROM pengguna WHERE username = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        // Debugging: Periksa hasil query
        echo "<pre>";
        echo "Username input: " . htmlspecialchars($username) . "<br>";
        if ($user) {
            echo "User ditemukan: " . print_r($user, true) . "<br>";
        } else {
            echo "User tidak ditemukan.<br>";
        }
        echo "</pre>";

        if ($user) {
            // Debugging: Bandingkan password
            echo "<pre>";
            echo "Password di database (hashed): " . htmlspecialchars($user['password']) . "<br>";
            echo "Password input user: " . htmlspecialchars($password) . "<br>";
            echo "</pre>";

            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Debugging: Password cocok
                echo "Password cocok.<br>";
                
                // Mulai sesi dan set data sesi
                session_start();
                session_regenerate_id(true);
                $_SESSION['id_pengguna'] = $user['id_pengguna']; 
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];

                // Redirect ke halaman dashboard
                header("Location: indexPengguna.php");
                exit();
            } else {
                // Debugging: Password salah
                echo "Password tidak cocok.<br>";
            }
        } else {
            echo "Username tidak ditemukan.<br>";
        }
    } else {
        echo "Data tidak lengkap.<br>";
    }
    ?>
