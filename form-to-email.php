<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$telephone = $_POST['telephone'];
$message = $_POST['message'];
$subject = $_POST['subject'];
//Validate first
if(empty($name)||empty($visitor_email)) 
{
    echo "Please include your name and email address.";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Incorrect email format";
    exit;
}

$email_from = $visitor_email;//<== update the email address
$email_subject = "Customer Contacted you about $subject.";
$email_body = "You have received a new message from $name.\n".
    "Here is the message:\n$message\n".
    "Their phone number is: $telephone \n".
    
$headers = "From: $email_from \r\n";
$to = "paul.hair917@gmail.com";//<== update the email address
// $headers .= "Reply-To: $visitor_email \r\n";


//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: thank-you.html');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 