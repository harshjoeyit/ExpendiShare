<?php

$servername = "localhost";
$username = "root";
$password = "4004";
$dbname = "ExpendiShare";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if($conn)
    echo "";

else
    die("Connection failed because => ".mysqli_connect_error()."<br>" );

?>