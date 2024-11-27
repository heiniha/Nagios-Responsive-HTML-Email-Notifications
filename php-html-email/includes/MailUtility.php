<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/base.php';

class MailUtility {

    public $mail;

    /**
     * Constructor
     */
    function __construct() {
      /* Arguments from Config File config.cfg */
      $f_smtpauth = getConfig('mail', 'smtpauth');
      $f_username = getConfig('mail', 'username');
      $f_passwd = getConfig('mail', 'password');
      $f_host = getConfig('mail', 'host');
      $f_port = getConfig('mail', 'port');
      $f_from = getConfig('mail', 'from');
      $f_fromname = getConfig('mail', 'fromname');
      $f_smtpdebug = getConfig('mail', 'smtpdebug');
      $f_smtpsecure = getConfig('mail', 'smtpsecure');
      $f_company_email = getConfig('general', 'company_email');
      $f_company_name = getConfig('general', 'company_name');

      /* Create a new PHPMailer instance */
      $this->mail = new PHPMailer();
      $this->mail->CharSet = PHPMailer::CHARSET_UTF8;
      $this->mail->Encoding = 'base64';
      $this->mail->IsSMTP();
      $this->mail->SMTPDebug = $f_smtpdebug;
      $this->mail->SMTPAuth = $f_smtpauth;
      $this->mail->SMTPSecure = $f_smtpsecure;
      $this->mail->Host = $f_host;
      $this->mail->Port = $f_port;
      $this->mail->Username = $f_username;
      $this->mail->Password = $f_passwd;
      $this->mail->SetFrom($f_from, $f_fromname);
      $this->mail->AddReplyTo($f_company_email, $f_company_name);
    }

    /**
     * Send an email
     * @param string $toList Comma separated list of email addresses
     * @param string $subject Email subject
     * @param string $htmlMessage HTML message
     * @param string $textMessage Text message
     * @param int $wordWrap Word wrap
     * @return bool TRUE if the email was sent, FALSE otherwise
     */
    function sendMail($toList, $subject, $htmlMessage, $textMessage, $wordWrap = 80) {
      $this->mail->AddAddress($toList);
      $this->mail->Subject = $subject;
      $this->mail->WordWrap = $wordWrap;
      $this->mail->MsgHTML($htmlMessage);
      $this->mail->AltBody = $textMessage;
      $this->mail->IsHTML(true);
      if (!$this->mail->Send()){
        return FALSE;
      }else{
        return TRUE;
      }
    }
}

?>
