<?php


require_once '../../components/db_connect.php';
require_once '../../components/file_upload.php';

session_start();
    
if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
    header("Location: ../../index.php");
}
if(isset($_SESSION["user"])){
    header("Location: ../../home.php");
}

if($_POST){

    $image = file_upload($_FILES['image'], "product");
    $first_name = $_POST['first_name'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $breed = $_POST['breed'];
    $size = $_POST['size'];
    $gender = $_POST['gender'];
    $vaccine = $_POST['vaccine'];
    $pedigree = $_POST['pedigree'];
    $price = $_POST['price'];


    $uploadError = '';
    $sql = "INSERT INTO `animal`(`first_name`, `address`, `age`, `breed`, `size`, `gender`, `vaccine`, `pedigree`, `price`, `image`) VALUES 
    ('$first_name', '$address', $age, '$breed', '$size', '$gender', '$vaccine', '$pedigree', $price, '$image->fileName')";

    if(mysqli_query($connect,$sql) === true){
        $class = "alert alert-success";
        $message = "Succesfully Created <a href='../index.php' class='btn btn-success'>Back</a>'";
        $uploadError = ($image->error !=0)? $image->errorMessage :'';
    } else {
        $class = "alert alert-danger";
        $message = "Error while creating this record <a href='../index.php' class='btn btn-danger'>Back</a>'";
        $uploadError = ($image->error !=0)? $image->errorMessage :'';
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creating</title>
    <?= require_once "../../components/boot.php"; ?>
</head>
<body>
    <div class="w-50 <?= ($class)??""; ?>">

    <p><?= ($message)??""; ?></p>

    </div>
</body>
</html>