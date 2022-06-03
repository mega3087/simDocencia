<?php
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_port'] = 465;
$config['charset'] = 'utf8'; // iso-8859-1
$config['mailtype'] = 'html';
$config['smtp_user'] = CORREO_NOTIFICACION;
$config['smtp_pass'] = CONTRASENA_CORREO_NOTIFICACION;
$config['newline'] = "\r\n";
$config['wordwrap'] = TRUE;