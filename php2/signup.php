<?php
    include("connect.php");

if($_POST['submit'])
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; 

    if($name != "" && $email != "" && $password != "")
    {
        // validate the password here

        $find_query = "SELECT * FROM user_info WHERE email = '$email' " ;
        $find = mysqli_query($conn, $find_query);
        $total = mysqli_num_rows($find);
        
        if($total == 0)
        {
            $insert_query = "INSERT INTO user_info VALUES ('$name','$email','$password')" ;
            $data = mysqli_query($conn, $insert_query);

            if($data)
                header('location: ../html/signup_success.html');
            else    
                echo "<br>data not inserted into the database";
        }

        else
        {
            ?>
            <script> window.alert('User exists, try another email') </script>
            <META HTTP-EQUIV="Refresh" CONTENT="0; URL= ../html/login.html" >
            <?php
        }

    }

}


?>