<?php
    session_start();
    include("connect.php");
    error_reporting(0);

    if($_POST['submit'])
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM users_info WHERE password = '$password' AND email = '$email' ";
        $data = mysqli_query($conn, $query);
        $total = mysqli_num_rows($data);

        if($total == 1)
        {
            $_SESSION['email'] = $email;
            header('location: ../php2/dashboard.php');
        }
        else
        {
            ?>
            <script> window.alert('Invalid credentials\nTry agin') </script>
            <META HTTP-EQUIV="Refresh" CONTENT="0; URL= ../html/login.html" >
            <?php
        }
    }    

?>
