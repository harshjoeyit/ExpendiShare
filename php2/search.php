<?php
    include('connect.php');
    session_start();
    error_reporting(0);

    $user_email = $_SESSION['email'];


    if(isset($_POST['search'])){

        $name = mysqli_real_escape_string($conn, $_POST['name']);

        $query = "SELECT * FROM users_info WHERE name = '$name'";
        $data = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($data);

        print_r($result);
    }


    phpinfo();
?>


