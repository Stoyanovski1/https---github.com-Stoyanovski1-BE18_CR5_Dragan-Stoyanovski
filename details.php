<?php
    require_once "components/db_connect.php";

    session_start();

    if(isset($_SESSION["user"])){
        header("Location: index.php");
    }
    $id = $_GET["id"];
    $sql = "SELECT * FROM user WHERE id = $id";

    $result = mysqli_query($connect, $sql);
    // $row = mysqli_fetch_assoc($result);

    $tbody = '';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tbody .= "<tr>
                <td><img class='img-thumbnail rounded-circle' src='pictures/" . $row['image'] . "' alt=" . $row['first_name'] . "></td>
                <td> {$row['first_name']}  {$row['last_name']}  </td>
                <td> {$row['date_of_birth']}  </td>
                <td> {$row['email']}  </td>
                <td><a href='update.php?id= {$row['id']}'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
                <a href='delete.php?id={$row['id']}'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a>
                <a href='details.php?id={$row['id']}'><button class='btn btn-primary btn-sm' type='button'>Details</button></a>
                <a href='dashboard.php'><button class='btn btn-primary btn-sm' type='button'>Back</button></a>
                </td>

             </tr>";
        }
    } else {
        $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
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
    <div>
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
    </div>
</body>
</html>