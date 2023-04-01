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
    <title>Register</title>
</head>
<style>
    .hero{
        background-color: lightgray;
        width: 45%;
        border-radius: 25px;
        margin: 0 auto;
    }
</style>
<body>
    <div class="container mt-5">
        <div class="hero p-3">
    <h1>Registration Form</h1><br>

    <?php  if(isset($errMsg)) {  ?>

    <div class="alert alert-<?= $errType ?>" role="alert">
    <?= $errMsg ?>
    <?= $uploadError ?>
    </div>
    
    <?php  }  ?>

    <form class="w-45" method="POST" action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>" enctype="multipart/form-data">

    <!-- <label for="first_name">First Name</label> <br> -->
    <input type="text" name="first_name" class="form_control" placeholder="Please enter your first name" value="<?= $first_name ?>"> <br>
    <span class="text-danger"><?= ($fnameError)??""; ?></span> <br>

    <!-- <label for="last_name">Last Name</label> <br> -->
    <input type="text" name="last_name" class="form_control" placeholder="Please enter your last name" maxlength="30" value="<?= $last_name?>"> <br>
    <span class="text-danger"><?= $lnameError ?></span> <br>

    <!-- <label for="email">Email</label> <br> -->
    <input type="text" name="email" class="form_control" placeholder="Please enter your email" value="<?= $email ?>"> <br>
    <span class="text-danger"><?= $emailError ?></span> <br>

    <!-- <label for="password">Password</label> <br> -->
    <input type="password" name="password" class="form_control" placeholder="Please enter your password"> <br>
    <span class="text-danger"><?= $passError ?></span> <br>

    <!-- <label for="date_of_birth">Date of birth</label> <br> -->
    <input type="date" name="date_of_birth" class="form_control" value="<?= $date_of_birth ?>"> <br>
    <span class="text-danger"><?= $date_of_birth_error ?></span> <br>

    <!-- <label for="picture">Picture</label> <br> -->
    <input type="file" name="image" class="form_control"> <br>

    <input type="submit" value="Register" name="register" class="form_control btn btn-primary">
    <a href="index.php">Have a Account? Click here</a>

    
    </form>
    </div>
    </div>

</body>
</html>