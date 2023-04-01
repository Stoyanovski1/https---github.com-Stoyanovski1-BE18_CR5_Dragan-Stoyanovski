<?php

session_start();

require_once "../components/db_connect.php";

if(!isset($_SESSION['user']) && !isset($_SESSION['adm'])){
    header("Location: ../index.php");
}
// if(isset($_SESSION['user'])){
//     header("Location: ../home.php");
// };

if(isset($_GET['id'])){
    $id = $_GET['id'];
};
$sql = "SELECT * FROM animal WHERE age > 8";
$result = mysqli_query($connect, $sql);

$card = "";

if(mysqli_num_rows($result) > 0){
    while($animal = mysqli_fetch_assoc($result)){
    $card .= "
    <div class='card mb-5 shadow' style='width: 23rem; margin:0 auto; border:none; height: 50rem'>
        <img src='../pictures/{$animal['image']}' class='card-img-top' alt='{$animal['first_name']}' style='width:100%; height: 550px;'>
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
        </div>
    ";
    }
} else {
    $card .= "<div>No data Available</div>";
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior</title>
    <?= require_once "../components/boot.php"; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lily+Script+One&display=swap" rel="stylesheet">
</head>
<style>
    *{
        font-family: 'Lily Script One', cursive;
    }
    nav{
        background-color: rgba(178, 98, 98, 0.9);
    }
    .img-thumbnail{
        width: 70px !important;
        height: 70px !important;
    }
    .btnsss{
        background-color: #becbd7 ;
    }
    .btns{
        background-color: rgba(178, 98, 98, 0.9);
    }
    .btnss{
        background-color: #becbd7;
    }
</style>
<body>


<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <img src="../pictures/logo.jpg" class="img-thumbnail rounded-circle" alt="logo">
    <h4 class="ms-3">Pet Shop</h4>
    <a class="navbar-brand ms-5 px-2 btnsss" href="user_details.php">Available Pets</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active btnsss" href="user_details.php">Back to Animals</a>
        </li>
      </ul>
    </div>
  </div>
  <a class="nav-link active me-3 btnss" href="../logout.php?logout"><button class="btn">Logout</button></a>
</nav>

<main>     

<h1 class="text-center mt-5">Senior Animals</h1>

<div class='mt-5 container animals row row-cols-lg-3 row-cols-md-2 row-cols-sm-1' style="margin: 0 auto;">
<?= ($card)??""; ?>
</div>
</main>


</body>
</html>