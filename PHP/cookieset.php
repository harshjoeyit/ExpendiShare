<!-- cookies are used to identify the user_error
it is a small file that the server embeds on the user;s computer
whenever the page is requested , server sends the cokies with it  
we can set the expiration time of the cookie-->

<?php

$time = time();               // time now
echo "time: $time<br>";         // unix time 

//setcookie(name, value, expire(seconds));
setcookie('student', 'Mark', $time + 10);       // ten seconds expiry tinme 

echo "cookies is set for 10 secs ";

?>
