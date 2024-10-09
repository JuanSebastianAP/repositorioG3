<?php

require_once __DIR__ . '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class EmailSender {

    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this -> configureMailer();
    }
    private function configureMailer() {


        $this->mailer->isSMTP();
        $this->mailer->Host       = 'smtp.hostinger.com';
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = 'jdc@tunjatienevoz.com';
        $this->mailer->Password   = 'Jdc.email.2024';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Cambia a SMTPS
        $this->mailer->Port       = 465;
        $this->mailer->CharSet    = 'UTF-8';
        $this->mailer->Timeout    = 30; // Añade un timeout
        $this->mailer->setFrom('jdc@tunjatienevoz.com', 'cambio calve jdc');
        $this->mailer->isHTML(true);
    }

    private function sendRecoveryCode($to, $code){
        try{
        $this->mailer -> addAddress($to);
        $this->mailer -> Subject = 'Código de recuperación de contraseña';

        $body = $this -> getEmailTemplate($code);

        $this->mailer -> Body = $body;
        $this-> mailer ->AltBody = "Tu código de recuperación es: $code. Este Código expirará en 1 hora";

        $this -> mailer ->send();
        return true;
    }catch(Exception $e){
        error_log("Error al enviar correo: {$this->mailer->ErrorInfo}");
        return false;
    }
    }

    private function getEmailTemplate($code){

    
    }

}

?>