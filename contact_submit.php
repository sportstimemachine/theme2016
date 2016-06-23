<?php
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$text = $_REQUEST['msg'];
$subscribe = $_REQUEST['subscribe'];
$email_me = $_REQUEST['email_me'];
$email_body = "Contact from Sports Time Machine Website:\r\n"
			."Name : $name\r\n"
			."Email : $email\r\n"
			."Comment or Question: $text\r\n"
			."Subscribe to Newsletter?: $subscribe\r\n"
			."Email a copy of message?: $email_me\r\n"
			;
			
$from = $email;
$subject = 'Contact from Sports Time Machine Website'; 
$headers = 'From: <' . $from . '>' . "\r\n" .
	'Reply-to: ' . $email . "\r\n";
 
mail('Dustin@HartzlerDM.com', $subject, $email_body, $headers);

?>