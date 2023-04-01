<?php

session_start();

require_once "../components/db_connect.php";

if(!isset($_SESSION['user']) && !isset($_SESSION['adm'])){
    header("Location: ../index.php");
}
if(isset($_SESSION['user'])){
    header("Location: ../home.php");
}

$id = $_GET['id'];
$sql = "SELECT * FROM animal WHERE id = {$id}";

$result = mysqli_query($connect, $sql);

$card = "";

if(mysqli_num_rows($result) > 0){
    $animal = mysqli_fetch_assoc($result);
    $card .= "
    <div class='card mb-5 shadow' style='width: 23rem; margin:0 auto; border:none; height: 43rem'>
        <img src='../pictures/{$animal['image']}' class='card-img-top' alt='{$animal['first_name']}' style='width:100%; height: 50%'>
        <figcaption class='text-center card-title py-2'><h5>{$animal['first_name']}</h5></figcaption>
        <div class='card-body'>
        <p class='card-text'>Gender: {$animal['gender']}</p>
        <p class='card-text'>Age: {$animal['age']}</p>
        <p class='card-text'>Size: {$animal['size']}</p>
        <p class='card-text'>Breed: {$animal['breed']}</p>
        <p class='card-text'>Breed: {$animal['price']}</p>
        <p class='card-text'>Breed: {$animal['address']}</p>
        <p class='card-text'>Breed: {$animal['size']}</p>
        <p class='card-text'>Breed: {$animal['vaccine']}</p>
        <p class='card-text'>Breed: {$animal['pedigree']}</p>
        </div>
        <div class='btns py-3 text-center'>
        <a href='update.php?id={$animal['id']}' class='btn btn-success'>Update Animal</a>
        <a href='delete.php?id={$animal['id']}' class='btn btn-danger'>Delete Animal</a>

        </div>
        </div>
    ";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details-<?= $animal['first_name']; ?></title>
    <?= require_once "../components/boot.php"; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lily+Script+One&display=swap" rel="stylesheet">
</head>
<style>
    *{
        font-family: 'Lily Script One', cursive;
    }
    .img-thumbnail{
        width: 70px !important;
        height: 70px !important;
    }
</style>
<body>
    <h1>Details about <img src="../pictures/<?= $animal['image']  ?>" alt="img" class="img-thumbnail rounded-circle"></h1>
    <div>
        <?= $card; ?>
    </div>
    <a href="index.php" class="btn btn-warning">Back to Animals</a>
</body>

</html>