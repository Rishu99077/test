<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array
(
    'protocol' => 'sendmail', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'ssl://smtp.googlemail.com', 
    'smtp_port' => 465,
    'smtp_user' => 'anjalidravid@hotmail.com',
    'smtp_pass' => 'alpha@12345',
    'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',


    'wordwrap' => TRUE
);
