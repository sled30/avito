<?php

//https://www.avito.ru/astrahanskaya_oblast/avtomobili/vaz_lada/2114_samara?s_trg=4&f=188_901b





$test=file_get_contents('https://www.avito.ru/astrahanskaya_oblast/avtomobili/vaz_lada/2114_samara?s_trg=4&f=188_901b');
/*while(!feof($test))
{
  print_r($test);
}*/
//echo $test;
//$match = '/\/favorites\/add\/([0-9]{10})/'; id обьявления
//$match = '/content=\"([0-9]{1,20})"/'; /// цена
$match = '/itemprop="url"
 href=\"(.{3,})\"/';
preg_match_all($match, $test, $text);
print_r($text);
foreach($text[1] as $keys)
{
  // code...
  echo "avito.ru".$keys."\n";
}

?>
