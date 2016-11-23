<?php
function content_tel($db){
    $id_menu = '8';
    $query = mysqli_query($db, "SELECT title FROM menu WHERE id = '$id_menu' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
    $result['title'] = $userdata['title'];

    // Задаем выходной массив

    // Подключаемся к базе
    $xtpl = new XTemplate('./tpl/tel.xtpl');
    $xtpl->assign('tel');
    $xtpl->parse('tel');
    $result['content'] = $xtpl->text('tel');

    return $result;
}
?>