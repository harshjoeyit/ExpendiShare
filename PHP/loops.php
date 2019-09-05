<?php

$user = "samy";
if($user == "sammy")
echo "the user is sammy<br>";
else
echo "unknown user <br>";



if($user)                               // like c++ or c
echo "user exits <br>";
else    
echo "not exist<br>";


for ($i = 0; $i<10; $i++)
echo "$i ";
echo "<br>";
echo "the value of i: $i". "<br><br> ";              //$i has scope outside the loop , it is global variable 



$family = array("shrimp", "bean", "sink");

for ($i = 0; $i<sizeof($family); $i++)
echo "$family[$i] , \t";
echo "<br>";



// for each loop

foreach ( $family as $key => $value )
{
    $family[$key] = "Mr. ".$value;   
}

foreach ( $family as $key => $value )
{
    echo "Array item ".$key." is ".$value."<br>";   
}
echo "<br>";



// while loop
$i = sizeof($family);
while($i--)
{
    echo $family[$i]."<br>";
}

?>