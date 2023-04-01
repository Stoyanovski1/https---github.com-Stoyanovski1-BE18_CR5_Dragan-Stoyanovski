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
        $tbody .= "<tr>
            <td><img class='img-thumbnail rounded-circle' src='pictures/{$data['image']}' alt='{$data['first_name']}'></td>
            <td> {$data['first_name']}  {$data['last_name']}  </td>
            <td> {$data['date_of_birth']}  </td>
            <td> {$data['email']}  </td>
            <td>
            <a href='update.php?id={$data['id']}'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
            <a href='delete.php?id={$data['id']}'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a>
            <a href='details.php?id={$data['id']}'><button class='btn btn-primary btn-sm' type='button'>Details</button></a>
            </td>

         </tr>";
    }
} else {
    $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
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
            <div class="col-2" style="display:flex">
                <div>
                <img class="userImage mt-3" src="pictures/<?= $row['image'] ?>" alt="Adm avatar">
                <p class="">Administrator</p>
                </div>
                <a class="ms-3 mt-3" href="logout.php?logout"><button class="btn btn-primary">Logout</button></a>
            </div>
            <div class="col-8 mt-2">
                <p class='h2'>Users</p>
                <table class='table table-striped'>
                    <thead class='table-success'>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Date of birth</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $tbody ?>
                    </tbody>
                </table>
                <a class="float-end" href="products/index.php"><button class="btn btn-primary">Adopt a pet</button></a>
            </div>
        </div>
    </div>
</body>
</html>