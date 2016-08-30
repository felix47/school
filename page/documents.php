<?php
function content_documents($db){
    $id_menu = '7';
    $query = mysqli_query($db, "SELECT title FROM menu WHERE id = '$id_menu' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
    $result['title'] = $userdata['title'];

    // Задаем выходной массив

        // Подключаемся к базе
        $xtpl = new XTemplate('./tpl/table.xtpl');
        $Query = mysqli_query($db, 'SELECT * FROM content');
        if(isset($_SESSION['USER_LOGIN_IN'])&&($_SESSION['USER_LOGIN'])&&($_SESSION['USER_PASSWORD'])) {
            if($_SESSION['USER_LOGIN_IN'] =1) {
                while ($row = mysqli_fetch_assoc($Query)) {
                    $xtpl->assign('data', $row);
                    $xtpl->parse('table.row.del');
                    $xtpl->parse('table.row');
                }
            }
        }
        else {
            while ($row = mysqli_fetch_assoc($Query)) {
                $xtpl->assign('data', $row);
                $xtpl->parse('table.row');
            }
        }
        $xtpl->parse('table');
        $result['content'] = $xtpl->text('table');

    return $result;
}
?>