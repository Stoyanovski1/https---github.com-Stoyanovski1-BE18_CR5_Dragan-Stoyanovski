<?php
    require_once "components/db_connect.php";

    session_start();

    // if(isset($_SESSION["user"])){
    //     header("Location: index.php");
    // }
    $id = $_GET["id"];
    $sql = "SELECT * FROM user WHERE id = $id";

    $result = mysqli_query($connect, $sql);
    // $row = mysqli_fetch_assoc($result);

    $tbody = '';
    $img = '';
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_assoc($result)) {
            $tbody .= "<div class='col-xl-3 col-sm-6 mb-5 cards' style='margin: 0 auto'>
            <div class='bg-white rounded shadow-sm py-5 px-4'><img src='pictures/{$data['image']}' alt='{$data['first_name']}' width='100' class='img-fluid rounded-circle mb-3 img-thumbnail shadow-sm'>
              <h5 class='mb-0'>{$data['first_name']}</h5><span class='small text-uppercase text-muted'>{$data['last_name']}</span>
              <p>{$data['date_of_birth']}</p>
              <p>{$data['email']}</p>
              <ul class='social mb-0 list-inline mt-3'>
                <li class='list-inline-item'><a href='update.php?id={$data['id']}'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a></li>
                <li class='list-inline-item'><a href='delete.php?id={$data['id']}'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></li>
                <li class='list-inline-item'><a href='./index.php'><button class='btn btn-primary btn-sm' type='button'>Back</button></a></li>
              </ul>
            </div>
          </div>";

          $img .= "<img src='pictures/{$data['image']}' alt='{$data['first_name']}' width='100' class='img-fluid rounded-circle mb-3 img-thumbnail shadow-sm'>";
        }
    } else {
        $tbody = "<center>No Data Available</center>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Users</title>
    <?=  require_once "components/boot.php";  ?>
</head>

<style>
    .img-thumbnail{
        width: 70px !important;
        height: 70px !important;
    }
</style>
<body>
    <h1 class="text-center">Details about<?= $img ?></h1>
    <div>
        <?= $tbody ?>
    </div>
</body>
</html>