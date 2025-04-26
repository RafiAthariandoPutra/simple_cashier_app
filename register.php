<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	
session_start();
if(isset($_POST['proses'])){
    require 'config.php';
        
    $user = strip_tags($_POST['user']);
    $pass = strip_tags($_POST['pass']);
    $nm_member = strip_tags($_POST['nm_member']);
    $alamat_member = strip_tags($_POST['alamat_member']);
    $telepon = strip_tags($_POST['telepon']);
    $email = strip_tags($_POST['email']);
    $NIK = strip_tags($_POST['NIK']);

    try {
        // Check if username already exists
        $sql_check = 'SELECT user FROM login WHERE user = ?';
        $row_check = $config->prepare($sql_check);
        $row_check->execute(array($user));
        $jum = $row_check->rowCount();

        if($jum > 0){
            echo '<script>alert("Username sudah digunakan, silahkan gunakan username lain");history.go(-1);</script>';
        } else {
            // Start transaction
            $config->beginTransaction();
            
            // First, insert into member table
            $sql_member = 'INSERT INTO member (nm_member, alamat_member, telepon, email, NIK) VALUES (?, ?, ?, ?, ?)';
            $row_member = $config->prepare($sql_member);
            $row_member->execute(array($nm_member, $alamat_member, $telepon, $email, $NIK));
            
            // Get the last inserted member ID
            $id_member = $config->lastInsertId();
            
            // Now insert into login table with the new id_member
            $sql_login = 'INSERT INTO login (user, pass, id_member) VALUES (?, md5(?), ?)';
            $row_login = $config->prepare($sql_login);
            $row_login->execute(array($user, $pass, $id_member));
            
            // Commit the transaction
            $config->commit();
            
            echo '<script>alert("Registrasi Berhasil, Silahkan Login");window.location="login.php"</script>';
        }
    } catch (PDOException $e) {
        // Rollback the transaction on error
        if ($config->inTransaction()) {
            $config->rollBack();
        }
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register -Toko Serba Ada Buku</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="sb-admin/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container" style="width: 100%; max-width: 800px;">

        <!-- Outer Row -->
        <div class="row justify-content-center" >
            <div class="col-md-7 mt-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
						<div class="p-5">
							<div class="text-center">
								<h4 class="h4 text-gray-900 mb-4"><b>Register Kasir</b></h4>
							</div>
							<form class="form-register" method="POST">
                                <div class="form-group">
									<input type="text" class="form-control form-control-user" name="nm_member"
										placeholder="Nama Lengkap" required>
								</div>
                                <div class="form-group">
									<input class="form-control form-control-user" name="alamat_member"
										placeholder="Alamat" ></input>
								</div>
                                <div class="form-group">
									<input type="text" class="form-control form-control-user" name="telepon"
										placeholder="Nomor Telepon" required>
								</div>
                                <div class="form-group">
									<input type="email" class="form-control form-control-user" name="email"
										placeholder="Email" required>
								</div>
                                <div class="form-group">
									<input type="text" class="form-control form-control-user" name="NIK"
										placeholder="NIK" required>
								</div>

								<div class="form-group">
									<input type="text" class="form-control form-control-user" name="user"
										placeholder="Username" autofocus required>
								</div>
								<div class="form-group">
									<input type="password" class="form-control form-control-user" name="pass"
										placeholder="Password" required>
								</div>
								<div class="form-group">
									<input type="password" class="form-control form-control-user" name="confirm_pass"
										placeholder="Confirm Password" required oninput="validatePassword()">
								</div>
								<button class="btn btn-primary btn-block" name="proses" type="submit"><i
										class="fa fa-user-plus"></i>
									REGISTER</button>
							</form>
							<div class="text-center">
								<a class="small" href="login.php">Already have an account? Login!</a>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="sb-admin/vendor/jquery/jquery.min.js"></script>
    <script src="sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="sb-admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="sb-admin/js/sb-admin-2.min.js"></script>
    
    <script>
    function validatePassword() {
        var password = document.getElementsByName("pass")[0].value;
        var confirmPassword = document.getElementsByName("confirm_pass")[0].value;
        
        if (password != confirmPassword) {
            document.getElementsByName("confirm_pass")[0].setCustomValidity("Passwords Don't Match");
        } else {
            document.getElementsByName("confirm_pass")[0].setCustomValidity('');
        }
    }
    </script>
</body>
</html>