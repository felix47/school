<?php
$arr[] = 'test1';
$arr[] = 'test2';
$arr[] = 'test3';

print_r($arr);
echo '<br />';
echo $arr[1].'<br />';
echo "<table border='1' cellpadding='5'>
      <tr><th>Имя</th></tr>";
foreach($arr as $key => $value){
    echo "$key - $value.'<br />";
}

echo "</table>";
echo "<hr>";

// Создание массива
$companies[0][] = "Programmer";
$companies[0][] = "PR";

$companies[1][] = "IT";
$companies[1][] = "Web-design";

$companies[2][] = "PR";
$companies[2][] = "C++ Programmer";

// Вывод массива на экран


echo "<table border='1' cellpadding='5'>
      <tr><th>Имя</th></tr>";
for($i = 0; $i < count($companies); $i++) {
    for($j = 0; $j < count($companies[$i]); $j++) {
        echo $companies[$i][$j], "<br />";
    }
}

echo "</table>";
echo "<hr>";



// массивы с данными на работников предприятия
$m = array('Александр','Новиков','35','ул. Новоясеневский проспект д. 7','125-89-63');
$s = array('Алексей','Бодров','28','ул. Астраханская д. 45','256-89-63');
$t = array('Николай','Хмельницкий','28','ул. Боровицкая д. 25','100-89-63');
$k = array('Олег','Нестеров','44','ул. Каховка д. 11','330-80-63');
$z = array('Олег','Нестеров','44','ул. Каховка д. 11','330-80-63');
$x = array('Олег','Нестеров','44','ул. Каховка д. 11','330-80-63');



// двумерный массив с данными о сотрудниках
$TH = array($m, $s, $t, $k, $z, $x);


// Подсчитываем количество элементов в массиве
$sum = count($TH);

echo "<table border='1' cellpadding='5'>
      <tr>
      <th>Имя</th><th>Фамилия</th><th>Возраст</th><th>Адрес</th><th>Телефон</th>
      </tr>";
for($i=0; $i <= $sum; $i++)
{
    echo "<tr>";
    $sum = count($TH[$i]);
    for($q=0; $q < $sum; $q++)
    {
        echo "<td>  ".$TH[$i][$q]."</td>";
    }
    echo "</tr>";
}

echo "</table>";
?>