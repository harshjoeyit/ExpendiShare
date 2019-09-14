<?php

session_start();
include('connect.php');
$user_email = $_SESSION['email'];

if($_POST['Update'])
{
    // validation of the details is required here 
    if($_POST['name'] != "")
    {
        $name = $_POST['name'];
        $update_query = "UPDATE users_info SET name = '$name' WHERE email = '$user_email' ";
        $data = mysqli_query($conn, $update_query);

        if($data)
            header('location: account.php');
    
        else    
        {
            ?>
            <script> window.alert('details not updated') </script>
            <?php
            //header('location: account.php');
        }

    }  

    if($_POST['email'] != "")
    {
        $email = $_POST['email'];
        $update_query = "UPDATE users_info SET email = '$email' WHERE email = '$user_email' ";
        $data = mysqli_query($conn, $update_query);

        if($data)
        {
            // session email must be changed since it is the same user but the email for session has changed 
            $_SESSION['email'] = $email;        
            header('location: account.php');
        }
        else    
        {
            ?>
            <script> window.alert('details not updated') </script>
            <?php
            header('location: account.php');
        }
    }  
    
    // change password functionality after verifying the old password 

    if( $_POST['email'] == "" && $_POST['name'] == "" )
    {
        ?>
        <script> window.alert('Nothing to Update') </script>
        <!-- redirect here using META -->
        <?php
    }
    
}

?>

