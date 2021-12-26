<?php

namespace Framer\Core\Useful\Classes;

use Framer\Core\Model\EnvModel;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer {

    static $mail = null;


    /**
     * getConfig
     * 
     * @return EnvModel
     */
    static function getConfigs() {
        return EnvModel::get();
    }


    /**
     * doConfig
     * 
     * @return void
     */
    static function doConfig() {

        self::$mail = new PHPMailer(true);
        $conf = self::getConfigs();

        //Server settings
        self::$mail->SMTPDebug = $conf->mail_debug ? SMTP::DEBUG_SERVER : 0; //Enable verbose debug output
        self::$mail->isSMTP();                                            //Send using SMTP
        self::$mail->Host       = $conf->mail_host;                       //Set the SMTP server to send through
        self::$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        self::$mail->Username   = $conf->mail_username;                   //SMTP username
        self::$mail->Password   = $conf->mail_password;                   //SMTP password
        self::$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        self::$mail->Port       = $conf->mail_port;                       //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    }


    /**
     * setAddresses
     * 
     * @param $addresses
     * @param $type - can be: Adress | ReplyTo | CC | BCC | Attachement
     * 
     * @return void
     */
    static function setDestinations($addresses, $type='Address') {

        // parse payload
        $payload = isset($addresses[0]) && is_array($addresses[0]) ? $addresses : [$addresses];

        // set addresses
        foreach ($payload as $address) {
            self::$mail->{'add' . $type}( $address[0], $address[1] ?? '' );
        }
    }

    static function send($mailObject) {

        !self::$mail && self::doConfig();

        try {
            //Recipients
            self::$mail->setFrom($mailObject->sender[0], $mailObject->sender[1] ?? '');

            // addresses
            self::setDestinations($mailObject->address);

            // reply to
            $mailObject->replyto && self::setDestinations($mailObject->replyto, 'ReplyTo');
            $mailObject->cc && self::setDestinations($mailObject->cc, 'CC');
            $mailObject->bcc && self::setDestinations($mailObject->bcc, 'BCC');
        
            //Attachment
            $mailObject->attachment && self::setDestinations($mailObject->attachment, 'Attachment');
        
            //Content
            self::$mail->isHTML(true);                                  //Set email format to HTML
            self::$mail->Subject = $mailObject->subject;
            self::$mail->Body    = $mailObject->body;
            self::$mail->AltBody = $mailObject->altbody ?? '';
        
            self::$mail->send();
            
            return (object) ["error" => false];
        } catch (Exception $e) {
            return (object) ["error" => true, "message" => self::$mail->ErrorInfo];
        }
    }

}