<?php

include "datetime.php";             // includes the specified file 
// can also use the require function in place of include 
// the file required is not find then the later code is not executed , include function display the error but executes the later code 
// if the include statement is used more than once then the file code is executed again 
// include_once('datetime.php');
// this function can be used to ensure that it is included only once 



// global variable
$name = "Mark";

function disp()
{
    global $name;               // the variable can be used now 
    echo "the name is : $name <br>";
}

function disp2()
{
    $name = "Rick";
    echo "another name is : $name <br>";
}

disp();
disp2();

?>