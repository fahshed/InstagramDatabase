<?php

session_start();

$host = "localhost";
$user = "postgres";
$pass = "amarcgkom";
$db = "Instagram";

$con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");

$user_id = $_SESSION["current_user"];

$filepath = "images/Blank-profile.jpg";
echo "<center> <a href='?pressed'> <img src=" . $filepath . " height=30 width=30/> </a> </center>"; //insta logo
if (isset($_GET['pressed'])) {
    $_SESSION["user"] = $_SESSION["current_user"];
    header('Location: Profile.php');
}
echo "<br/>";

$users = pg_query($con, "select requester_id, request_id from follow_requests where requested_id = $user_id");

while ($row = pg_fetch_row($users)) {
    $name_row = pg_fetch_row(pg_query($con, "select username from sign_up_info where user_id = $row[0]" )) ;
    echo "<form action='follow_requests_work.php' method='post'>
              <input type='hidden' id='reqId' name='reqId' value=$row[1]>
              <input type='submit' value=$name_row[0]>
          </form>";
}
?>