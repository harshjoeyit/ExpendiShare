<?php
    include("connect.php");
    // removeing the error message
    error_reporting(0);
?>

<html>
<head>
</head>
<body>

    <form action="" method="post" enctype= "multipart/form-data">
        Roll No: <input type="text" name ="rollno" value = ""/><br><br>
        Name: <input type="text" name ="studentname" value = ""/><br><br>
        Class: <input type="text" name ="class" value = ""/><br><br>
        Upload Image <input type="file" name= "uploadfile" value = "" /><br><br>
        <input type="submit" name ="submit" value = "Submit"/>
    </form>

<?php

if($_POST['submit'])
{
    $rn = $_POST['rollno'];
    $sn = $_POST['studentname'];
    $cl = $_POST['class']; 

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $location = "uploads/".$filename;
    move_uploaded_file($tempname, $location);
                // temp location , desired location (where we want to save the uploaded file )

    if($rn != "" && $sn != "" && $cl != "" && $filename != "" )     // filename is empty if no file is chosen
    {
        $query = "INSERT INTO STUDENT VALUES ('$rn','$sn','$cl', '$location')" ;
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