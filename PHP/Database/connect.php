<?php

$servername = "localhost";
$username = "root";
$password = "4004";
$dbname = "mytest";

// mysql_connect function has been removed ,
//all mysql_* functions were removed - alternative mysqli_
// @ removes the default error message shown  

// $con = mysqli_connect($mysql_host,$mysql_user,$mysql_password);

// if(mysqli_connect_errno($con))
// {
//     echo "Failed to connect to MySQL: " . mysqli_connect_error();
// }
// else
// {
//     echo "connection SUCCESS<br>";
// }

$conn = mysqli_connect($servername, $username, $password, $dbname);

if($conn)
    echo "connection OK<br><br>";
else
{
    // displays the reson eith the error
    die("Connection failed because => ".mysqli_connect_error()."<br><br>" );
}


?>