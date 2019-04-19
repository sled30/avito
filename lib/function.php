<?php
require_once 'db.php';
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
      if($i > 3) break;
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
  //АДРЕС!!!!
  //serrialise_address($w->item->item->refs->locations);
  // ГОРОД УЛИЦА
  //var_dump($w->item->item->address);
  //var_dump($connect);
  $address = $w->item->item->address;
  $sel_addr= "select idaddress from address where street = '$address'";
  $ins_addr = "insert into address(street) value('$address')";
  ///$id_address = dbrequest($sel_addr, $ins_addr);
  //ОБЩАЯ ИНФА ПО МАШИНЕ
  $title = $w->item->item->title;
  $sel_title= "select idtitle from title where title = '$title'";
  $ins_title = "insert into title(title) value('$title')";
/////////////////////////////////////////////////////////  !!!!!!!!!!!!!!!!!!!!!!!//$id_title = dbrequest($sel_title, $ins_title);
//  var_dump($id_title);
  // дата создания объявления
  $time = $w->item->item->time; //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!идет в общей внимание!!!!!!!!!!!!!!!!!!!!!
  //$sel_time =
  //var_dump(date('l jS \of F Y h:i:s A', $w->item->item->time));
  //описание продавца
  ///////////////////var_dump($w->item->item->description);
  // данные машины
  $parametr = serrialise_param_avto($w->item->item->parameters);
  var_dump($parametr);
  //
//  serrialise_picture($w->item->item->images);

    //var_dump($w->item->item->images);
    //var_dump($w->item->item->price->value);
    // а вот нужен мне владелец или нет???????
    //в хер не уперся
    //var_dump($w->item->item->seller);
    //статистика сегодня
    //var_dump($w->item->item->stats->views->today);
    //статистика всего
    //var_dump($w->item->item->stats->views->total);
    //var_dump($w->item->item->contacts->list[0]->value->uri);
    // телефон
  //  echo serrialise_phone($w->item->item->contacts->list[0]->value->uri);
  }
function serrialise_phone($src_phone){
  // code...
  $phone = explode('=%2B', $src_phone);
  return $phone[1];
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
  /*$test = ["category",
            "owners",
            "type_avto",
            "doors",
            "power",
            "type_power",
            "run",
            "color",
            "drive",
            "rule",
            "good",
            "vin"];*/
  foreach ($parameters->flat as $value) {
      $title1 = name_param($value->title);
      $title[$title1] = $value->description;

    }
  //var_dump($title);
//  $title['run'] = (int)$title['run'];
$title['run'] = str_replace(" ","", $title['run']);

     $sel_param = "select id from parametr_auto
              where category = '$title[category]' and owners = '$title[owners]'
              and type_avto = '$title[type_avto]' and doors = '$title[doors]'
              and power ='$title[power]' and type_power = '$title[type_power]'
              and run = '$title[run]' and color = '$title[color]'
              and drive = '$title[drive]' and rulel = '$title[rule]' and good = '$title[good]'
              and vin = '$title[vin]'";
      $ins_param = "insert into parametr_auto(category, owners, type_avto, doors, power, type_power,
                run, color, drive, rulel, good, vin) value
                ('$title[category]', '$title[owners]', '$title[type_avto]', '$title[doors]', '$title[power]', '$title[type_power]',
                 '$title[run]', '$title[color]', '$title[drive]', '$title[rule]', '$title[good]', '$title[vin]')";

      return dbrequest($sel_param, $ins_param);
}
function serrialise_address($address){
  // code...
  $add = (array)$address;
   foreach ($add as $key => $name){
     // code...
     $name_arr = (array)$name;
     if(array_key_exists('parentId', $name_arr)){
       $sity_name=$name_arr['name'];
       $parentID= $name_arr['parentId'];
        }
       else{
       $region = $name_arr['name'];
        }
   }
  $sel_loca = "select idlocation from location where idsity='$parentID'
   and rejion= '$region' and sity='$sity_name'";
   $ins_loca = "insert into location (idsity, rejion, sity) value ('$parentID', '$region', '$sity_name')";
  //echo $ins_loca;
    ////// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    /////!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!   воткнуть обработчик который будет сохранять в базе и возвращать ид строки
    ///// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     return compact('sity_name', 'parentID', 'region');
     }
/*сохраняем в базу*/
function dbrequest($sqlrequest, $sqlinsert){

  //var_dump($connect);
  //echo $sqlrequest;

  $connect= mysqli_connect(DBHOST, DBUSER, DBPASWD, DBNAME);
     if(!$connect){
       echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
       echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
       echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
       exit;
     }
  $db_quest=mysqli_query($connect, $sqlrequest);
    if(is_bool($db_quest)){
  //  var_dump($sqlrequest);
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
