<?php

session_start();

require_once "../components/db_connect.php";
require_once "../components/file_upload.php";

if(!isset($_SESSION['user']) && !isset($_SESSION['adm'])){
    header("Location: ../index.php");
}
if(isset($_SESSION['user'])){
    header("Location: ../home.php");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM animal WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    $animal = mysqli_fetch_assoc($result);

    // $sqlGender = "SELECT * FROM gender";
    // $resultGender = mysqli_query($connect, $sqlGender);
    // $option = "";
    // while($row = mysqli_fetch_array($resultGender)){
    // $option .= "<option value='{$row["gender_id"]}'>{$row["male_female"]}</option>";
}
    // $image = $animal['image'];
    // $first_name = $animal['first_name'];
    // $address = $animal['address'];
    // $age = $animal['age'];
    // $breed = $animal['breed'];
    // $size = $animal['size'];
    // $gender = $animal['gender'];
    // $vaccine = $animal['vaccine'];
    // $pedigree = $animal['pedigree'];
    // $price = $animal['price'];


//update
if(isset($_POST['submit'])){
    $id = $_POST['id'];
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


    // $uploadError = "";
    // $image = $imageArray->fileName;

    if($image->error == 0){
        ($_POST['image'] == "product.jpg") ?: unlink("../pictures/{$_POST['image']}");
        $sqlUpdate = "UPDATE `animal` SET `first_name`='$first_name',`address`='$address',`age`=$age,`breed`='$breed',`size`='$size',`gender`='$gender',`vaccine`='$vaccine',`pedigree`='$pedigree',`price`=$price,`image`='$image->fileName' 
        WHERE id = $id";
        if($animal['image'] != "product.jpg"){
            unlink("../pictures/{$animal['image']}");
        }
    } else {
        $sqlUpdate = "UPDATE `animal` SET `first_name`='$first_name',`address`='$address',`age`=$age,`breed`='$breed',`size`='$size',`gender`='$gender',`vaccine`='$vaccine',`pedigree`='$pedigree',`price`=$price
        WHERE id = $id";
    }
    if(mysqli_query($connect, $sqlUpdate) === true){
        $class = "alert alert-success";
        $message = "The record was succesfully updated!";
        // $uploadError = ($imageArray->error != 0) ? $imageArray->errorMessage : "";
        header("Location: index.php");
    } else {
        $class = "alert alert-danger";
        $message = "Error while uploading record!";
        // $uploadError = ($imageArray->error != 0) ? $imageArray->errorMessage : "";
        header("Location: index.php");
    }

}
mysqli_close($connect);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?= require_once "../components/boot.php"; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lily+Script+One&display=swap" rel="stylesheet">
</head>
<style>
    .img-thumbnail{
        width: 100px !important;
        height: 100px !important;
    }
</style>
<body>

<div class="container">

<h1>Update-<img src="<?= "../pictures/{$animal['image']}"; ?>" alt="<?= $animal['first_name'] ?>" class="img-thumbnail rounded-circle ms-3"> </h1>
    <form method="POST" action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']) ?>" enctype="multipart/form-data" class="form-group">

    <label for="image">Image</label>
    <input type="file" name="image" id="image" class="form-control"> <br>

    <label for="first_name">First Name</label>
    <input value="<?= $animal['first_name'] ?>" type="text" name="first_name" id="first_name" class="form-control"> <br>

    <label for="address">Address</label>
    <input value="<?= $animal['address'] ?>" type="text" name="address" id="address" class="form-control"> <br>

    <label for="age">Age</label>
    <input value="<?= $animal['age'] ?>" type="number" name="age" id="age" class="form-control"> <br>

    <label for="breed">Breed</label>
    <input value="<?= $animal['breed'] ?>" type="text" name="breed" id="breed" class="form-control"> <br>

    <label for="size">Size</label>
    <input value="<?= $animal['size'] ?>" type="text" name="size" id="size" class="form-control"> <br>

    <label for="gender">Gender</label>
    <select name="gender" class="form-control">
        <option value="male" class="form-control">Male</option>
        <option value="female" class="form-control">Female</option>
    </select> <br>

    <label for="vaccine">Vaccine</label>
    <input value="<?= $animal['vaccine']?>" type="text" name="vaccine" id="vaccine" class="form-control"> <br>

    <label for="pedigree">Pedigree</label>
    <input value="<?= $animal['pedigree']?>" type="text" id="pedigree" name="pedigree" class="form-control"> <br>

    <label for="price">Price</label>
    <input value="<?= $animal['price']?>" type="text" name="price" id="price" class="form-control"> <br>


    <input type="hidden" value="<?= $animal['id'] ?>" name="id">
    <input type="hidden" value="<?= $image ?>" name="image">

    <input type="submit" name="submit" value="Update Animal" class="btn btn-success">

    <a href="index.php" class="btn btn-warning">Back to Animal</a>

    </form>
</div>


</body>
</html>