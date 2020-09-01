<?php
session_start();
$_SESSION["user"] = $_POST["custId"];
echo $_SESSION["user"];
header('Location: Profile.php');
?>