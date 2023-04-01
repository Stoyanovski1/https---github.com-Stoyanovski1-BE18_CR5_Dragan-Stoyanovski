<?php 

require_once "../../components/db_connect.php";

session_start();

if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
    header("Location: ../../index.php");
}
if(isset($_SESSION["user"])){
    header("Location: ../../home.php");
}




if($_POST){
    $id = $_POST['id'];
    $image = $_POST['image'];
    ($image == "product.jpg") ?: unlink("../../pictures/{$image}");

    $sql = "DELETE FROM animal WHERE id = {$id}";

    if(mysqli_query($connect, $sql) == true){
        $class = "alert alert-success";
        $message = "Succesfully deleted" . "<a href='../index.php' class='btn btn-success'>Animals</a>";
        $btn = "success";
    } else {
        $class = "alert alert-danger";
        $message = "Error while deleting" . "<a href='../index.php' class='btn btn-danger'>Animals</a>";
        $btn = "danger";
    }
    mysqli_close($connect);
} else {
    header("Location: ../error.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleting</title>
    <?= require_once "../../components/boot.php"; ?>
</head>
<body>

<div class="m-3">
    <h1>Delete request response</h1>
</div>

<div class="<?= ($class)??""; ?>" role="alert">
<p><?= ($message)??"" ?></p>
</div>
    
</body>
</html>