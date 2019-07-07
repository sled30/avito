<?php
require_once 'lib/function.php';
$link = 'https://m.auto.ru/astrahan/cars/vaz/2114/all/';
//loadAutoru($link);

$ch = curl_init($link);
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
curl_setopt($ch, CURLOPT_REFERER, $link);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
//curl_close($ch);
loadAutoru($html);

 ?>
