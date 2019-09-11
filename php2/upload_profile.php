<?php

session_start();
include('connect.php');
$user_email = $_SESSION['email'];

// condition needs to be changed user cannot press upload if the file is not choosen
if( $user_email == true )
{

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $location = "../user_profile_pics/".$filename;

    $update_query = "UPDATE user_info SET profile_pic = '$location' WHERE email = '$user_email' ";
    $data = mysqli_query($conn, $update_query);
    
    if($data)
    {
        move_uploaded_file($tempname, $location);
        header('location: ../php2/dashboard.php');
    }
    else    
    {
        ?>
        <script> window.alert('Image not uploaded') </script>
        <?php
    }

}
else
{   
    header('location: ../php2/dashboard.php'); 
}

?>

