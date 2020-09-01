<?php
session_start();
$host = "localhost";
$user = "postgres";
$pass = "amarcgkom";
$db = "Instagram";

$con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");
$uid = $_SESSION["current_user"];
$users = pg_query($con, "SELECT DISTINCT f.user_id,(select username from sign_up_info where f.user_id = user_id)
FROM follow f
WHERE follower_id IN 
(
	SELECT user_id FROM follow WHERE follower_id = $uid 
) 
AND user_id NOT IN
(
	SELECT DISTINCT user_id FROM follow WHERE follower_id = $uid
)
AND user_id <> $uid;
");

$filepath = "images/Blank-profile.jpg";
echo "<center> <a href='?pressed'> <img src=" . $filepath . " height=30 width=30/> </a> </center>"; //insta logo
if (isset($_GET['pressed'])) {
    $_SESSION["user"] = $_SESSION["current_user"];
    header('Location: Profile.php');
}
echo "<br/>";

echo "<b> Friend Suggestion </b>" ;
echo "<br/>";

while ($row = pg_fetch_row($users)) {
    echo "<form action='visit_profile_work.php' method='post'>
              <input type='hidden' id='custId' name='custId' value=$row[0]>
              <input type='submit' value=$row[1]>
          </form>";
}
?>