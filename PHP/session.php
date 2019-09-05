<?php

// a sesssion is a way to store info (as variables) to be used across multiple pages 
// PHP session variable is used to store info , or change settings for a user session , session variables hold info 
// about one single user in one application 

// feature is used to make user logged until the user logs out himself
// seesion vaiables are destroyed whrn the browsers are closed
session_start();

$_SESSION['Name'] = 'mark';
$_SESSION['Age'] = 21;
$_SESSION['weight'] = 45;

echo "done<br>";

?>