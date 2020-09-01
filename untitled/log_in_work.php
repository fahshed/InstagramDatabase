<?php

echo "hello";

session_start();

try {
    $username1 = $_POST['username_log'];
    $password1 = $_POST['psw_log'];

    $host = "localhost";
    $user = "postgres";
    $pass = "amarcgkom";
    $db = "Instagram";

    $con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");

    $sign = pg_query($con, "SELECT user_id FROM sign_up_info WHERE username = '$username1' AND password = '$password1'");

    while ($row = pg_fetch_row($sign)) {
        $_SESSION["current_user"] = $row[0];
        $_SESSION["user"] = $row[0] ;
    }

} catch (PDOException $e) {
    $e->getMessage();
}
header('Location: Profile.php') ;
?>