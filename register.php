<?php 

require_once "components/db_connect.php";
require_once "components/file_upload.php";

session_start();

    if(isset($_SESSION["user"])){
        header("Location: home.php");
    } 
    if(isset($_SESSION["adm"])){
        header("Location: dashboard.php");
    }

function cleanInput($param){
    
    $clean = trim($param);
    $clean = strip_tags($clean);
    $clean = htmlspecialchars($clean);

    return $clean;
}

$fnameError = $lnameError = $emailError = $passError = $date_of_birth_error = $first_name = $last_name = $email = "";
if(isset($_POST['register'])){
    $error = false;

    $first_name = cleanInput($_POST['first_name']);
    $last_name = cleanInput($_POST['last_name']);
    $password = cleanInput($_POST['password']);
    $email = cleanInput($_POST['email']);
    $date_of_birth = cleanInput($_POST['date_of_birth']);
    $image = file_upload($_FILES['image']);

    if(empty($first_name)){ 
        $error = true;
        $fnameError = "Please insert you First Name";
    } elseif(strlen($first_name) < 3){
        $error = true;
        $fnameError = "The First Name must have at least 3 chars";
    } elseif(!preg_match("/^[a-zA-Z]+$/", $first_name)){
        $error = true;
        $fnameError = "First Name must contain only letters";
    }

    if(empty($last_name)){
        $error = true;
        $lnameError = "Please insert you Last Name";
    } elseif(strlen($last_name) < 3){
        $error = true;
        $lnameError = "The Last Name must have at least 3 chars!";
    } elseif(!preg_match("/^[a-zA-Z]+$/", $last_name)){
        $error = true;
        $lnameError = "Last Name must contain only letters!";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $emailError = "Please enter a valid email address";
    } else {
        $query = "SELECT email from user WHERE email = '$email'";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) != 0){
            $error = true;
            $emailError = "Provided Email is already in use!";
        }
    }

    if(empty($date_of_birth)) {
        $error = true;
        $date_of_birth_error = "Please enter your Birthday!";
    }
    
    // Password validation
    if(empty($password)) {
        $error = true;
        $passError = "Please enter your password";
    } elseif(strlen($password) < 6){
        $error = true;
        $passError = "Pasword must have at least 6 chars!";
    }
    $password = hash("sha256", $password);

    if(!$error){
        $sql = "INSERT INTO `user`(`first_name`, `last_name`, `password`, `date_of_birth`, `email`, `image`) VALUES 
        ('$first_name', '$last_name', '$password', '$date_of_birth','$email', '$image->fileName')";
        $result = mysqli_query($connect, $sql);
        if($result){
            $errType = "success";
            $errMsg = "<i class='bi bi-check-circle-fill'></i> Succesfully registred, you may login now!";
            $uploadError = ($image->error != 0) ? $image->errorMessage : "";
        } else {
            $errType = "danger";
            $errMsg = "Something went Wrong, try again later!";
            $uploadError = ($image->error != 0) ? $image->errorMessage : "";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php  require_once "components/boot.php";  ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
    <title>Register</title>
</head>
<style>

/* -----form1-----  */
body{
    margin-top:20px;
    background-color: #f2f3f8;
}
.card {
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 15px 1px rgba(52,40,104,.08);
}

.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e5e9f2;
    border-radius: .2rem;
}
/* -----form1end-----   */

 

</style>

<body>    
                    <!-- -----form1-----  -->

                    <div class="container h-100">
    		<div class="row h-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<!-- <h1 class="h2">Get started</h1> -->
                            <span class="fa fa-user fa-3x mb-3" style="text-shadow: 1px 2px 5px black;">Register now!</span>
							<p class="lead">
								Start creating the best possible user experience for you customers.
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
                                <form class="w-45 form-horizontal" id="form" method="POST" role="form" action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>" enctype="multipart/form-data">
                                        <div class="form-froup">
                                        <?php  if(isset($errMsg)) {  ?>
                                        <div class="alert alert-<?= $errType ?>" role="alert">
                                        <?= $errMsg ?>
                                        <?= $uploadError ?>
                                        </div>

                                        <?php  }  ?>
                                        </div>
										<div class="form-group">
                                        <input type="text" name="first_name" class="form_control w-75" placeholder="Please enter your first name" value="<?= $first_name ?>"> <br>
                                        <span class="text-danger"><?= ($fnameError)??""; ?></span> <br>
										</div>
										<div class="form-group">
                                        <input type="text" name="last_name" class="form_control w-75" placeholder="Please enter your last name" maxlength="30" value="<?= $last_name?>"> <br>
                                        <span class="text-danger"><?= $lnameError ?></span> <br>
										</div>
										<div class="form-group">
                                        <input type="text" name="email" class="form_control w-75" placeholder="Please enter your email" value="<?= $email ?>"> <br>
                                        <span class="text-danger"><?= $emailError ?></span> <br>
										</div>
										<div class="form-group">
                                        <input type="password" name="password" class="form_control w-75" placeholder="Please enter your password"> <br>
                                        <span class="text-danger"><?= $passError ?></span> <br>
										</div>
                                        <div class="form-group">
                                        <input type="date" name="date_of_birth" class="form_control w-75" value="<?= $date_of_birth ?>"> <br>
                                        <span class="text-danger"><?= $date_of_birth_error ?></span> <br>
										</div>
                                        <div class="form-group">
                                        <input type="file" name="image" class="form_control w-75"> <br>
										</div>
										<div class="text-center mt-3">
											<!-- <a href="index.html" class="btn btn-lg btn-primary">Register</a> -->
                                            <button type="submit" name="register" class="btn btn-lg btn-primary">
                                            <span class="glyphicon glyphicon-share-alt"></span>
                                                Register
                                            </button>
											<!-- <button type="submit" class="btn btn-lg btn-primary">Sign up</button> -->
                                            <button class="btn btn-lg btn-primary"> <a style="text-decoration:none; color:white" href="index.php">Hava a Account? Click here</a></button>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

                    <!-- -----form1end----- -->


</body>
</html>