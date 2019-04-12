<?php
// avito_parser_auto->pars_find->pars_car->->--->
//   ->

function avito_parser_auto($url){
  // code...
  $url_finde_page = pars_find($url);
  pars_car($url_finde_page);
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
      derban_json($obj_auto);

  }
}
/* принимает урл поиска и дергает линки объявлений*/
function pars_find($url_name){
  $test=file_get_contents($url_name);
  $match = '/itemprop="url"
 href=\"(.{3,})\"/';
  preg_match_all($match, $test, $text);
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
  $w = json_decode($data_in_avto);
  //var_dump((array)$w->item->item->refs->locations);
  //АДРЕС!!!!
  //serrialise_address($w->item->item->refs->locations);
  // ГОРОД УЛИЦА
  //var_dump($w->item->item->address);
  //ОБЩАЯ ИНФА ПО МАШИНЕ
  //var_dump($w->item->item->title);
  // дата создания объявления
  //var_dump(date('l jS \of F Y h:i:s A', $w->item->item->time));
  //описание продавца
  //var_dump($w->item->item->description);
  // данные машины
  //serrialise_param_avto($w->item->item->parameters);
  //var_dump($w->item->item->parameters);
  //
  //serrialise_picture($w->item->item->images);

//var_dump($w->item->item->images);
//var_dump($w->item->item->price->value);
// а вот нужен мне владелец или нет???????
//var_dump($w->item->item->seller);
//статистика сегодня
var_dump($w->item->item->stats->views->today);
//статистика всего
var_dump($w->item->item->stats->views->total);
  }
function serrialise_picture($image){
  // code...
  foreach ($image as $value){
    // code...
    var_dump((array)$value);
    foreach ($value as $key => $pictures){
      // code...
      var_dump($key);
      echo "\n";
      var_dump($pictures);
      echo "\n";
    }
  }

}
function name_param($array){
  // code...
  switch ($array){
    case 'Категория':
      // code...
      $answer = 'category';
      return $answer;
        break;
    case 'Владельцев по ПТС':
        // code...
        $answer = 'owners';
        return $answer;
        break;
    case 'Тип автомобиля':
            // code...
            $answer = 'type_avto';
            return $answer;
            break;
    case 'Количество дверей':
                    // code...
             $answer = 'doors';
            return $answer;
            break;
    case 'Мощность двигателя, л.с.':
          $answer = 'power';
          return $answer;
          break;
    case 'Тип двигателя':
          $answer = 'type_power';
          return $answer;
          break;
    case 'Пробег, км':
          $answer = 'run';
          return $answer;
          break;
    case 'Цвет':
          $answer = 'color';
          return $answer;
          break;
    case 'Привод':
          $answer = 'drive';
          return $answer;
          break;
    case 'Руль':
          $answer = 'rule';
          return $answer;
          break;
    case 'Состояние':
          $answer = 'good';
          return $answer;
          break;
    case 'VIN или номер кузова':
          $answer = 'vin';
          return $answer;
          break;
   default:
      // code...
      $answer ='fuck';
      var_dump($array);
      break;
  }
}
//получаем объекты машины и выбираем что нужно
function serrialise_param_avto($parameters){

  //var_dump($parameters->flat);
  foreach ($parameters->flat as $value) {
    // code...
  //  var_dump((array)$value);
    echo name_param($value->title);
    echo "\n";
    echo $value->description;
    echo "\n";
  }

}
function serrialise_address($address){
  // code...
  $add = (array)$address;
   foreach ($add as $key => $name){
     // code...
     $name_arr = (array)$name;
     //echo $name_arr['name'];
    // var_dump($key);
     //var_dump((array)$name);
     if(array_key_exists('parentId', $name_arr)){
       echo "nhtkkf".$name_arr['parentId'];
       echo "rejion". $key;
       }
       else{
         echo "id города ".$key . " bvz ". $name_arr['name']."\n";
        // echo $name_arr['name'];
       }
   }
  //var_dump($add);

}
/*сохраняем в базу*/
function dbrequest($sqlrequest, $sqlinsert, $connect){
  //var_dump($connect);
  //echo $sqlrequest;
  $db_quest=mysqli_query($connect, $sqlrequest);
  if(is_bool($db_quest)){
    var_dump($sqlrequest);
  }
  $id_request=mysqli_fetch_assoc($db_quest);
  $request=$id_request['id'];
  if(!$request){
    mysqli_query($connect, $sqlinsert);
    $request=mysqli_insert_id($connect);
  }
  mysqli_close($connect);
  return $request;
}
