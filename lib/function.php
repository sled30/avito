<?php
// avito_parser_auto->pars_find->pars_car->->--->
//   ->

function avito_parser_auto($url){
  // code...
$url_finde_page = pars_find($url);
pars_car($url_finde_page);

//var_dump($url_finde_page);

}

/* принимает массив от парсинга поиска и заходит в объявление*/
function pars_car($array_link){
  //var_dump($array_link);
  $i = 0;
  foreach ($array_link[1] as $link){
      // code...
      $i++;
      $work_link = 'https://m.avito.ru'.$link;
      $ad = file_get_contents($work_link);
    //  print_r($ad);
            //                                                          ограничение на Количество итераций!!!!!!!!!!!!!!!!!!!
      if($i > 1) break;
      //$w = derban_json($ad);
      //print_r($w);
      $obj_auto = find_data_avto($ad);
      var_dump(derban_json($obj_auto));

  }
  //var_dump($ad);
}
/* принимает урл поиска и дергает линки объявлений*/
function pars_find($url_name){
  $test=file_get_contents($url_name);
  $match = '/itemprop="url"
 href=\"(.{3,})\"/';
  preg_match_all($match, $test, $text);
  //var_dump($text);
   return $text;

}
  /*получаем страницу для парсинга возвращаем данные в jsovn для работы */
function find_data_avto($data){
  // code...
  $match = '/<script type="text\/javascript">window\.__initialData__ = (.*) \|| \{\}<\/script><noscript>/';
  preg_match_all($match, $data, $data_in_avto);
  return $data_in_avto[1][0];
}
/*разбираем json для сохранения или сразу сохраняем пока не знаю*/
function derban_json($data_in_avto){
  $obj_avto = json_decode($data_in_avto);
  return $obj_avto;
}
