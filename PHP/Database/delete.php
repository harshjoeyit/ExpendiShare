<?php

include("connect.php");
$rollno = $_GET['rn'];

$query = "DELETE FROM STUDENT WHERE ROLLNO='$rollno' ";
$data = mysqli_query($conn, $query);

if($data)
{
    // untill ok is pressed the the following lines are not executed 
    echo "<script> window.alert('Record Deleted')</script>";
    ?>
    
    <!-- content decides after how much seconds shhould the page refresh -->
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=display.php" >
    <?php
}

else
{
    echo "record deleted from the table";
}

?>