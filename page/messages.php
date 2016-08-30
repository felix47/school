<?php
function content_messages($db){
    // Задаем выходной массив
    // Проверка на запрос удаления!
    if (isset($_POST['delete'])){
        if(isset($_SESSION['USER_LOGIN_IN'])) {
            if ($_SESSION['USER_LOGIN_IN'] = 1) {
                $Query = "DELETE FROM `content` WHERE (`id`=" . $_POST['delete'] . ");";
                $results = mysqli_query($db, $Query);
                $xtpl = new XTemplate('./tpl/table.xtpl');
                $Query = mysqli_query($db, 'SELECT * FROM content');
                while ($row = mysqli_fetch_assoc($Query)) {
                    $xtpl->assign('data', $row);
                    $xtpl->parse('table.row.del');
                    $xtpl->parse('table.row');
                }
                $xtpl->parse('table');
                $result['content'] = $xtpl->text('table');
            }
            else {
                $result['content'] = 'Действие запрещено!';
            }
        }
    }
    else {
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
    }
    return $result;
}
/* V2
function content_messages($db){
    // Задаем выходной массив
    $result['title']='Messages';
    // Проверка на запрос удаления!
    if (isset($_POST['delete'])){
        $Query = "DELETE FROM `messages` WHERE (`id`=".$_POST['delete'].");";
        $results = mysqli_query($db , $Query);
        $xtpl = new XTemplate('./tpl/table.xtpl');
        $Query = mysqli_query($db, 'SELECT * FROM messages');
        while ($row = mysqli_fetch_assoc($Query)) {
            $xtpl->assign('data', $row);
            $xtpl->parse('table.row.del');
            $xtpl->parse('table.row');
        }
        $xtpl->parse('table');
        $result['content'] = $xtpl->text('table');
    }
    else {
        // Подключаемся к базе
        $xtpl = new XTemplate('./tpl/table.xtpl');
        $Query = mysqli_query($db, 'SELECT * FROM messages');
        while ($row = mysqli_fetch_assoc($Query)) {
            $xtpl->assign('data', $row);
            $xtpl->parse('table.row.del');
            $xtpl->parse('table.row');
        }
        $xtpl->parse('table');
        $result['content'] = $xtpl->text('table');
    }
    return $result;
}
*/
/*
function content_messages($db){
    // Задаем выходной массив
    $result['title']='Messages';
    if (isset($_GET['delete'])){
        $Query = mysql_query($db, 'DELETE FROM `messages` WHERE `id` = "'.$_GET['delete'].'"');
        if ($Query) {
            $result['content'] = "<p>удален.</p>";
        } else {
            $result['content'] = "<p>ошибка.</p>";
        }
        return $result;
    }
    else {
        // Подключаемся к базе
        $xtpl = new XTemplate('./tpl/table.xtpl');
        $Query = mysqli_query($db, 'SELECT * FROM messages');
        while ($row = mysqli_fetch_assoc($Query)) {
            $xtpl->assign('data', $row);
            $xtpl->parse('table.row');

        }
        $xtpl->parse('table');
        $result['content'] = $xtpl->text('table');

        return $result;
    }
}
*/
?>