<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$text = $_REQUEST['msg'];
$email_body = "Sponorship Inquiry from Sports Time Machine Website:\r\n"
    ."Name : $name\r\n"
    ."Email : $email\r\n"
    ."Comment or Question: $text\r\n";

$from = $email;
$subject = 'Sponsorship Inquiry from Sports Time Machine Website'; 
$headers = 'From: <' . $from . '>' . "\r\n" .
    'Reply-to: ' . $email . "\r\n";

mail('info@sportstimemachine.net', $subject, $email_body, $headers);