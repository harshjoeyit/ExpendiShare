<?php

if(is_numeric($_GET['number']) && $_GET['number'] > 0 && $_GET['number'] && round($_GET['number'], 0))
{
    $i = 2;
    while( $i < $_GET['number'])
    {
        if($_GET['number'] % $i == 0)
            break;
        $i++;
    }
    if($i != $_GET['number'])
        echo $_GET['number']." not prime !";

    else
        echo $_GET['number']." is a prime !";
}

else if($_GET)
{
    // user has submitted a invalid input 
    echo "please enter a positive a whole number ";
}

?>

<form >
    <p>number </p>
    <input type = "text" name = "number">
    <input type = "submit" value = "Go"></a><br><br>
</form>