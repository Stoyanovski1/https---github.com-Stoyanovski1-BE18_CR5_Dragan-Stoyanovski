<?php


session_start();

if(isset($_SESSION["adm"])){
    header("Location: dashboard.php");
} elseif(!isset($_SESSION["user"])){
    header("Locaction: index.php");
}

require_once "components/db_connect.php";

$id = $_SESSION['user'];
$status = 'user';
$sql = "SELECT * FROM user WHERE id = {$_SESSION['user']}";
$result = mysqli_query($connect, $sql);
// $data = mysqli_fetch_assoc($result);

$tbody = '';
$img = '';
$fname = '';
if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $tbody .= "
         <div class='col-xl-3 col-sm-6 mb-5 cards' style='margin: 0 auto'>
        <div class='bg-white rounded shadow-sm py-5 px-4'><img src='pictures/{$data['image']}' alt='{$data['first_name']}' width='100' class='img-fluid rounded-circle mb-3 img-thumbnail shadow-sm'>
          <h5 class='mb-0'>{$data['first_name']}</h5><span class='small text-uppercase text-muted'>{$data['last_name']}</span>
          <p>{$data['date_of_birth']}</p>
          <p>{$data['email']}</p>
          <ul class='social mb-0 list-inline mt-3'>
            <li class='list-inline-item'><a href='update.php?id={$data['id']}'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a></li>
            <li class='list-inline-item'><a href='delete.php?id={$data['id']}'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></li>
            <li class='list-inline-item'><a href='details.php?id={$data['id']}'><button class='btn btn-primary btn-sm' type='button'>Details</button></a></li>
          </ul>
        </div>
      </div>";
      $img .= "<img src='pictures/{$data['image']}' alt='{$data['first_name']}' width='100' class='img-fluid rounded-circle mb-3 img-thumbnail shadow-sm'>";
      $fname .= "<h1>{$data['first_name']}</h1>";
    }
} else {
    $tbody = "<center><h1>No Data Available</h1></center>";
}

mysqli_close($connect);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-Home</title>
    <?php require_once 'components/boot.php' ?>
    <style type="text/css">
        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }

        td {
            text-align: left;
            vertical-align: middle;
        }

        tr {
            text-align: center;
        }

        .userImage {
            width: 60px !important;
            height: 60px !important;
        }
    </style>
</head>

<body>
            <!-- NAVBAR -->
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
            <?= $img ?>
            <p><?= $fname ?></p>
        <a class="my-2 mx-2 text-center" href="products/user_details.php" style="color: white; text-decoration:none;"><button class="btn btn-primary mx-2">Show animals</button></a>
        <a class="my-2 mx-2 text-center" href="logout.php?logout" style="color: white; text-decoration:none;"><button class="btn btn-primary mx-2">Logout</button></a>
    <!-- </div> -->
  </div>
</nav>
        <!-- NAVBAR --> 


     <div class="container">
     <h2 class="display-4 font-weight-light text-center mt-5">My Profile</h2>

        <div class="row">
            <!-- ---FORM 1--- -->
            <div class="container py-5">
            <div class="row mb-4">
            <div class="col-lg-5">
            <!-- <p class="font-italic text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p> -->
            </div>
            </div>

            <div class="row text-center">
                <?= $tbody ?>
            </div>
            </div>
            <!-- FORM 1 END--- -->

        </div>
    </div> 
</body>
</html>