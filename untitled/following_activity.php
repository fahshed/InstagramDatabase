<?php
session_start();
try {
    $host = "localhost";
    $user = "postgres";
    $pass = "amarcgkom";
    $db = "Instagram";

    $con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");

    //$post_id = $_POST["liked_post_Id"];
    $user_id = $_SESSION["current_user"];
    //echo $user_name;

    $filepath = "images/Blank-profile.jpg";
    echo "<center> <a href='?pressed'> <img src=" . $filepath . " height=30 width=30/> </a> </center>"; //insta logo
    if (isset($_GET['pressed'])) {
        $_SESSION["user"] = $_SESSION["current_user"];
        header('Location: Profile.php');
    }

    echo "<br/>";
    echo "<b>Following Activity </b>";
    echo "<br/>";
    echo "<br/>";
    echo "<b>Likes </b>";
    echo "<br/>";

    $likes = pg_query($con,  "select u.username, l.liker_id, l.post_id
                                    from likes l join sign_up_info u on (l.liker_id=u.user_id)
                                    where l.liker_id in
                                    (
                                        select user_id
                                        from follow
                                        where follower_id = $user_id 
                                    )");

    while ($row = pg_fetch_row($likes)) {
        echo "<form action='visit_profile_work.php' method='post'>
                  <input type='hidden' id='custId' name='custId' value=$row[1]>
                  <input type='submit' value=$row[0]>
                  Liked post $row[2]
              </form>";
    }

    echo "<b>Comments </b>";
    echo "<br/>";

    $likes = pg_query($con,  "select u.username, c.commenter_id, c.post_id
                                    from comments c join sign_up_info u on (c.commenter_id=u.user_id)
                                    where c.commenter_id in
                                    (
                                        select user_id
                                        from follow
                                        where follower_id = $user_id
                                    )");

    while ($row = pg_fetch_row($likes)) {
        echo "<form action='visit_profile_work.php' method='post'>
                  <input type='hidden' id='custId' name='custId' value=$row[1]>
                  <input type='submit' value=$row[0]>
                  Commented on post $row[2]
              </form>";
    }

    pg_close($con);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>