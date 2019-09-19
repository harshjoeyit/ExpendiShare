<?php

session_start();
include('connect.php');
error_reporting(0);

// valid mime types 
$legalTypes = array("image/jpeg", "image/jpeg", "image/bmp" , "image/png");


$user_email = $_SESSION['email'];

$filename = $_FILES["uploadfile"]["name"];
$tempname = $_FILES["uploadfile"]["tmp_name"];
$location = "../user_profile_pics/".$filename;
$size = $_FILES['uploadfile']['size'];

// condition needs to be changed user cannot press upload if the file is not choosen
if( $filename != "" )
{
    // limit = 1 MB
    if($size <= 1048576)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $tempname);

        // if not found in array of valid types 
        if(!in_array($mime, $legalTypes))
        {
            ?>
            <script> window.alert('Please Upload a valid image file') </script>
            <meta http-equiv="refresh" content="0; URL='account.php'" /> 
            <?php
        }
        else
        {
            $update_query = "UPDATE users_info SET profile_pic = '$location' WHERE email = '$user_email' ";
            $data = mysqli_query($conn, $update_query);
    
            if($data)
            {
                move_uploaded_file($tempname, $location);
                ?>
                    <script> window.alert('Image uploaded') </script>
                    <meta http-equiv="refresh" content="0; URL='account.php'" /> 
                <?php
            }
            else    
            {
                ?>
                <script> window.alert('Image not uploaded succesfully') </script>
                <meta http-equiv="refresh" content="0; URL='account.php'" /> 
                <?php
            }
        }
        
    }    
    else
    {
        ?>
        <script> window.alert('file must be less than 1MB') </script>
        <meta http-equiv="refresh" content="0; URL='account.php'" /> 
        <?php 
    }
}
else
{   
    ?>
    <script> window.alert('Choose a file first') </script>
    <meta http-equiv="refresh" content="0; URL='account.php'" /> 
    <?php 
}

?>

