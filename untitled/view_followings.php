<?php
session_start();
try {

    $host = "localhost";
    $user = "postgres";
    $pass = "amarcgkom";
    $db = "Instagram";

    $con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");

    //$post_id = $_POST["liked_post_Id"];
    $user_id = $_SESSION["user"];
    //echo $user_name;

    $filepath = "images/Blank-profile.jpg";
    echo "<center> <a href='?pressed'> <img src=" . $filepath . " height=30 width=30/> </a> </center>"; //insta logo
    if (isset($_GET['pressed'])) {
        $_SESSION["user"] = $_SESSION["current_user"];
        header('Location: Profile.php');
    }
    echo "<br/>";
    echo "<b>Followings : </b>";

    $followings = pg_query($con, "select user_id,username from sign_up_info
where user_id in
(
select user_id
from follow
where follower_id = $user_id);");

    while ($row = pg_fetch_row($followings)) {
        echo "<form action='visit_profile_work.php' method='post'>
                  <input type='hidden' id='custId' name='custId' value=$row[0]>
                  <input type='submit' value=$row[1]>
              </form>";
    }

    pg_close($con);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>