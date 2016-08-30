<?php
function content_content($db){
    //Вывод тайтла из БД
    $id_menu = '2';
    $query = mysqli_query($db, "SELECT title FROM menu_admin WHERE id = '$id_menu' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
    $result['title'] = $userdata['title'];

    // Проверка на запрос удаления!
    if(isset($_POST['delete'])){
        $Query = "DELETE FROM `content` WHERE (`id`=" . $_POST['delete'] . ");";
        $results = mysqli_query($db, $Query);
        $xtpl = new XTemplate('./tpl/table.xtpl');
        $Query = mysqli_query($db, 'SELECT * FROM content ORDER BY id DESC');
        while ($row = mysqli_fetch_assoc($Query)) {
            $xtpl->assign('data', $row);
            $xtpl->parse('table.row.del');
            $xtpl->parse('table.row');
        }
        $xtpl->parse('table');
        $result['content'] = $xtpl->text('table');
        // обновление страницы
        $_SESSION['flash'] = 'Запись удалена';
        header("Location: ".$_SERVER['REQUEST_URI']);
    }
    else {
        if(!empty($_SESSION['flash']))
        {
            // unset($_SESSION['flash']);
            // Подключаемся к базе
            $xtpl = new XTemplate('./tpl/table.xtpl');
            $Query = mysqli_query($db, 'SELECT * FROM content ORDER BY id DESC');
            while ($row = mysqli_fetch_assoc($Query)){
                $xtpl->assign('data', $row);
                $xtpl->parse('table.row.del');
                $xtpl->parse('table.row');
            }
            $xtpl->assign('notify_cont', $_SESSION['flash']);
            $xtpl->parse('table.notify');
            unset($_SESSION['flash']);
            $xtpl->parse('table');
            $result['content'] = $xtpl->text('table');
        }
        elseif(isset($_POST['updateContent']) && ($_POST['updateId'])){
            // Подключаемся к базе
            $Query = "UPDATE content SET text='" . $_POST['updateContent'] . "' WHERE id='" . $_POST['updateId'] . "'";
            $results = mysqli_query($db, $Query);
            $xtpl = new XTemplate('./tpl/table.xtpl');
            $Query = mysqli_query($db, 'SELECT * FROM content ORDER BY id DESC');
            while ($row = mysqli_fetch_assoc($Query)) {
                $xtpl->assign('data', $row);
                $xtpl->parse('table.row.del');
                $xtpl->parse('table.row');
            }
            $xtpl->parse('table');
            $result['content'] = $xtpl->text('table');
            $_SESSION['flash'] = 'Запись обновлена';
            header("Location: ".$_SERVER['REQUEST_URI']);
        }
        else {
            // Подключаемся к базе
            $xtpl = new XTemplate('./tpl/table.xtpl');
            //$Query = mysqli_query($db, 'SELECT * FROM content ORDER BY id DESC');
            $Query = mysqli_query($db, 'SELECT * FROM content LEFT JOIN content_files USING (id) ORDER BY id DESC;');
            while ($row = mysqli_fetch_assoc($Query)) {
                $xtpl->assign('data', $row);
                $xtpl->parse('table.row.del');
                $xtpl->parse('table.row');
            }
            $xtpl->parse('table');
            $result['content'] = $xtpl->text('table');
        }
    }
    return $result;
}
?>
