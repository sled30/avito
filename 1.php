<?php
require_once 'lib/function.php';
/*

                            pars_find->

*/
//https://www.avito.ru/astrahanskaya_oblast/avtomobili/vaz_lada/2114_samara?s_trg=4&f=188_901b
$site = 'https://www.avito.ru';
$region = 'astrahanskaya_oblast';
$category = 'avtomobili';
$name_search = 'vaz_lada/2114_samara?s_trg=4&f=188_901b';

$vaz = $site.'/'.$region.'/'.$category.'/'.$name_search;
//echo $vaz;
avito_parser_auto($vaz);

/*$avto_link = $site.'/'.$region.'/'.$category.'/'.vaz_2114_samara_2009_1713497498'
$model_avto= 'vaz_2114_samara_';*/
//$a = 'https://m.avito.ru/liman/avtomobili/vaz_2114_samara_2009_1274909156';
//$jsovn = find_data_avto(file_get_contents($a));
//$w = derban_json($jsovn);

?>
