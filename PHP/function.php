<?php

hello_world();

function hello_world()
{
    echo "<b>this is a function</b><br>"; 
}

function add( $x, $y )
{
    $result =  $x + $y;
    return $result;
}

$sum = add(100.894,365.7);
echo "sum: $sum<br>";



?>