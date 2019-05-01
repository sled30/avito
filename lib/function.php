<?php
require_once 'db.php';
function avito_parser_auto($url){
  // code...
  $url_finde_page = pars_find($url);
  pars_car($url_finde_page);
}
/* принимает массив от парсинга поиска и заходит в объявление*/
function pars_car($array_link){
  //var_dump($array_link);
  //$i = 0;
  foreach ($array_link[1] as $link){
      // code...
    //  $i++;
      $work_link = 'https://m.avito.ru'.$link;
      $ad = file_get_contents($work_link);
    //  print_r($ad);
            //                                                          ограничение на Количество итераций!!!!!!!!!!!!!!!!!!!
    //  if($i > 4) break;
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
  $location = serrialise_address($w->item->item->refs->locations);
  $id_order = $w->item->item->id;
  $address = $w->item->item->address;
  $sel_addr= "select id from address where street = '$address'";
  $ins_addr = "insert into address(street) value('$address')";
  $id_address = dbrequest($sel_addr, $ins_addr);
  $title = $w->item->item->title;
  $sel_title= "select id from title where title = '$title'";
  $ins_title = "insert into title(title) value('$title')";

  $id_title = dbrequest($sel_title, $ins_title);
  $time = $w->item->item->time;
  //var_dump(date('l jS \of F Y h:i:s A', $w->item->item->time));
  $description = $w->item->item->description;
  $parametr = serrialise_param_avto($w->item->item->parameters);
  /////////////////////////////////////////////////////////////////////////////////   временно выключить!!!!!serrialise_picture($w->item->item->images, $id_order);
  $price = str_replace(" ", "", $w->item->item->price->value);
  $seller = $w->item->item->seller->name;

    //статистика сегодня
    //var_dump($w->item->item->stats->views->today);
    $today = $w->item->item->stats->views->today;
    //статистика всего
    //  var_dump($w->item->item->stats->views->total);
    $total = $w->item->item->stats->views->total;
    //var_dump($w->item->item->contacts->list[0]->value->uri);
    // телефон
   $phone = serrialise_phone($w->item->item->contacts->list[0]->value->uri);
   $sel_order = "select id from bye where create_date = '$time' and phone = '$phone' and address = '$id_address' and   id_order = '$id_order' and location = '$location'
   and id_title = '$id_title' and parametr_auto = '$parametr' and price = '$price' and seler = '$seller'";
   $ins_order = "insert into bye(create_date, phone, address, id_order, location, id_title, parametr_auto, price, description, seler) value('$time', '$phone', '$id_address', '$id_order', '$location',
    '$id_title', '$parametr', '$price', '$description', '$seller')";
    dbrequest($sel_order, $ins_order);
  // echo $sel_order;
   }
function serrialise_phone($src_phone){
  // code...
  $phone = explode('=%2B', $src_phone);
  return $phone[1];
}
function serrialise_picture($image, $id_order){
  // code...
  foreach ($image as $value){
    // code...
    $value = (array)$value;
    $one = escape($value['100x75']); //
    $too = escape($value['140x105']);
    $second = escape($value['240x180']);
    $three = escape($value['432x324']);
    $foo = escape($value['640x480']);
    $sel_pict = "select id from pictures where 100 = '$one' and 140 = '$too'
    and 240 = '$second' and 432 = '$three' and 640 = '$foo' and id_order = '$id_order'";

    $ins_pict = "insert into pictures(one, too, second, three, foo, id_order) values('$one', '$too',
    '$second', '$three', '$foo', '$id_order')";
    dbrequest($sel_pict, $ins_pict);
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
   case 'Мощность, л.с.':
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
      foreach ($parameters->flat as $value){
      $title1 = name_param($value->title);
      $title[$title1] = $value->description;
    }
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
  $sel_loca = "select id from location where idsity='$parentID'
   and rejion= '$region' and sity='$sity_name'";
   $ins_loca = "insert into location (idsity, rejion, sity) value ('$parentID', '$region', '$sity_name')";
  //echo $ins_loca;
    ////// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    /////!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!   воткнуть обработчик который будет сохранять в базе и возвращать ид строки
    ///// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     return dbrequest($sel_loca,$ins_loca);
     }
/*сохраняем в базу*/
function escape($sql){
  // code...
  $connect= mysqli_connect(DBHOST, DBUSER, DBPASWD, DBNAME);
     if(!$connect){
       echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
       echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
       echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
       exit;
     }
  return mysqli_real_escape_string($connect, $sql);
}
function dbrequest($sqlrequest, $sqlinsert){
  $connect= mysqli_connect(DBHOST, DBUSER, DBPASWD, DBNAME);
     // echo $sqlinsert;
     // echo "\n";
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
