<?php
//Mr. McFeely is here to deliver the mail

class Mailman
{
    /**
     * @var PHPMailer
     */
    private $mail;

    /**
     * Mailman constructor.
     * @throws phpmailerException
     */
    function __construct()
    {
        //load email credentials into a multidimensional array
        $cred = parse_ini_file(SECURE_DIR . "config.ini", true);
        $emailAddress = $cred["Email Settings"]["emailAddress"];
        $emailPassword = $cred["Email Settings"]["emailPassword"];
        //Set up PHP mailer and initialize error variable
        $mail = new PHPMailer;
        $mail->Timeout = 10;
        $mail->isSMTP();                                // Set mailer to use SMTP
        $mail->CharSet = "UTF-8";
        $mail->Host = "smtp.gmail.com";                 // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                         // Enable SMTP authentication
        $mail->Username = $emailAddress;    // SMTP username
        $mail->Password = $emailPassword;              // SMTP password
        $mail->SMTPSecure = "ssl";                      // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                              // TCP port to connect to
        $mail->setFrom($emailAddress, "MyCollege Official");
        $mail->addReplyTo($emailAddress, "MyCollege Official");
        $mail->isHTML(true);                            // Set email format to HTML
        $this->mail = $mail;
    }

    /**
     * @param $toAddress
     * @param $subject
     * @param $body
     * @return bool
     */
    function sendEmail($toAddress, $subject, $body): bool
    {
        $this->mail->addAddress($toAddress);
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        try {
            $success = $this->mail->send();
        } catch (phpmailerException $e) {
            $success = false;
        }
        return $success;
    }

    function registrationEmail($toAddress){
    	$subject = "Welcome to MyCollege!";
    	$body = "Link here";
    	return $this->sendEmail($toAddress, $subject, $body);
	}

}