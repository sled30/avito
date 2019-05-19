<?php
require_once 'lib/function.php';
/*
samarskaya_oblast
penzenskaya_oblast
                            pars_find->

*/
//https://www.avito.ru/saratovskaya_oblast/avtomobili/vaz_lada/2114_samara?radius=200&s_trg=3
//https://m.avito.ru/astrahan/avtomobili/vaz_lada/2114_samara
//https://www.avito.ru/astrahan/avtomobili/vaz_lada/2114_samara?radius=200&s_trg=13
//https://www.avito.ru/astrahanskaya_oblast/avtomobili/vaz_lada/2114_samara?s_trg=4&f=188_901b
$site = 'https://www.avito.ru';
$region = ['astrahan', 'saratovskaya_oblast', 'samarskaya_oblast', 'penzenskaya_oblast'];
//$region = 'astrahan';
//$region = 'saratovskaya_oblast';
//$region = 'samarskaya_oblast';
//$region = 'penzenskaya_oblast';

$category = 'avtomobili';
$name_search = 'vaz_lada/2114_samara?p=1&radius=200';
foreach($region  as $reg){
$vaz = $site.'/'.$reg.'/'.$category.'/'.$name_search;
avito_parser_auto($vaz);
}
/*$avto_link = $site.'/'.$region.'/'.$category.'/'.vaz_2114_samara_2009_1713497498'
$model_avto= 'vaz_2114_samara_';*/
//$a = 'https://m.avito.ru/liman/avtomobili/vaz_2114_samara_2009_1274909156';
//$jsovn = find_data_avto(file_get_contents($a));
//$w = derban_json($jsovn);

?>
