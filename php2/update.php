<?php

session_start();
include('connect.php');
$user_email = $_SESSION['email'];

if($_POST['Update'])
{
    // validation of the details is required here 
    if($_POST['name'] != "")
    {
        $name = mysqli_real_escape_string($conn,$_POST['name']);
        $update_query = "UPDATE users_info SET name = '$name' WHERE email = '$user_email' ";
        $data = mysqli_query($conn, $update_query);

        if($data)
            header('location: account.php?msg=details-updated');
    
        else    
            header('location: account.php?msg=could-not-update');   
        

    }  

    if($_POST['email'] != "")
    {
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $update_query = "UPDATE users_info SET email = '$email' WHERE email = '$user_email' ";
        $data = mysqli_query($conn, $update_query);

        if($data)
        {
            // session email must be changed since it is the same user but the email for session has changed 
            $_SESSION['email'] = $email;        
            header('location: account.php?msg=details-updated');
        }
        else    
        {
            header('location: account.php?msg=could-not-update');
        }
    }  

    if($_POST['newpassword'] != "" && $_POST['oldpassword'] != "" )
    {
        
        $query = "SELECT * FROM users_info WHERE email = '$user_email' ";
        $data = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($data);

        $current_pass = $result['password'];
        $new_pass = mysqli_real_escape_string($conn,$_POST['newpassword']);
        $old_pass = mysqli_real_escape_string($conn,$_POST['oldpassword']);

        if( $old_pass == $current_pass )
        {
            $update_query = "UPDATE users_info SET password = '$new_pass' WHERE email = '$user_email' ";
            $data2 = mysqli_query($conn, $update_query);
    
            if($data)
                header('location: account.php?msg=details-updated');
                
            else 
                header('location: account.php?msg=could-not-update');
        }
        else    
            header('location: account.php?msg=password-is-not-correct');
    }  

    if( $_POST['email'] == "" && $_POST['name'] == "" && ($_POST['newpassword'] == "" || $_POST['oldpassword'] == "") )
    {
        header('location: account.php?msg=nothing-to-update');    
    }

}

?>

