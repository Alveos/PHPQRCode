<?php 

	require_once(dirname(__FILE__).'/../lib/PHPQRCode.php');
	\PHPQRCode\Autoloader::register();

    \PHPQRCode\QRcode::jpg("Test", "/tmp/qrcode.jpg", 'L', 2, 0, 100, true, true);//Output 
