<?php
include("connect.php");

if($_POST['search'])
{
    
    $query = "SELECT * FROM users_info";
    $data=mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($query);
    
    if($num_rows > 0)
    {
        header('location: account.php');
    }
    else
    {
        header('location: ../index.html');
    }
}

?>