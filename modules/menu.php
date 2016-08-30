
<?php

function menu($db){

// Подключаем файл шаблона
    $xtpl_menu = new XTemplate('./tpl/menu.xtpl');
    $Query = mysqli_query($db, 'SELECT * FROM menu WHERE active="1" ORDER BY sort ASC');
    while ($row = mysqli_fetch_assoc($Query)) {
        $xtpl_menu->assign('menu_link', $row);
        $xtpl_menu->assign('menu_name', $row);
        $xtpl_menu->parse('menu.menu_list');
    }
// Подготавливаем шаблон с учетом переданных переменных и блоков
    $xtpl_menu->parse('menu');
    $result_menu = $xtpl_menu->text('menu');
    return $result_menu;
}
?>

