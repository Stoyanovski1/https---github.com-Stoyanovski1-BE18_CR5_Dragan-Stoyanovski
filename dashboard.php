<?php


session_start();

if(!isset($_SESSION['adm']) && !isset($_SESSION['user'])){
    header("Location: dashboard.php");
} elseif(isset($_SESSION['user'])){
    header("Location: index.php");
}

require_once "components/db_connect.php";

$id = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM user WHERE id = {$_SESSION['adm']}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

$users = "SELECT * FROM user WHERE status != 'adm'";
$resultUsers = mysqli_query($connect, $users);


$tbody = '';
if (mysqli_num_rows($resultUsers) > 0) {
    while ($data = mysqli_fetch_assoc($resultUsers)) {
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
      </div>
         
         ";
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
    <title>Welcome <?= $row['first_name'] ?></title>
    <?php require_once 'components/boot.php' ?>
    <style type="text/css">
body{
    background:#eee;
    margin-top:20px;
}
.img-thumbnail {
    padding: .25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: .25rem;
    /* max-width: 100%;
    height: auto; */
    width: 100px !important;
    height: 100px !important;
}

.social-link {
    width: 30px;
    height: 30px;
    border: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    border-radius: 50%;
    transition: all 0.3s;
    font-size: 0.9rem;
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
  <img class="userImage mt-3" src="pictures/<?= $row['image'] ?>" alt="Adm avatar">
  <span><h1 class="ms-2">Admin</h1></span>
    <!-- <div class="collapse navbar-collapse" id="navbarNav"> -->  
        <a class="my-2 mx-2 text-center" href="products/index.php" style="color: white; text-decoration:none;"><button class="btn btn-primary mx-2">Adopt a Pet</button></a>
        <a class="my-2 mx-2 text-center" href="logout.php?logout" style="color: white; text-decoration:none;"><button class="btn btn-primary mx-2">Logout</button></a>
    <!-- </div> -->
  </div>
</nav>
        <!-- NAVBAR --> 


     <div class="container">
     <h2 class="display-4 font-weight-light text-center mt-5">Our Users</h2>

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