<?php
error_reporting(E_ALL);
session_start();
include_once ('configuration.php');


// Задаем переменной данные для подключения к БД
$db = mysqli_connect(HOST, USER, PASS, DB);
mysqli_query($db,'SET NAMES UTF8');

//Выбираем данные из БД
$result = mysqli_query($db, "SELECT * FROM  categories");
//Если в базе данных есть записи, формируем массив
$a = mysqli_num_rows($result);
echo $a;
if (mysqli_num_rows($result) > 0){
    $category = array();
//В цикле формируем массив разделов, ключом будет id родительской категории, а также массив разделов, ключом будет id категории
    while($cat =  mysqli_fetch_assoc($result)){
        $category_ID[$cat['id']][] = $cat;
        $category[$cat['parent_id']][$cat['id']] =  $cat;
    }
}
function build_tree($category,$parent_id,$only_parent = false){
    if(is_array($category) and isset($category[$parent_id])){
        $tree = '<ul>';
        if($only_parent==false){
            foreach($category[$parent_id] as $cat){
                $tree .= '<li>'.$cat['name'].' #'.$cat['id'];
                $tree .=  build_tree($category,$cat['id']);
                $tree .= '</li>';
            }
        }elseif(is_numeric($only_parent)){
            $cat = $category[$parent_id][$only_parent];
            $tree .= '<li>'.$cat['name'].' #'.$cat['id'];
            $tree .=  build_tree($category,$cat['id']);
            $tree .= '</li>';
        }
        $tree .= '</ul>';
    }
    else return null;
    return $tree;
}
echo build_tree($category,0);

$people = array (
    array (
        "Имя" => "Бобров Иван Павлович",
        "Лет" => 37,
        "Пол" => "Муж",
        "Образование" => "Высшее"
    ),
    array (
        "Имя" => "Зайцев Евгений Петрович",
        "Лет" => 25,
        "Пол" => "Муж",
        "Образование" => "Высшее"
    ),
    array (
        "Имя" => "Петренко Алена Ивановна",
        "Лет" => 19,
        "Пол" => "Жен",
        "Образование" => "Среднее"
    )
);
print_r($people);
// Вывод
echo '<table border=1 cellpadding=5 style=\'border-collapse:collapse;\'>';
$tmp = array_keys($people[0]);
echo '<br>';
print_r($tmp);
foreach ($tmp as $key)
    echo '<th>'.$key.'</th>';
foreach($people as $person) {
    echo '<tr>';
    foreach($person as $key => $value)
        echo '<td>'.$value.'</td>';
    echo '</tr>';
}
echo '</table>';
echo '<br>';

$movies = array(
    array(
        "title" => "Rear Window",
        "director" => "Alfred Hitchcock",
        "year" => 1954
    ),
    array(
        "title" => "Full Metal Jacket",
        "director" => "Stanley Kubrick",
        "year" => 1987
    ),
    array(
        "title" => "Mean Streets",
        "director" => "Martin Scorsese",
        "year" => 1973
    )
);
echo "Название первого фильма:<br />";
echo $movies[0]["title"] . "<br /><br />";

echo "Режисер третьего фильма:<br />";
echo $movies[2]["director"] . "<br /><br />";

echo "Вложенный массив, который содержится в первом элементе:<br />";
print_r($movies[1] );
echo "<br /><br />";


$code = array('Moscow' => '495', 'SPb' => '812', 'Chelyaba' => '351');
foreach($code as $key=>$val){
    echo $key . '-' . $val.'<br>';
}

?>