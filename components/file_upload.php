<?php

function file_upload($image, $src = "user"){

$result = new stdClass();
$result->fileName = "product.jpg";

if($src == "product"){
    $result->fileName = "product.jpg";
}

$result->error = 1;

$fileName = $image['name'];
$fileError = $image['error'];
$fileType = $image["type"];
$fileSize = $image['size'];
$fileTempName = $image['tmp_name'];

$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$filesAllowed = ["png", "jpg", "jpeg"];

if($fileError == 4){ # you can't choose a picture
    $result->errorMessage = "No picture was choosen";
    return $result;
} else { # you can choose a picture
    if(in_array($fileExtension, $filesAllowed)){

        if($fileError == 0){

            if($fileSize < 500000){

                $fileNewName = uniqid('') . '.' . $fileExtension;
                $destination = "pictures/$fileNewName";
                if($src == 'product'){
                    $destination = "../pictures/$fileNewName";
                } 
                
                if(move_uploaded_file($fileTempName, $destination)){
                    $result->error = 0;
                    $result->fileName = $fileNewName;
                    return $result;
                } else {
                    $result->errorMessage = "There was an error uploading this file.";
                    return $result;
                }

            } else {
                $result->errorMessage = "The picture is bigger than (500kb) <br> Please choose another picture";
                return $result;
            }
        } else {
            $result->errorMessage = "Was Error while uploading $fileError code, check PHP documentation.";
            return $result;
        }
    } else {
        $result->errorMessage = "Can't be uploaded";
        return $result;

    }
}
}



?>