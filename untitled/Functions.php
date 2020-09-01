<?php

function showpost($con, $post_id)
{
    $row = pg_fetch_row(pg_query($con, "SELECT * from posts where post_id = $post_id"));

    $user_id = $row[1];
    $caption = $row[2];
    $location = $row[3];
    $like_count = $row[4];
    $date = $row[5];
    $time = $row[6];
    $image_name = $row[7];

    echo "<br/>";
    $row = pg_fetch_row(pg_query($con, "SELECT image from users where user_id = $user_id"));
    $filepath = "images/" . $row[0];

    $row = pg_fetch_row(pg_query($con, "SELECT username from sign_up_info where user_id = $user_id"));
    /*echo "<a href='?click'>$row[0]</a>";
    if (isset($_GET['click'])) {
        $_SESSION["user"] = $row[0];
        header('Location: Profile.php');
    }
    echo "<br/>";
    */
    echo "<form action='visit_profile_work.php' method='post'>
              <img src=" . $filepath . " height=30 width=30/>
              <input type='hidden' id='custId' name='custId' value=$user_id>
              <input type='submit' value=$row[0]>
          </form>";

    echo $location;
    echo "<br/>";
    echo "<br/>";

    $filepath = "images/" . $image_name;
    echo "<img src=" . $filepath . " height=200 width=300/>";
    echo "<br/>";

    /*
    $filepath = "images/Like.jpg";
    echo "<a href='?liked'><img src=" . $filepath . " height=20 width=20/></a>";
    if (isset($_GET['liked'])) {
        pg_query($con, "SELECT like_insert($user_id, $post_id)");
        header('Location: Profile.php');
    }
    echo "   " . $like_count . " " . "Likes";
    echo "<br/>";
    */

    echo "<form action='like_work.php' method='post'>
              <input type='hidden' id='liked_post_Id' name='liked_post_Id' value=$post_id>
              <input type='submit' value='❤'>
              <button type='submit' formaction='view_likers.php'> $like_count Likes </button>
          </form>";

    echo $caption;
    echo "<br/>";
    echo "<br/>";

    echo "<form action='comment_work.php' method='post'>
              <input type='hidden' id='postId' name='postId' value=$post_id>
              <input type='text' name='comment'>
              <input type='submit' value ='Comment'>
          </form>";

    $comment = pg_query($con, "select commenter_id, (select username from sign_up_info where user_id = commenter_id), comment
                                     from comments
                                     where post_id = $post_id;");

    echo "<b>Comments</b>";
    while ($row = pg_fetch_row($comment)) {
        echo "<form action='visit_profile_work.php' method='post'>
                  <input type='hidden' id='custId' name='custId' value=$row[0]>
                  <input type='submit' value=$row[1]>
                  $row[2]
              </form>";
    }

    echo "<br/>";
    echo "<br/>";
    echo "<hr>";
}
?>