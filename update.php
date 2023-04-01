<?php

session_start();

require_once 'components/db_connect.php';
require_once 'components/file_upload.php';

if(!isset($_SESSION['user']) && !isset($_SESSION['adm'])){
    header("Location: index.php");
    exit;
}

$backBtn = "";

//if it is a user it will create a back button to home.php
if(isset($_SESSION['user'])){
    $backBtn = "home.php";
}

//if it is a adm it will create a back button to dashboard.php
if(isset($_SESSION['adm'])){
    $backBtn = "dashboard.php";
}

//fetch and populate form
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM user WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    $user = mysqli_fetch_assoc($result);

        // $user = mysqli_fetch_assoc($result);
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
    $email = $user['email'];
    $date_of_birth = $user['date_of_birth'];
    $image = $user['image'];
    
}


//update
$class = "d-none";
if(isset($_POST['submit'])){

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $id = $_POST['id'];

    $uploadError = "";
    $imageArray = file_upload($_FILES['image']);
    $image = $imageArray->fileName;
    
    if($imageArray->error === 0){
        ($_POST['image'] == "product.jpg") ?: unlink("pictures/{$_POST['image']}");
        $sql = "UPDATE `user` SET `first_name`='$first_name',`last_name`='$last_name',`date_of_birth`='$date_of_birth',`email`='$email',`image`='$image' WHERE id = {$id}";
    } else {
        $sql ="UPDATE `user` SET `first_name`='$first_name',`last_name`='$last_name',`date_of_birth`='$date_of_birth',`email`='$email' WHERE id = {$id}";
    }
    if(mysqli_query($connect, $sql) === true){
        $class = "alert alert-success";
        $message = "The record was successfully updated";
        $uploadError = ($imageArray->error != 0) ? $imageArray->errorMessage : '';
        header("refresh:3;url=update.php?id={$id}");
    } else {
        $class = "alert alert-success";
        $message = "Error while updating record!";
        $uploadError = ($imageArray->error != 0) ? $imageArray->errorMessage : '';
        header("refresh:3;url=update.php?id={$id}");
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
    <title>Update User</title>
    <?php  require_once "components/boot.php";  ?>
</head>
<style>
    .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
</style>
<body>
    
<div class="container">
        <div class="<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
        </div>

        <h2>Update</h2>
        <img class="img-thumbnail rounded-circle" src="pictures/<?= $user['image'] ?>" alt="user">
        <form method="POST" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>First Name</th>
                    <td><input class="form-control" type="text" name="first_name" value="<?php echo $first_name; ?>" /></td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td><input class="form-control" type="text" name="last_name" value="<?php echo $last_name ?>" /></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input class="form-control" type="email" name="email"  value="<?php echo $email ?>" /></td>
                </tr>
                <tr>
                    <th>Date of birth</th>
                    <td><input class="form-control" type="date" name="date_of_birth"  value="<?php echo $date_of_birth ?>" /></td>
                </tr>
                <tr>
                    <th>Picture</th>
                    <td><input class="form-control" type="file" name="image" ></td>
                </tr>
                <tr>
                    <input type="hidden" name="id" value="<?php echo $user['id'] ?>" />
                    <input type="hidden" name="image" value="<?php echo $image ?>" />
                    
                    <td><button name="submit" class="btn btn-success" type="submit">Save Changes</button></td>
                    <td><a href="<?php echo $backBtn ?>"><button class="btn btn-warning" type="button">Back</button></a></td>
                </tr>
            </table>
        </form>
    </div>


</body>
</html>