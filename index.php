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
body{
    margin-top:20px;
    background:#eee;
}
.container {
    margin-right: auto;
    margin-left: auto;
    padding-right: 15px;
    padding-left: 15px;
    width: 100%;
}

@media (min-width: 576px) {
    .container {
        max-width: 540px;
    }
}

@media (min-width: 768px) {
    .container {
        max-width: 720px;
    }
}

@media (min-width: 992px) {
    .container {
        max-width: 960px;
    }
}

@media (min-width: 1200px) {
    .container {
        max-width: 1140px;
    }
}



.card-columns .card {
    margin-bottom: 0.75rem;
}

@media (min-width: 576px) {
    .card-columns {
        column-count: 3;
        column-gap: 1.25rem;
    }
    .card-columns .card {
        display: inline-block;
        width: 100%;
    }
}
.text-muted {
    color: #9faecb !important;
}

p {
    margin-top: 0;
    margin-bottom: 1rem;
}
.mb-3 {
    margin-bottom: 1rem !important;
}

.input-group {
    position: relative;
    display: flex;
    width: 100%;
}
</style>
<body>
        

        <?php 
        if(isset($errMsg)){
            echo $errMsg;
        }
        ?>
                    <br>
                    <br><br><br><br><br><br>
                    <form method="POST" class="w-40" action="<?php  echo htmlspecialchars($_SERVER['SCRIPT_NAME']);  ?>" autocomplete="off">
                    <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-md-8">
                            <div class="card-group mb-0">
                              <div class="card p-4">
                                <div class="card-body">
                                  <h1>Login</h1>
                                  <p class="text-muted">Sign In to your account</p>
                                  <div class="input-group mb-3">
                                    <span class="input-group-addon me-2 mt-1"><i class="fa fa-user"></i></span>
                                        <input type="email" autocomplete="off" name="email" class="form-control" placeholder="Your Email" value="<?= ($email)??"" ?>" maxlength="40">
                                        <span class="text-danger"><?php echo ($emailError)??"" ?></span>  <br>
                                  </div>
                                  <div class="input-group mb-4">
                                    <span class="input-group-addon me-2 mt-1"><i class="fa fa-lock"></i></span>
                                        <input type="password" name="password" class="form_control" placeholder="Your Password" maxlength="15">
                                        <span class="text-danger"><?php echo ($passError)??"" ?></span> <hr>
                                  </div>
                                  <div class="row">
                                    <div class="col-6">
                                      <button class="btn btn-block btn-primary px-4" type="submit" name="btn-login">Login</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="card text-white bg-primary py-5 d-md-down-none" style="width:100%">
                                <div class="card-body text-center">
                                  <div>
                                    <h2>Sign up</h2>
                                    <p>Welcome back! Please enter your login credentials below to access your account. If you don't have an account yet, you can create one by clicking the "Sign Up" button. If you forgot your password, you can reset it by clicking the "Forgot Password" button. Thank you for choosing our service.</p>
                                    <a class="btn btn-primary active mt-3" href="register.php">Register Now!</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      </form>
</body>
</html>