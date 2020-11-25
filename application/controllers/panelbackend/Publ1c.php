<?php
class Publ1c extends _adminController{

	public $private = false;
	public function __construct(){
		parent::__construct();
	}

	public function Index(){
		die();
	}

	public function Sendemail(){
		$subject = $_POST['subject'];
		$body = $_POST['body'];
		$recipients = $_POST['recipients'];

		if(!$subject || !$body || !$recipients)
			die();




		$setting = Config::Email();

		$this->Library('phpmail');

		$mail = new phpmail;

		$mail->SMTPDebug = $setting['debug'];                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $setting['host'];  // Specify main and backup SMTP servers
		$mail->SMTPAuth = $setting['smtpauth'];                              // Enable SMTP authentication
		$mail->Username = $setting['username'];               // SMTP username
		$mail->Password = $setting['password'];               // SMTP password
		$mail->SMTPSecure = $setting['smtpsecure'];           // Enable TLS encryption, `ssl` also accepted
		$mail->Port = $setting['port'];                 // TCP port to connect to

		$mail->setFrom($setting['from'], $setting['fromlabel']);
		$mail->addReplyTo($setting['reply'], $setting['replylabel']);




		if(!is_array($recipients))
			$mail->addAddress($recipients);     // Add a recipient
		else{
			foreach ($recipients as $key => $value) {
				$mail->addAddress($value);     // Add a recipient
			}
		}

		if($setting['extra'])
			$mail->addAddress($setting['extra']);     // Add a recipient

		//$mail->addAddress('ellen@example.com');               // Name is optional
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = $subject;
		$mail->Body = $body;
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			$error = $mail->ErrorInfo;
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $error;
		    $log_dir = "logs/";
		    file_put_contents($log_dir.date("Y-m-d"), $error."\n", FILE_APPEND);
		} else {
		    echo 'Message has been sent';
		}

	}
}