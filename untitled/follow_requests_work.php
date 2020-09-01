<?php

session_start();

$host = "localhost";
$user = "postgres";
$pass = "amarcgkom";
$db = "Instagram";

$con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n");

$req_id = $_POST["reqId"];

pg_query($con, "DELETE from follow_requests where request_id = $req_id");

/*header('Location: follow_requests.php') ;*/
?>