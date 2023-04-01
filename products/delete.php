<?php

require_once '../components/db_connect.php';

session_start();
    
if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
    header("Location: ../index.php");
}
if(isset($_SESSION["user"])){
    header("Location: ../home.php");
}

if($_GET['id']){
    $id = $_GET['id'];
    $sql = "SELECT * FROM animal WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    $animal = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) == 1){

    } else {
        header("Location: error.php");
    }
mysqli_close($connect);

} else {
    header("Location: error.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
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
        width: 100px !important;
        height: 100px !important;
    }
    fieldset{
        text-align: center;
    }
</style>
<body>
    
<fieldset>
    <legend>Delete request <img class="img-thumbnail rounded-circle" src="../pictures/<?= $animal['image'] ?>" alt="image"></legend>
    <h5>You have selected the data below:</h5>


    <table class="table w-75 mt-3">
                <tr>
                    <td><?php echo $animal['first_name']?></td>
                </tr>
            </table>

            <h3 class="mb-4">Do you really want to delete this animal?</h3>
            <form action ="actions/a_delete.php" method="post">
                <input type="hidden" name="image" value="<?php echo $animal['image'] ?>" >
                <input type="hidden" name="id" value="<?php echo $animal['id'] ?>" >
                <input type="hidden" name="first_name" value="<?php echo $animal['first_name'] ?>" >
                <input type="hidden" name="age" value="<?php echo $animal['age'] ?>" >
                <input type="hidden" name="address" value="<?php echo $animal['address'] ?>" >
                <input type="hidden" name="breed" value="<?php echo $animal['breed'] ?>" >
                <input type="hidden" name="size" value="<?php echo $animal['size'] ?>" >
                <input type="hidden" name="gender" value="<?php echo $animal['gender'] ?>" >
                <input type="hidden" name="vaccine" value="<?php echo $animal['vaccine'] ?>" >
                <input type="hidden" name="pedigree" value="<?php echo $animal['pedigree'] ?>" >
                <input type="hidden" name="price" value="<?php echo $animal['price'] ?>" >

                <button class="btn btn-danger" type="submit">Yes, delete it!</button>
                <a href="index.php"><button class="btn btn-warning" type="button">No, go back!</button></a>
            </form>
</fieldset>

</body>
</html>