<?php

if($_POST)
{
    $users = array("kriti", "varun", "rajeev", "kunal", "hardik", "prachi", "rohan");
    $flag = false;

    for( $i = 0; $i < sizeof($users); $i++ )
    {
        if( $users[$i] == $_POST['username'] )
        {
            $flag = true;
            break;
        }
    }
    
    if($flag)
        echo "Welcome ".$_POST['username']." ! <br>" ;
    else
        echo "Unknown User - ".$_POST['username']."<br>" ;
    
} 

?>   

<form method="post">
    <p>Username </p>
    <input type = "text" name="username" >
    <input type = "submit" value = "Go"></a><br><br>
</form>