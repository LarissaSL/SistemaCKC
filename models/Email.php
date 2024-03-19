<?php 

require_once ('libs/phpmailer/src/PHPMailer.php');
require_once ('libs/phpmailer/src/SMTP.php');
require_once ('libs/phpmailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email 
{
    public function enviarEmail($enderecoDeEmail, $assunto, $bodyDoEmail, $altBodyDoEmail)
    {
        $email = new PHPMailer();

        try
        {
            // Configurações
            $email->isSMTP();
            $email->Host = 'smtp.gmail.com';
            $email->SMTPAuth = true;
            $email->Username = 'ckckart23@gmail.com';
            $email->Password = 'cmzp ewlg ykbp fjff';
            $email->Port = 587;

            // Configurar opções TLS personalizadas para aceitar certificados autoassinados (Retirar nos Windows Originais)
            $email->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];

            // Configurações de envio
            $email->setFrom('ckckart23@gmail.com');
        
            //Quem vai receber
            $email->addAddress($enderecoDeEmail);

            $email->isHTML(true);

            // Assunto
            $email->Subject = $assunto;

            $email->Body = $bodyDoEmail;
            $email->AltBody = $altBodyDoEmail;

            if($email->send())
            {
                return 'Sucesso';
            } 
            else 
            {
                return 'Erro';
            }
        } 
        catch (Exception $erro)
        {
           return "Erro ao enviar mensagem: {$erro}"; 
        }
    }
}

?>
