<?php

include 'Functions.php';

session_start();

try {
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Verdana, sans-serif;
        }

        .mySlides {
            display: none;
        }

        img {
            vertical-align: middle;
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        /* Caption text */
        .text {
            color: black;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: black;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active {
            background-color: #717171;
        }

        /* Fading animation */
        .fade {
            -webkit-animation-name: fade;
            -webkit-animation-duration: 1.5s;
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @-webkit-keyframes fade {
            from {
                opacity: .4
            }
            to {
                opacity: 1
            }
        }

        @keyframes fade {
            from {
                opacity: .4
            }
            to {
                opacity: 1
            }
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
            .text {
                font-size: 11px
            }
        }


        body {
            font-family: "Comic Sans MS";
            color: black;
        }

        .centered {
            margin: auto;
            width: 40%;
            text-align: center;
            background: cornsilk;
        }

        /*
        .centered img {
            width: 150px;
            border-radius: 50%;
        }
        */

        .block {
            margin: auto;
            height: 100%;
            width: 64%;
            overflow-y: scroll;
            text-align: left;
        }


        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        /* Next & previous buttons */
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a grey background color */
        .prev:hover, .next:hover {
            background-color: #f1f1f1;
            color: black;
        }
    </style>
</head>

<body>

<div class="centered">
    <?php
    $filepath = "images/Blank-profile.jpg";
    echo "<a href='?pressed'> <img src=" . $filepath . " height=30 width=30/> </a>"; //insta logo
    if (isset($_GET['pressed'])) {
        $_SESSION["user"] = $_SESSION["current_user"];
        header('Location: Profile.php');
    }
    echo "<br/>"
    ?>

    <br/>
    <a href="all_users.php"> ALL USERS </a>

    <br/>
    <a href="friend_suggestion.php"> Friend Suggestions </a>
    <br/>

    <a href="following_activity.php"> Following Activity </a>
    <br/>
    <br/>


    <div class="slideshow-container">
        <small>
            <?php
            $story = pg_query($con, "select (select username from sign_up_info where user_id = s.user_id), s.image from stories s where user_id in (select user_id from follow where follower_id = $user_id)");
            while ($row = pg_fetch_row($story)) {
                $image_name = $row[1];
                $filepath = "images/" . $image_name;
                /*echo "<div class=\"mySlides1\">
                      <img src=" . $filepath . " height=200 width=300>
                      </br>

                  </div>";*/
                echo "<div class=\"mySlides fade\">
                          <img src=" . $filepath . " height=200 width=300>
                          <div class=\"text\">$row[0]</div>
                      </div> 
                      ";
            }

            echo "<br/>
                  <div style=\"text-align:center\">
                        <span class=\"dot\"></span> 
                        <span class=\"dot\"></span> 
                        <span class=\"dot\"></span> 
                        <span class=\"dot\"></span>
                        <span class=\"dot\"></span> 
                        <span class=\"dot\"></span> 
                        <span class=\"dot\"></span> 
                        <span class=\"dot\"></span>
                  </div>";

            ?>
        </small>
    </div>

    <div class="block">
        <small>
            <?php
            $post = pg_query($con, "select post_id from posts where user_id in (select user_id from follow where follower_id = $user_id)");
            while ($row = pg_fetch_row($post)) {
                $post_id = $row[0];
                showpost($con, $post_id);
            }
            ?>
        </small>
    </div>
</div>

<script>
    var slideIndex = 0;
    showSlides();

    function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        setTimeout(showSlides, 2000); // Change image every 3 seconds
    }
</script>

</body>
</html>