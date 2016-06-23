<?php
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$mailing= $_REQUEST['mailing'];
$subscribe = $_REQUEST['subscribe'];
$episode = $_REQUEST['episode'];
$email_body = "Contact from Sports Time Machine Website:\r\n"
    ."Name : $name\r\n"
    ."Email : $email\r\n"
    ."Mailing Address: $mailing\r\n"
    ."Episode Requested: $episode\r\n"
    ."Subscribe to Newsletter?: $subscribe\r\n";

$from = 'info@sportstimemachine.com';
$subject = 'CD Request from Sports Time Machine Website'; 
$headers = 'From: <' . $from . '>' . "\r\n" .
    'Reply-to: ' . $email . "\r\n";

mail('info@sportstimemachine.net', $subject, $email_body, $headers);