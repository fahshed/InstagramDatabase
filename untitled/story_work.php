<?php
session_start() ;

$host = "localhost";
$user = "postgres";
$pass = "amarcgkom";
$db = "Instagram";

$con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");
$user_id = $_SESSION["current_user"];

$target_dir = "C:/Users/Fahim Morshed/PhpstormProjects/untitled/images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $image_name = $_FILES["fileToUpload"]["name"] ;
        pg_query($con, "SELECT insert_story($user_id, '$image_name')");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

header('Location: Profile.php');
?>