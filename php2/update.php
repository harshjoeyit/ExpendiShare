<?php

session_start();
include('connect.php');
$user_email = $_SESSION['email'];

if()
{
    $query = "SELECT * FROM users_info WHERE email = '$user_email' ";
    $data = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($data);

    $name = $result['name'];
    $profile_pic = $result['profile_pic'];

}

?>

