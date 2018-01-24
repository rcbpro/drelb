<?php

include('malier/class.phpmailer.php');

class Email{

	function send_email($Subject, $from, $from_name, $body, $alt_body, $atachment, $file_name, $to, $cc, $bcc){

		$mail = new PHPMailer();

		$mail->Subject = $Subject;
		$mail->From     = $from;
		$mail->FromName = $from_name;
		$mail->Host     = "localhost";
		//$mail->Mailer   = "smtp";
	
	
		$mail->Body    = $body;
		$mail->AltBody = $alt_body;
		$mail->AddAttachment($atachment, $file_name);
		$mail->AddAddress($to);
		$mail->AddCC($cc);
		$mail->AddBCC($bcc);
	
		if(!$mail->Send()){
			$success = false;
		}else{
			$success = true;
		}
		// Clear all addresses and attachments for next loop

		$mail->ClearAddresses();
		$mail->ClearCCs();	
		$mail->ClearBCCs();
		$mail->ClearReplyTos();
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();
		$mail->ClearCustomHeaders();

		return $success;
	
	}
}
?>
