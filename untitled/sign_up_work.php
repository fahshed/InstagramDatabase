<?php
session_start();
    try {
        $mail = $_POST["mail"];
        $password = $_POST["psw"];
        $fullname = $_POST["fullname"];
        $gender = $_POST["gender"];
        $username = $_POST["username"];
        $phone = $_POST["phone"];

        $host = "localhost";
        $user = "postgres";
        $pass = "amarcgkom";
        $db = "Instagram";

        $con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");

        $insert_sign_up_info_query = "SELECT add_sign_up_info('$username', '$fullname', '$password', '$gender', '$mail', $phone);";

        pg_query($con, $insert_sign_up_info_query) or die("Cannot execute query: $insert_sign_up_info_query\n");

        $row = pg_fetch_row(pg_query("SELECT user_id from sign_up_info where username = '$username'")) ;
        $_SESSION["current_user"] = $row[0] ;
        $_SESSION["user"] = $row[0];

        pg_close($con);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

header('Location: Profile.php');
?>