<?php
    include("connect.php");
    // removeing the error message
    error_reporting(0);
?>

<html>
<head>
</head>
<body>

    <form action="" method = "GET">
        Roll No: <input type="text" name ="rollno" value = ""/><br><br>
        Name: <input type="text" name ="studentname" value = ""/><br><br>
        Class: <input type="text" name ="class" value = ""/><br><br>
        <input type="submit" name ="submit" value = "Submit"/>
</form>

<?php

if($_GET['submit'])
{
    $rn = $_GET['rollno'];
    $sn = $_GET['studentname'];
    $cl = $_GET['class']; 

    if($rn != "" && $sn != "" && $cl != "")
    {
        $query = "INSERT INTO STUDENT VALUES ('$rn','$sn','$cl')" ;
        $data = mysqli_query($conn, $query);

        if($data)
        {
            // data is only inserted if the primary key is unique 
            // else the $data = false 
            echo "<br>data inserted in database ";
        }
    }
    else
    {
        echo "<br>All fields are required <br>";
    }
}
    
     
    
   
    
    
    

?>

</body>
</html>