<?php 


$localhost = "127.0.0.1";
$username = "root";
$password = "";
$db_name = "be18_cr5_animal_adoption_dragan_stoyanovski";

$connect = mysqli_connect($localhost, $username, $password, $db_name);

if($connect->connect_error){
    die("Connection failed". $connect->connect_error);
}