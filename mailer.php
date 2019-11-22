<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/phpmailer/Exception.php';
    require 'vendor/phpmailer/PHPMailer.php';
    require 'vendor/phpmailer/SMTP.php';


    $email = new PHPMailer();
    $email->SentFrom('', 'Brandon'); //Name is optional
    $email->Subject   = 'Message Subject';
    $email->Body      = $bodytext;
    $email->AddAddress( 'destinationaddress@example.com' );
    
    $file_to_attach = 'PATH_OF_YOUR_FILE_HERE';
    
    $email->AddAttachment( $file_to_attach , 'NameOfFile.pdf' );
    
    return $email->Send();
?>