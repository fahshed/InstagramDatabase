<?php
session_start();
try {

    $host = "localhost";
    $user = "postgres";
    $pass = "amarcgkom";
    $db = "Instagram";

    $con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");

    $user_id = $_SESSION["current_user"];
    $post_id = $_POST["liked_post_Id"];

    pg_query($con, "SELECT insert_like($user_id, $post_id)") or die("Cannot execute query: $insert_sign_up_info_query\n");

    pg_close($con);
} catch (PDOException $e) {
    echo $e->getMessage();
}

header('Location: Profile.php');
?>