<!-- sessions  -->
<!-- the duration between the login and logout is called a session -->
<?php
error_reporting(0);
session_start();

// a sessino variable
$_SESSION["username"] = "Harshit Gangwar";
echo $_SESSION["username"]."<br>";
$_SESSION["class"] = "B.Tech";
echo $_SESSION["class"]."<br>";

// before using the session variable created, on any of the other pages 
//page with the variable creation must be loaded first thent the other pages 

// session unsets all the variable 
//session_unset();
// after session is unset 
//echo $_SESSION["username"]; -------------gives error removed by error_reporting(0)
// a session variable may be used on a mltiple pages 

?>