<?php

class Mail{


    /**
     * Připraví email (objekt PHPMailer) bez zprávy, předmětu a příjemců... Prostě jen tělo bez obsahu
     * @throws Exception
     * @throws phpmailerException
     * @return PHPMailer - předpřipravená zpráva
     */
    public static function prepareGmail(){

        $mail = new PHPMailer();

        $mail->isSMTP(); // telling the class to use SMTP
        $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
        if(VERBOSE){
            $mail->SMTPDebug  = 2;
        }
                                    // 1 = errors and messages
                                    // 2 = messages only
        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = 'tls';                 // sets the prefix to the servier
        $mail->Host       = gethostbyname('smtp.gmail.com');      // sets GMAIL as the SMTP server
        $mail->Port       = 587;                   // set the SMTP port for the GMAIL server

        $mail->Username   = "noreply.pivko@gmail.com";  // GMAIL username
        $mail->Password   = "qwertzuiop123456";            // GMAIL password

        $mail->CharSet  = "utf-8";
        $mail->WordWrap = 70;


        $mail->SetFrom('noreply.pivko@gmail.com', 'Registrační systém PIVKo');

        $mail->AddReplyTo("pivko.pilirion@gmail.com","Organizační tým PIVKo");

        return $mail;
    }


}



?>