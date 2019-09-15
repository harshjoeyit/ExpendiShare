<?php
    
    // $message = "this is an email invite form ExpendiShare";
    // $subject = "Invite";

    // if(isset($_POST['send']))
    // {
    //     $e = $_POST['email'];
    //     $s = $subject;
    //     $m = $message;
       
    //     if( mail($e, $s, $m) )     
    //         echo "mail sent";
    //     else
    //         echo "not sent";
    // }
    // else
    //     echo"email not send";
?>


 <?php
 
    include("connect.php");
    error_reporting(0);
    session_start();

    $user_email = $_SESSION['email'];
    $query = "SELECT * FROM users_info WHERE email='$user_email' "; 
    $data = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($data);
    $name = $result['name'];
    $check = 0;

    $message = "\n Join ExpendiShare now \n http://localhost/ExpendiShare/html/login.html \n and share your bills with ".$name." and others";
    $subject = $name." wants to share bills with you on ExpendiShare";

    if(isset($_POST['send']))
    {
        $e = mysqli_real_escape_string($conn,$_POST['email']);
        $s = $subject;
        $m = $message;

        if( mail($e, $s, $m) )          
        {   
            ?>
            <script>window.alert('Mail Invite Sent')</script>
            <?php
        }
        else
        {
            ?>
            <script>window.alert('Could not Send Mail Invite')</script>
            <?php
        }
        ?>       
        <!-- redirecting to the dshboard -->
        <META HTTP-EQUIV="Refresh" CONTENT="0; URL= ../php2/dashboard.php" >
        <?php
    
        }
    else
    {
        echo "not sent";
            ?>
            <script>window.alert('Could not Send Mail Invite')</script>
            <?php
    }
        
?>