<?php 

require_once "components/db_connect.php";
require_once "components/file_upload.php";

session_start();

    if(isset($_SESSION["user"])){
        header("Location: home.php");
    } 
    if(isset($_SESSION["adm"])){
        header("Location: dashboard.php");
    }

function cleanInput($param){
    
    $clean = trim($param);
    $clean = strip_tags($clean);
    $clean = htmlspecialchars($clean);

    return $clean;
}

$fnameError = $lnameError = $emailError = $passError = $date_of_birth_error = $first_name = $last_name = $email = "";
if(isset($_POST['register'])){
    $error = false;

    $first_name = cleanInput($_POST['first_name']);
    $last_name = cleanInput($_POST['last_name']);
    $password = cleanInput($_POST['password']);
    $email = cleanInput($_POST['email']);
    $date_of_birth = cleanInput($_POST['date_of_birth']);
    $image = file_upload($_FILES['image']);

    if(empty($first_name)){ 
        $error = true;
        $fnameError = "Please insert you First Name";
    } elseif(strlen($first_name) < 3){
        $error = true;
        $fnameError = "The First Name must have at least 3 chars";
    } elseif(!preg_match("/^[a-zA-Z]+$/", $first_name)){
        $error = true;
        $fnameError = "First Name must contain only letters";
    }

    if(empty($last_name)){
        $error = true;
        $lnameError = "Please insert you Last Name";
    } elseif(strlen($last_name) < 3){
        $error = true;
        $lnameError = "The Last Name must have at least 3 chars!";
    } elseif(!preg_match("/^[a-zA-Z]+$/", $last_name)){
        $error = true;
        $lnameError = "Last Name must contain only letters!";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $emailError = "Please enter a valid email address";
    } else {
        $query = "SELECT email from users WHERE email = '$email'";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) != 0){
            $error = true;
            $emailError = "Provided Email is already in use!";
        }
    }

    if(empty($date_of_birth)) {
        $error = true;
        $date_of_birth_error = "Please enter your Birthday!";
    }
    
    // Password validation
    if(empty($password)) {
        $error = true;
        $passError = "Please enter your password";
    } elseif(strlen($password) < 6){
        $error = true;
        $passError = "Pasword must have at least 6 chars!";
    }
    $password = hash("sha256", $password);

    if(!$error){
        $sql = "INSERT INTO `user`(`first_name`, `last_name`, `password`, `date_of_birth`, `email`, `image`) VALUES 
        ('$first_name', '$last_name', '$password', '$date_of_birth','$email', '$image->fileName')";
        $result = mysqli_query($connect, $sql);
        if($result){
            $errType = "success";
            $errMsg = "<i class='bi bi-check-circle-fill'></i> Succesfully registred, you may login now!";
            $uploadError = ($image->error != 0) ? $image->errorMessage : "";
        } else {
            $errType = "danger";
            $errMsg = "Something went Wrong, try again later!";
            $uploadError = ($image->error != 0) ? $image->errorMessage : "";
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
    <?php  require_once "components/boot.php";  ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
    <title>Register</title>
</head>
<style>
    .jumbotron label {
    font-size:12px;    
}

.reg-icon{
    color:#5bc0de;
    font-weight:bold;
    text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.4) !important;
}

.nav-pills>li.active>a, .nav-pills>li.active>a:hover, .nav-pills>li.active>a:focus {
    color: #fff;
    background-color: #5bc0de;
}

.prj-name{
    font-weight:bold;
    color:#5bc0de;
} 
.bg-gray{
    background-color:gainsboro ;
    margin-top: 140px;
    padding: 30px;
    width: 70%;
}
#form{
    margin-left:300px;
}


 

</style>

<body>
    

    <div class="container bootstrap snippets bootdey bg-gray">
  <div class="jumbotron text-center" style="min-height:400px;height:auto;">
    <div class="col-md-10 col-md-offset-2">
        <form class="w-45 form-horizontal" id="form" method="POST" role="form" action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>" enctype="multipart/form-data">
            <div class="form-group text-center">
                <div class="col-sm-10 reg-icon">
                    <span class="fa fa-user fa-3x mb-3">Register now!</span>
                </div>

                <?php  if(isset($errMsg)) {  ?>

                            <div class="alert alert-<?= $errType ?>" role="alert">
                            <?= $errMsg ?>
                            <?= $uploadError ?>
                            </div>

                <?php  }  ?>

            </div>
            <div class="form-group">
                <div class="col-sm-10">
                  <input type="text" name="first_name" class="form_control w-75" placeholder="Please enter your first name" value="<?= $first_name ?>"> <br>
                  <span class="text-danger"><?= ($fnameError)??""; ?></span> <br>

                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10">
                  <input type="text" name="last_name" class="form_control w-75" placeholder="Please enter your last name" maxlength="30" value="<?= $last_name?>"> <br>
                  <span class="text-danger"><?= $lnameError ?></span> <br>

                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10">
                  <input type="text" name="email" class="form_control w-75" placeholder="Please enter your email" value="<?= $email ?>"> <br>
                  <span class="text-danger"><?= $emailError ?></span> <br>

                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10">
                  <input type="password" name="password" class="form_control w-75" placeholder="Please enter your password"> <br>
                  <span class="text-danger"><?= $passError ?></span> <br>

                </div>

                <div class="col-sm-10">
                  <input type="date" name="date_of_birth" class="form_control w-75" value="<?= $date_of_birth ?>"> <br>
                  <span class="text-danger"><?= $date_of_birth_error ?></span> <br>

                </div>

                <div class="col-sm-10">
                <input type="file" name="image" class="form_control w-75"> <br>
                </div>


              </div>
              <div class="form-group">
                <div class="col-sm-10">
                <button type="submit" name="register" class=" updel mt-3" style="background-color: #5bc0de;">
                    <span class="glyphicon glyphicon-share-alt"></span>
                    Register
                  </button>
                  <button class="updel" style="background-color: #5bc0de;"> <a style="text-decoration:none; color:black" href="index.php">Hava a Account? Click here</a></button>
                </div>
              </div>
        </form>
    </div>
  </div>
</div>       




</body>
</html>