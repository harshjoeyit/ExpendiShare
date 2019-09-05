<?php
    session_start();
    include("connect.php");
    error_reporting(0);
?>

<html>
<head>
</head>
<body>

    <form action="" method="post">
        Username: <input type="text" name ="username" value = "" required/><br><br>
        Password: <input type="password" name ="password" value = "" required /><br><br>
        <input type="submit" name ="submit" value = "Submit"/>
    </form>

<?php

if($_POST['submit'])
{
    $user = $_POST['username'];
    $pwd = $_POST['password'];
    $query = "SELECT * FROM STUDENT WHERE username = '$user' AND password = '$pwd' ";
    $data = mysqli_query($conn, $query);
    $total = mysqli_num_rows($data);

    if($total == 1)
    {
        $_SESSION['user_name'] = $user;
        header('location: home.php');
    }
    else
    {
        echo "login failed<br>";
    }
}

?>

    </body>
</html>