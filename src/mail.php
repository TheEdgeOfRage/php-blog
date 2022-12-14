<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php';

function sendMail($email, $key){
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    } else {
        $m = new PHPMailer;
        $m->isSMTP();

        $m->Host = getenv('SMTP_HOST');
        $m->SMTPSecure = 'tls';
        $m->Port = 587;
        $m->SMTPAuth = true;
        $m->Username = getenv('SMTP_USER');
        $m->Password = getenv('SMTP_PASS');

        $m->From = getenv('SMTP_FROM_MAIL');
        $m->FromName = getenv('SMTP_FROM_NAME');
        $m->addAddress($email);
        $m->isHTML(true);

        return $m;
    }
}
?>
