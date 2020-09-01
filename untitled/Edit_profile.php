<?php
include 'Functions.php';
try {
    session_start();

    $host = "localhost";
    $user = "postgres";
    $pass = "amarcgkom";
    $db = "Instagram";

    $con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");

    $user_id = $_SESSION["current_user"];
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
        }

        .block {
            margin: auto;
            height: 100%;
            width: 80%;
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

<body>

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
    $filepath = "images/Blank-profile.jpg";
    echo "<a href='?pressed'> <img src=" . $filepath . " height=30 width=30/> </a>"; //insta logo
    if (isset($_GET['pressed'])) {
        $_SESSION["user"] = $_SESSION["current_user"] ;
        header('Location: Profile.php');
    }
    echo "</br>";
    echo "</br>";
    ?>

    <?php
    $filepath = "images/insta.jpg";
    echo "<a href=\"Feed.php\"> <img src=" . $filepath . " height=30 width=30/> </a>";
    ?>

    <h1> <?php echo $username ?> </h1>

    <p><b><?php echo $fullname ?> </b> </br> <?php echo $bio ?> </br>
        Followers: <b><?php echo $follower_count ?></b> Following: <b><?php echo $following_count ?></b> Posts:
        <b><?php echo $post_count ?></b>
    </p>

    <form action="edit_profile_work.php" method="post" enctype="multipart/form-data">
        Profile Picture: <input type="file" name="fileToUpload" id="fileToUpload" > </br>
        Bio: <input type="text" name="bio" size="25" length="25" > </br>
        Website: <input type="text" name="website" size="25" length="25" > </br>
        <input class="styled" type="submit" value="Edit" name="submit">
    </form>

</div>
</body>
</html>
