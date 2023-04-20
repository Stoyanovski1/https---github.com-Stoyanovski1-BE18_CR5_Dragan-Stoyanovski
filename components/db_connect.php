<?php 


$localhost = "173.212.235.205"; #127.0.0.1
$username = "dragancodefactor_Stoyanovski1";#root
$password = "Stojanovski221!"; #""
$db_name = "dragancodefactor_animal_adoption_dragan_stoyanovski"; #be18_cr5_animal_adoption_dragan_stoyanovski

$connect = mysqli_connect($localhost, $username, $password, $db_name);

if($connect->connect_error){
    die("Connection failed". $connect->connect_error);
}