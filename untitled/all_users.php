<?php

$host = "localhost";
$user = "postgres";
$pass = "amarcgkom";
$db = "Instagram";

$con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");

$users = pg_query($con, "select username, user_id from sign_up_info");

$filepath = "images/Blank-profile.jpg";
echo "<center> <a href='?pressed'> <img src=" . $filepath . " height=30 width=30/> </a> </center>"; //insta logo
if (isset($_GET['pressed'])) {
    $_SESSION["user"] = $_SESSION["current_user"];
    header('Location: Profile.php');
}
echo "<br/>";

echo "<b> All users </b>" ;
echo "<br/>";


while ($row = pg_fetch_row($users)) {
    echo "<form action='visit_profile_work.php' method='post'>
              <input type='hidden' id='custId' name='custId' value=$row[1]>
              <input type='submit' value=$row[0]>
          </form>";
}
?>