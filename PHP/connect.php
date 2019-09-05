<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_PLASH";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if($conn)
    echo "connection OK";
else
{
    // displays the reson eith the error
    die("Connection failed because => ".mysqli_connect_error() );
}


?>
