<?php
function content_backup($db) {
    //Получаем тайтл меню.
    $id_menu = '3';
    $query = mysqli_query($db, "SELECT title FROM menu WHERE id = '$id_menu' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
    $result['title'] = $userdata['title'];
    if(isset($_POST['backup_ok'])) {
        echo 'Oki';
    }
    // Подключаемся к базе
    $xtpl = new XTemplate('./tpl/backup.xtpl');
    $Query = mysqli_query($db, 'SELECT * FROM solo_ak_stats ORDER BY id DESC');
    while ($row = mysqli_fetch_assoc($Query)) {
        $xtpl->assign('data', $row);
        $xtpl->parse('backup.row');
    }
    $xtpl->parse('backup');
    $result['content'] = $xtpl->text('backup');
    return $result;

}
?>
