<?php
session_start();


require_once "components/db_connect.php";

// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}

$class = "d-none";

if($_GET['id']){
    $id = $_GET['id'];
    $sql = "SELECT * FROM user WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    $user = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $email = $user['email'];
        $date_of_birth = $user['date_of_birth'];
        $image = $user['image'];
    }
}

if($_POST){
    $id = $_POST['id'];
    $image = $_POST['image'];
    ($image === "product.jpg") ?: unlink("pictures/$image");

    $sql = "DELETE FROM user WHERE id = {$id}";
    if(mysqli_query($connect, $sql) === true) {
        $class = "alert alert-success";
        $message = "Succsesfully Deleted!";
        header("refresh3;url=dashboard.php");
    } else {
        $class = "alert alert-danger";
        $message = "The entry was not Deleted!" . $connect->error;
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
    <title>Delete User</title>
    <?php  require_once "components/boot.php";  ?>
</head>
<style>
    .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
        
</style>
<body>

    
<div class="<?=  $class; ?>">
    <p><?= ($message)??""; ?> </p>
</div>

<legend class="h2 mb-3">Delete request <img src="pictures/<?= $image ?>" class="img-thumbnail rounded-circle"></legend>

<table style="justify-content:center">
<tr>
        <td><?=  $first_name . $last_name;  ?></td>
        <td><?=  $email  ?></td>
        <td><?=  $date_of_birth  ?></td>
</tr>
</table>
<h3>Do you really want to delete this user?</h3>
<form method="POST">
    <input type="hidden" name="id" value="<?=  $id  ?>">
    <input type="hidden" name="image" value="<?=  $image  ?>">
    <button class="btn btn-danger" type="submit">Yes, delete it!</button>
    <a href="dashboard.php"><button class="btn btn-warning" type="button">No go Back!</button></a>
</form>

</body>
</html>