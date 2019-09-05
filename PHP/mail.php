<?php

$to = "harshitpublic@gmail.com" ;
$subject = "join my bill splitter" ;
$message = "harshit send an invite to bill splitter ";
$headers = "From: harshit02gangwar@gmail.com" ;

if(mail($to, $subject, $message, $headers))
    echo "Mail send succesfully" ;
else
    echo "Could not send the mail" ;
?>
