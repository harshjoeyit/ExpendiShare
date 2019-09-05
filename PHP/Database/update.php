


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
        Roll No: <input type="text" name ="rollno" value = "<?php echo $_GET['rn'] ?>"/><br><br>
        Name: <input type="text" name ="studentname" value = "<?php echo $_GET['sn'] ?>"/><br><br>
        Class: <input type="text" name ="class" value = "<?php echo $_GET['cl'] ?>"/><br><br>
        <input type="submit" name ="submit" value = "Update"/>
    </form>


<?php
    
if($_GET['submit'])
{
    $rn = $_GET['rollno'];
    $sn = $_GET['studentname'];
    $cl = $_GET['class']; 
                                        // WHERE CLAUSE IS VERY IMPORTANT SINCE ONLY THAT DATA NEEDS TO BE UPDATED 
    $query = "UPDATE STUDENT SET NAME = '$sn' , CLASS = '$cl' WHERE ROLLNO = '$rn' ";
    $data = mysqli_query($conn, $query);
    
    if($data)
    {
        // to jump to anothe page directly if the condition works 
        header("Location: display.php?msg=records-updated");
        //exit;
    }
    
    else
        echo "records not updated";
}
else
{
    echo "Click update button to update details";
}

?>


</body>
</html>