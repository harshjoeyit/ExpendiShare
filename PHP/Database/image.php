<?php
error_reporting(0);
?>

<html>
    <body>      
        <form action="" method="post" enctype= "multipart/form-data">
            <input type="file" name= "uploadfile" value = "" />
            <input type="submit" name="submit" value="Upload File" />
        </form>
    </body>
</html>



<?php

//$_FILES["uploadfiles"]; ---------------------returns an associative array with the information related to image 
// also php gives a temporary name to the uploaded files
$filename = $_FILES["uploadfile"]["name"];
$tempname = $_FILES["uploadfile"]["tmp_name"];
$location = "uploads/".$filename;
           // temp location , desired location 
move_uploaded_file($tempname, $location);
echo "<img src='$location' height = '100' width = '180' />"

?>

