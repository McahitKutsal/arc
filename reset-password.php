<?php
// Oturumu başlat
session_start();
 
// Kullanıcı oturum açmamış ise login sayfasına yönlendirilir
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Config dosyasının dahil edilmesi
require_once "db/config.php";
 
// Değişkenleri boş olarak tanımla
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Form gönderildi
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Şifre doğrulaması alanı doldurulmuş mu?
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Şifre doğrulaması kontrolü
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // İnputların kontrol edilmesi
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Update sorgusunun hazırlanması
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        
        if($stmt = $pdo->prepare($sql)){
            // Değişkenleri sorguya parametre olarak bağla
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            
            // parametreleri set et
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Hazılanan ifadeyi çalıştır
            if($stmt->execute()){
                // Şifre güncellendi session'u destroy et ve login sayfasına geri dön
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // SQL ifadesini kapat
            unset($stmt);
        }
    }
    
    // Bağlantıyı kapat
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="img/icon.ico">
</head>
<body>
    <div class="d-flex justify-content-center mt-5">
        <div>
            <h2>Reset Password</h2>
            <p>Please fill out this form to reset your password.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                    <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a class="btn btn-link ml-2" href="index.php">Cancel</a>
                </div>
            </form>
        </div>
    </div>   
</body>
</html>