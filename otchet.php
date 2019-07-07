<?php
require_once 'lib/function.php';
#ВАЗ 2114 Samara%
//951
$model='ВАЗ 2114 Samara%';
echo "<table>";
echo "astrahan";
   //астраханская
$reg=['Astrakhan' => '623110',
      'Saratov' => '653420',
      'Samara' => '652560',
      'Penza' =>'643250'];
echo "<table>";
for($year = 2000; $year<2020; $year++){
      echo "<th>".$year."</th>";
      echo "<tr> <td>Город</td>
                  <td>Средняя</td>
                  <td>Смотрю</td>
                  <td>Минимальная</td>
                  <td>Максимальная</td>
                  <td>Количество объявлений</td>";

    foreach ($reg as $sity => $id_region) {
      // code...
      $otc = otchet($id_region, $model, $year);
        if($id_region =='623110'){
          $med_astr=(integer)$otc['medium']-10000;
        }

      ?>


  <tr> <td><?php echo $sity ?></td>
  <td <?php
  if(($med_astr) > (integer)$otc['medium'])
  { echo 'bgcolor ="green"';}?>>
   <?php echo (integer)$otc['medium'] ?></td>
   <td> <?php echo $med_astr ?></td>
      <td> <?php echo $otc['min'] ?></td>
      <td><?php echo $otc['max'] ?> </td>
      <td><?php echo $otc['count'] ?> </td>
  </tr>



<?php
      }
        $med_astr=0;
  }

//var_dump($astr);
/*echo "Saratov";
otchet('653420');
echo "Самара";
otchet('652560');
echo "Пенза";
otchet('623110');*/
echo "</table>" ?>
