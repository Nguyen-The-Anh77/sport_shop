<?php
	$name = $_POST['name'];
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$submit = $_POST['submit'];
	$formcontent=" From: $name \n subject: $subject \n  Message: $message";
	$recipient = "trinhxuantrinh.uet@gmail.com";
	$subject = "Add Your Subject Here";
	$mailheader = "From: $email \r\n";
	mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
	header("location: thank-you.html")
?>