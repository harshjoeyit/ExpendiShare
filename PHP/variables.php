<?php

// variables
$name = "harshit";
echo "<p>my name is : <b>$name</b> <p>";

$string1 = "<p>this is the first part ";
$string2 = "this is the second part </p>";

echo "$string1.$string2";

$n1 = 45;
$add = $n1 + 34;
echo "sum: ".$add ;             // concatination 

$mybool = true;
echo "<p>this statement is true ".$mybool."<p/>";

$var = "name";
echo $$var."<br>";                 // similar to pointer or references 


// arrays

$myArray = array(1,2,3,"kristen","stewart");
$myArray[] = "betty";           // adding an element to the array 
// r standes readable 
print_r($myArray);
echo "$myArray[4]\n";
echo "<br><br>";



$Arr[0] = "peter";
$Arr[5] = "shillon";
$Arr[] = "kimp";                // adding an element to the array 
$Arr["username"] = "Username";
print_r($Arr);
echo "<br><br>";



$A = array("France" => "blue" , 
            "India" => "orange", 
            "USA" => "red");
print_r($A);
echo "<br>";
echo "the length of the array : ".sizeof($A)."<br>"; 

//deleting the elements of the array 
unset($A["France"]);
print_r($A);
echo "<br>";

// variable deketed 
unset($name);
//echo "$name";

?>