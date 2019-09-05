<?php

// dont need to include the session.php
// can use the seesion variables anywhre
session_start();



//accessing the session variables
$name = $_SESSION['Name'] ;
$age = $_SESSION['Age'] ;
$weight = $_SESSION['weight'] ;

echo "$name <br>";
echo "$age <br>";
echo "$weight <br>";

unset($_SESSION['weight']);             // unsets the session , destroys the session variable 

//destroys all the session variables 
//session_destroy();

?>