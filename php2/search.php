<?php
include("connect.php");
$query = "SELECT * FROM users_info";
$num_rows = mysqli_num_rows($query);
echo $query;

?>