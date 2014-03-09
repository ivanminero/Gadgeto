<?php

require('class.phpmailer.php');

if(isset($_POST['email'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    //$email_to = "hidden";
    //$email_subject = "Request for Portfolio check up from ".$first_name." ".$last_name;

    $title = array('Title', 'Mr.', 'Ms.', 'Mrs.');
    $selected_key = $_POST['title'];
    $selected_val = $title[$_POST['title']]; 

    $first_name = $_POST['first_name']; // required
    $last_name = $_POST['last_name']; // required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['telephone']; // not required
    $comments = $_POST['comments']; // required

  if(($selected_key==0))
    echo "<script> alert('Please enter your title')</script>";
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     $email_message = "";
    $email_message .="Title: ".$selected_val."\n";
    $email_message .= "First Name: ".clean_string($first_name)."\n";
    $email_message .= "Last Name: ".clean_string($last_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";

    $allowedExts = array("doc", "stl", "docx", "xls", "xlsx", "pdf");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if (
	(
($_FILES["file"]["type"] == "application/sla")
|| ($_FILES["file"]["type"] == "application/octet-stream")
|| ($_FILES["file"]["type"] == "application/vnd.ms-pki.stl")
|| ($_FILES["file"]["type"] == "application/x-navistyle")
|| ($_FILES["file"]["type"] == "application/netfabb")
|| ($_FILES["file"]["type"] == "text/plain")
|| ($_FILES["file"]["type"] == "application/unknown"))

&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "<script>alert('Error: " . $_FILES["file"]["error"] ."')</script>";
    }
  else
    {	     
        //$d='/usr/home/gadgeto.net/web/bicis/bicis/form/upload/';
		$d='/usr/home/gadgeto.net/web/bicis/bicis/form/upload/';
        $de=$d . basename($_FILES['file']['name']);
    move_uploaded_file($_FILES["file"][$d], $de);
$fileName = $_FILES['file']['name'];
    $filePath = $_FILES['file'][$d];
     //add only if the file is an upload
     }
  }
else
  {
  echo "<script>alert('Invalid file')</script>";
  }

// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
//Create a new PHPMailer instance
$mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$mail->IsSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug  = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//$mail->SMTPSecure = 'ssl';
//Set the hostname of the mail server
$mail->Host       = "smtp.gadgeto.net";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port       = 587;
//Whether to use SMTP authentication
$mail->SMTPAuth   = true;
//Username to use for SMTP authentication
$mail->Username   = "ijimenez@gadgeto.net";
//Password to use for SMTP authentication
$mail->Password   = "chiklete*1";
//Set who the message is to be sent from
$mail->SetFrom($email_from, $first_name.' '.$last_name);
//Set an alternative reply-to address
//$mail->AddReplyTo('replyto@example.com','First Last');
//Set who the message is to be sent to
$mail->AddAddress('ijimenez@gadgeto.net', 'hidden');
//Set the subject line
$mail->Subject = 'Archivo subido para propuesta Gadgeto.net';
//Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
$mail->MsgHTML($email_message);
//Replace the plain text body with one created manually
$mail->AltBody = 'Archivo subido para propuesta Gadgeto.net';
//Attach an image file
//$mail->AddAttachment($file);
$mail->AddAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);

//Send the message, check for errors
if(!$mail->Send()) {
  echo "<script>alert('Mailer Error: " . $mail->ErrorInfo."')</script>";
} else {
  echo "<script>alert('Tu solicitud ha sido enviada. En breve nos pondremos en contacto contigo.')</script>";
  Header('Location: otro.php');
  //chmod("/usr/home/gadgeto.net/bicis/bicis/form/upload/" . $_FILES["file"]["name"] . ".stl", 0777);
  
}
}

?>