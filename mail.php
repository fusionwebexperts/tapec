<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "Erro, o formulário não foi enviado!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

//Validate first
if(empty($name)||empty($visitor_email)) 
{
    echo "Nome e/ou email não preenchidos!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Endereço de e-mail não é valido!";
    exit;
}

$email_from = 'tom@amazing-designs.com';//<== update the email address
$email_subject = "Formulário de contacto Tapec";
$email_body = "Recebeu uma nova mensagem de $name.\n".
    "A mensagem recebida foi:\n $message".
    
$to = "valent.jms@gmail.com";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: obrigado.html');


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