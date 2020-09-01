<?php

include 'Functions.php';

session_start();

try {
    $host = "localhost";
    $user = "postgres";
    $pass = "amarcgkom";
    $db = "Instagram";

    $con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");

    $user_id = $_SESSION["user"];
} catch (PDOException $e) {
    $e->getMessage();
}
?>

<html>
<head>
    <style>
        body {
            font-family: "Comic Sans MS";
            color: black;
        }

        .centered {
            margin: auto;
            width: 40%;
            text-align: center;
            background-color: lemonchiffon;
        }

        .block {
            margin: auto;
            height: 100%;
            width: 64%;
            overflow-y: scroll;
            text-align: left;
        }

        .styled {
            border: 0;
            line-height: 2.5;
            padding: 0 20px;
            font-size: 1rem;
            text-align: center;
            color: #fff;
            text-shadow: 1px 1px 1px #000;
            border-radius: 10px;
            background-color: rgba(220, 0, 0, 1);
            background-image: linear-gradient(to top left,
            rgba(0, 0, 0, .2),
            rgba(0, 0, 0, .2) 30%,
            rgba(0, 0, 0, 0));
            box-shadow: inset 2px 2px 3px rgba(255, 255, 255, .6),
            inset -2px -2px 3px rgba(0, 0, 0, .6);
        }

        .styled:hover {
            background-color: rgba(255, 0, 0, 1);
        }

        .styled:active {
            box-shadow: inset -2px -2px 3px rgba(255, 255, 255, .6),
            inset 2px 2px 3px rgba(0, 0, 0, .6);
        }
    </style>
</head>

<div class="centered">
    <?php
    $user = pg_query($con, "SELECT * from users WHERE user_id = $user_id");
    while ($row = pg_fetch_row($user)) {
        $image = $row[1];
        $bio = $row[2];
        $website = $row[3];
        $post_count = $row[4];
        $follower_count = $row[5];
        $following_count = $row[6];
        $private = $row[7];
    }
    $user = pg_query($con, "SELECT * from sign_up_info WHERE user_id = $user_id");
    while ($row = pg_fetch_row($user)) {
        $username = $row[1];
        $fullname = $row[2];
    }
    ?>

    <?php
    if ($user_id != $_SESSION["current_user"]) {
        $filepath = "images/Blank-profile.jpg";
        echo "<a href='?pressed'> <img src=" . $filepath . " height=30 width=30/> </a>"; //insta logo
        if (isset($_GET['pressed'])) {
            $_SESSION["user"] = $_SESSION["current_user"];
            header('Location: Profile.php');
        }
        echo "</br>";
        echo "</br>";
    }
    ?>

    <?php
    $filepath = "images/insta.jpg";
    echo "<a href=\"Feed.php\"> <img src=" . $filepath . " height=30 width=30/> </a>"; //insta logo
    ?>
    </br>
    </br>

    <?php
    $filepath = "images/" . $image;
    echo "<img src=" . $filepath . " height=60 width=60/>"; //dp
    ?>

    <h1> <?php echo $username ?> </h1>

    <?php
    if ($user_id != $_SESSION["current_user"]) {
        $filepath = "images/follow.jpg";
        echo "<a href='?pressed'> <img src=" . $filepath . " height=20 width=80/> </a>"; //follow button
        if (isset($_GET['pressed'])) {
            $requester = $_SESSION["current_user"];
            pg_query($con, "SELECT add_follow_req($requester,$user_id)");
        }
        echo "</br>";
    }
    ?>


    <b> <?php echo $fullname ?> </b> </br>
    <?php echo $bio ?> </br>

        <?php echo "<form method = 'post'>
                            Followers: <button type='submit' formaction='view_followers.php'> <b>$follower_count</b></button> 
                            Following: <button type='submit' formaction='view_followings.php'> <b>$following_count</b></button> 
                            Posts:<b> $post_count <b>
                     </form>";
              echo "</br>";
        ?>

        <?php
        if ($user_id == $_SESSION["current_user"]) {
            echo "<a href=\"follow_requests.php\"> Follow Requests </a>";
            echo "</br>";
            echo "</br>";

            echo "<form action='Edit_profile.php' method='post' enctype='multipart/form-data'>
        <input class='styled' type='submit' value='Edit Profile' name='submit'> </form>";

            echo "<form action='story_work.php' method='post' enctype='multipart/form-data'>
                 <input type='file' name='fileToUpload' id='fileToUpload'> </br>
                 <input class='styled' type='submit' value='Add Story' name='submit'>
              </form>";

            echo "<form action='post_work.php' method='post' enctype='multipart/form-data'>
                 <input type='file' name='fileToUpload' id='fileToUpload'> </br>
                     Caption: <input type='text' name='caption' size='25' length='25'> </br>
                     Location: <input type='text' name='location' size='25' length='25'> </br>
                 <input class='styled' type='submit' value='Add Post' name='submit'>
              </form>";
        }
        ?>

        <p><b>POSTS</b></p>
        <div class="block">
            <small>
                <?php
                $post = pg_query($con, "SELECT post_id from posts WHERE user_id = $user_id");
                while ($row = pg_fetch_row($post)) {
                    $post_id = $row[0];
                    showpost($con, $post_id);
                }
                ?>
            </small>
        </div>

        <?php
        if ($user_id == $_SESSION["current_user"]) {
            $filepath = "images/Logout.jpg";
            echo "<a href=\"sign.php\"> <img src=" . $filepath . " height=60 width=150/> </a>";
        }
        ?>
</div>
</html>