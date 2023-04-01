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
$row = mysqli_fetch_assoc($result);


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
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <img class="userImage" src="pictures/<?= $row['image'];  ?>" alt="user">
                <p>User</p>
                <a href="logout.php?logout"><button class="btn btn-primary">Sign Out</button></a>
                <a href="products/user_details.php"><button class="btn btn-primary">Animals</button></a>
            </div>
            <div class="col-8 mt-2">
                <p class='h2'>My Profile</p>
                <table class='table table-striped'>
                    <thead class='table-success'>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                </thead>
                    <tbody>
                    <tr>
                      <td><img class="userImage" src="pictures/<?= $row['image'];?>"></td>
                      <td><?= $row['first_name'] . $row['last_name']?></td>
                      <td><?= $row['email'] ?></td>
                    </tr>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>