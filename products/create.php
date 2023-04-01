<?php

session_start();

require_once "../components/db_connect.php";

if(!isset($_SESSION['user']) && !isset($_SESSION['adm'])){
    header("Location: ../index.php");
}
if(isset($_SESSION['user'])){
    header("Location: ../home.php");
}

$sql = "SELECT * FROM gender";
$result = mysqli_query($connect, $sql);
$option = "";
while($row = mysqli_fetch_array($result)){
    $option .= "<option value='{$row["gender_id"]}'>{$row["male_female"]}</option>";
}

// -------- create 

// if($_POST){

//     $image = file_upload($_FILES['image'], "product");
//     $first_name = $_POST['first_name'];
//     $address = $_POST['address'];
//     $age = $_POST['age'];
//     $breed = $_POST['breed'];
//     $size = $_POST['size'];
//     $gender = $_POST['gender'];
//     $vaccine = $_POST['vaccine'];
//     $pedigree = $_POST['pedigree'];
//     $price = $_POST['price'];


//     $uploadError = '';
//     $sqlInsert = "INSERT INTO `animal`(`first_name`, `address`, `age`, `breed`, `size`, `gender`, `vaccine`, `pedigree`, `price`, `image`) VALUES 
//     ('$first_name', '$address', $age, '$breed', '$size', '$gender', '$vaccine', '$pedigree', $price, '$image->fileName')";

//     if(mysqli_query($connect,$sql) === true){
//         $class = "alert alert-success";
//         $message = "Succesfully Created <a href='../index.php' class='btn btn-success'>Back</a>'";
//         $uploadError = ($image->error !=0)? $image->errorMessage :'';
//     } else {
//         $class = "alert alert-danger";
//         $message = "Error while creating this record <a href='../index.php' class='btn btn-danger'>Back</a>'";
//         $uploadError = ($image->error !=0)? $image->errorMessage :'';
//     }
// }  htmlspecialchars($_SERVER['SCRIPT_NAME']) 


// -------- end 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Animal</title>
    <?= require_once "../components/boot.php"; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lily+Script+One&display=swap" rel="stylesheet">
</head>
<style>
    *{
        font-family: 'Lily Script One', cursive;
    }
</style>
<body>
    <?php  if(isset($message)){ ?>
<div class="w-50 <?= ($class)??""; ?>">

<p><?= ($message)??""; ?></p>

</div>
<?php } ?>
<div class="container">

<form method="POST" action="actions/a_create.php" enctype="multipart/form-data" class="form-group">

    <label for="image">Image</label>
    <input type="file" name="image" id="image" class="form-control"> <br>

    <label for="first_name">First Name</label>
    <input  type="text" name="first_name" id="first_name" class="form-control"> <br>

    <label for="address">Address</label>
    <input type="text" name="address" id="address" class="form-control"> <br>

    <label for="age">Age</label>
    <input type="number" name="age" id="age" class="form-control"> <br>

    <label for="breed">Breed</label>
    <input type="text" name="breed" id="breed" class="form-control"> <br>

    <label for="size">Size</label>
    <input type="text" name="size" id="size" class="form-control"> <br>

    <label for="gender">Gender</label>
    <select name="gender" class="form-control">
        <option value="1" class="form-control">Please choose</option>
        <?= $option; ?>
    </select> <br>

    <label for="vaccine">Vaccine</label>
    <select name="vaccine" id="vaccine" class="form-control">
        <option value="1"class="form-control">Please choose</option>
        <option value="yes" class="form-control">Yes</option>
        <option value="no" class="form-control">No</option>
    </select> <br>
    <!-- <input type="text" name="vaccine" id="vaccine" class="form-control">  -->

    <label for="pedigree">Pedigree</label>
    <input type="text" id="pedigree" name="pedigree" class="form-control"> <br>

    <label for="price">Price</label>
    <input type="text" name="price" id="price" class="form-control"> <br>


    <!-- <input type="hidden" value="<?= $animal['id'] ?>" name="id">
    <input type="hidden" value="<?= $image ?>" name="image"> -->

    <input type="submit" name="submit" value="Create Animal" class="btn btn-success">

    <a href="index.php" class="btn btn-warning">Back to Animal</a>

    </form>

</div>

</body>
</html>