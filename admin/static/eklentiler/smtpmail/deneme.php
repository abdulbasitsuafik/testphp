<?php
require_once ( 'class.phpmailer.php' ); // Add the path as appropriate

$Mail = new PHPMailer();
$Mail->IsSMTP(); // Use SMTP
$Mail->Host        = "mail.kaydet.com.tr"; // Sets SMTP server
$Mail->SMTPDebug   = 1; // 2 to enable SMTP debug information
$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
//$Mail->SMTPSecure  = "tls"; //Secure conection
$Mail->Port        = 587; // set the SMTP port
$Mail->Username    = 'newschool@kaydet.com.tr'; // SMTP account username
$Mail->Password    = 'New8695.'; // SMTP account password
$Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
$Mail->CharSet     = 'UTF-8';
$Mail->Encoding    = '8bit';
$Mail->Subject     = 'Newschool Mesaj';
$Mail->ContentType = 'text/html; charset=utf-8\r\n';
$Mail->From        = 'newschool@kaydet.com.tr';

$Mail->addReplyTo('info@newschool.com.tr', 'Newschool');


$Mail->FromName    = 'Newschool';
$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
//for ($i=0;$i<count($kime);$i++) {
    $Mail->AddAddress('serkan@serkan.com.tr'); // To:
//}

$Mail->isHTML( TRUE );
$Mail->Body    = $mesaj;
$Mail->AltBody = $MessageTEXT;
$Mail->Send();
$Mail->SmtpClose();
if ( $Mail->IsError() ) {
    echo "Hata Mail Gitmadi";
}
else {
    echo "Mail Gönderildi";
}

?>