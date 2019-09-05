<?php

include("connect.php");
// removeing the error message
//error_reporting(0);



if($_POST['submit'])
{

    $Name = $_POST['name'];
    $Email = $_POST['email'];
    $Password = $_POST['password'];
    
    if($Name != "" && $Email != "" && $Password != "")
    {
        $query = "INSERT INTO 'Sign Up' VALUES ('$Name','$Email','$Password')" ;
        $data = mysqli_query($conn, $query);
        
        if($data)
        {
            echo "<br>data inserted in database ";
        }
        else
        {
            echo "email exists";
        }
    }
    else
    {
        echo "<br>All fields are required <br>";
    }
}

else 
{
    echo "not submitted";
}

?>