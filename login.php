<?php
// Session'ın başlatılması
session_start();
 
// Eğer kullanıcı zaten login olmuşsa ilgili sayfaya geri yönlendirilir.
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if ($_SESSION["role"] ==="admin") {
        header("location: admin/index.php");
        exit; 
    }
    elseif ($_SESSION["role"] ==="editor") {
        header("location: editor/index.php");
        exit; 
    }
    elseif ($_SESSION["role"] ==="active") {
        header("location: index.php");
        exit; 
    }
    elseif ($_SESSION["role"] ==="visitor") {
        header("location: index.php");
        exit; 
    }
}
 
// config dosyasının dahil edilmesi
require_once "db/config.php";
 
//Değişkenlerin boş değerler ile başlatılması
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Form gönderildi
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Kullanıcı alanının dolu olup olmadığının kontrol edilmesi
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Şifrenin dolu olup olmadığının kontrol edilmesi
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Bilgilerin Doğrulanması
    if(empty($username_err) && empty($password_err)){
        // select sorgusu
        $sql = "SELECT id, username, password, role FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // değişkenler sorguya bağlanıyor
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // parametreler set diliyor
            $param_username = trim($_POST["username"]);
            
            // sorgunun çalıştırılması
            if($stmt->execute()){
                // Önce kullanıcının sonra şifrenin değiştirilmesi
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        $role = $row["role"];
                        
                        if(password_verify($password, $hashed_password)){
                            // Şifre doğru
                            if ($role === "passive") {
                                //Pasif roldeki kullanıcı hiç bir sayfaya giriş yapamaz
                                $role_err = "Please contact the admin to activate your account.";
                            }else{
                                // Kullanıcı bilgilerinin session olarak tuutlması
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                $_SESSION["role"] = $role;
                                if ($role ==="admin") {
                                    header("location: admin");
                                }elseif ($role ==="editor") {
                                    header("location: editor");
                                }
                                elseif ($role ==="active") {
                                    header("location: index.php");
                                }
                                elseif ($role ==="visitor") {
                                    header("location: index.php");
                                }
                            }
                            
                        } else{
                            // Şifre Hatası
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Kullanıcı Hatası
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // SQL ifadesini kapat
            unset($stmt);
        }
    }
    // Bağlantıyı sonlandır
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="img/icon.ico">
</head>
<body>
    <div class="d-flex justify-content-center mt-5">
        <div>
            <h2>Login</h2>
            <p>Please fill in your credentials to login.</p>

            <?php 
            if(!empty($login_err)){
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }elseif (!empty($role_err)) {
                echo '<div class="alert alert-danger">' . $role_err . '</div>';
            }       
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>
                <!--<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>-->
            </form>
        </div>
    </div>
</body>
</html>