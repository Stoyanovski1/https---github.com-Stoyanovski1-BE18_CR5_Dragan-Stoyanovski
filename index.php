<?php 

    session_start();

    if(isset($_SESSION["user"])){
        header("Location: home.php");
    } 
    if(isset($_SESSION["adm"])){
        header("Location: dashboard.php");
    }

    require_once "components/db_connect.php";

    function cleanInput($param){

        $clean = trim($param);
        $clean = strip_tags($clean);
        $clean = htmlspecialchars($clean);

        return $clean;
    }
    $emailError = $email = $passError = "";
    if(isset($_POST['btn-login'])){

        $email = cleanInput($_POST['email']);
        $password = cleanInput($_POST['password']);
        $error = false;

        if(empty($email)){
            $error = true;
            $emailError = "Please enter your email address!";
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = true;
            $emailError = "Please enter a valid email address!";
        } 

        if(empty($password)){
            $error = true;
            $passError = "Please enter your password";
        }

        if(!$error){

            $password = hash("sha256", $password);

            $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
            $result = mysqli_query($connect, $sql);
            $count = mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            if($count == 1){
                if($row['status'] == "adm"){
                    $_SESSION["adm"] = $row["id"];
                    header("Location: dashboard.php");
                } else {
                    $_SESSION["user"] = $row["id"];
                    header("Location: home.php");
                }
            }

        }

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php  require_once "components/boot.php"; ?>
    <title>Index</title>
</head>
<style>
.hero{
    background-color: lightgrey;
    border-radius: 25px;
    width: 35%;
    margin: 0 auto;

}
</style>
<body>
        <div class="container mt-5">
            <div class="hero p-3">
        <h1>Login</h1>
        <hr>

        <?php 
        if(isset($errMsg)){
            echo $errMsg;
        }
        ?>

            <form method="POST" class="w-40" action="<?php  echo htmlspecialchars($_SERVER['SCRIPT_NAME']);  ?>" autocomplete="off">

            Email:
            <input type="email" autocomplete="off" name="email" class="form-control" placeholder="Your Email" value="<?= ($email)??"" ?>" maxlength="40">
            <span class="text-danger"><?php echo ($emailError)??"" ?></span>  <br>

            Password: <br>
            <input type="password" name="password" class="form_control" placeholder="Your Password" maxlength="15">
            <span class="text-danger"><?php echo ($passError)??"" ?></span> <hr>

            <button class="btn btn-block btn-primary" type="submit" name="btn-login">Sign in</button>
            <a href="register.php">Not registred yet? Click here</a>

            </form>
            </div>

        </div>
</body>
</html>