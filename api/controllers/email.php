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

    public function sendRecoveryCode($to, $code){
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

        return "
        <html>
        <head>
            <title>Restablecer Contraseña</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    color: #333;
                }
                .container {
                    max-width: 600px;
                    margin: auto;
                    background: white;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                .header {
                    text-align: center;
                    background-color: #007BFF;
                    color: white;
                    padding: 10px 0;
                    border-radius: 5px 5px 0 0;
                }
                .footer {
                    text-align: center;
                    font-size: 12px;
                    color: #777;
                    margin-top: 20px;
                }
                a.button {
                    display: inline-block;
                    padding: 10px 15px;
                    background-color: #007BFF;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Restablecer Contraseña</h1>
                </div>
                <p>Hola,</p>
                <p>Para restablecer tu contraseña, haz clic en el siguiente enlace:</p>
                <a class='button' href='$code'>Restablecer Contraseña</a>
                <p>Si no solicitaste un cambio de contraseña, ignora este correo.</p>
                <div class='footer'>
                    <p>Gracias,</p>
                    <p>El equipo de soporte.</p>
                </div>
            </div>
        </body>
        </html>
    ";

    }

}

?>