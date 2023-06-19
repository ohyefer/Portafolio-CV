<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/php-email-form/PHPMailer/src/PHPMailer.php';
require '../assets/vendor/php-email-form/PHPMailer/src/SMTP.php';
require '../assets/vendor/php-email-form/PHPMailer/src/Exception.php';

if(!isset($_SERVER['HTTP_REFERER'])){
    // Prevent direct access to this PHP file
    die();
}

class PHP_Email_Form {
    public $to = '';
    public $from_name = '';
    public $reply_to = '';
    public $subject = '';
    public $smtp = array(
        'host' => 'smtp.gmail.com',
        'username' => 'bravoluquey@gmail.com',
        'password' => 'dxwctpfeehgswcpd',
        'port' => '587'
    );
    public $ajax = false;
    public $send_charset = 'UTF-8';
    public $body = '';

    function send() {
        $result = false;
        $body = $this->generate_body();
        $send_charset = $this->send_charset;

        require_once('../assets/vendor/php-email-form/PHPMailer/src/PHPMailer.php');
        $mail = new PHPMailer(true);
        $mail->CharSet = $send_charset;
        $mail->isSMTP();          
        $mail->Host = $this->smtp['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $this->smtp['username'];
        $mail->Password = $this->smtp['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $this->smtp['port'];
        $mail->addAddress($this->to); 
        $mail->SetFrom($this->reply_to, $this->from_name);
        $mail->addReplyTo($this->reply_to, $this->from_name);
        $mail->Subject = $this->subject;
        $mail->MsgHTML($body);
        $result = $mail->Send();

        if($this->ajax) {
            return $result ? 'OK' : $mail->ErrorInfo;
        } else {
            return $result;
        }
    }

    function add_message($message, $name = '') {
        if($name) {
            $this->body .= "<p><b>".$name.":</b> ".$message."</p>\r\n";
        } else {
            $this->body .= "<p>".$message."</p>\r\n";
        }
    }

    private function generate_body() {
        $body = "<div>\r\n";
        $body .= $this->body;
        $body .= "</div>\r\n";
        return $body;
    }
}
?>
