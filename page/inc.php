<?php
function content_inc($db){
    if(isset($_SESSION['USER_LOGIN_IN'])&&($_SESSION['USER_LOGIN'])&&($_SESSION['USER_PASSWORD'])) {
        if($_SESSION['USER_LOGIN_IN'] = 1) {
            if (isset($_POST['text']) && ($_POST['user']) && ($_FILES['uploadfile']['name']) != '') {
                $uploaddir = './files/';
                $uploadfile = $uploaddir . basename($_FILES['uploadfile']['name']);
                copy($_FILES['uploadfile']['tmp_name'], $uploadfile);
                //Вставляем данные, подставляя их в запрос
                $query = "INSERT INTO messages (text, user, filename) VALUES ('" . $_POST['text'] . "' , '" . $_POST['user'] . "' , '$uploaddir" . $_FILES['uploadfile']['name'] . "')";
                $result = mysqli_query($db, $query);
                // Задаем выходной массив
                $result_ok['title'] = 'Ввод';
                $result_ok['content'] = 'Запись и файл добавлены!';
                return $result_ok;
            } elseif (isset($_POST['text']) && ($_POST['user'])) {
                //Вставляем данные, подставляя их в запрос
                $query = "INSERT INTO messages (text, user) VALUES ('" . $_POST['text'] . "' , '" . $_POST['user'] . "')";
                $result = mysqli_query($db, $query);
                // Задаем выходной массив
                $result_ok['title'] = 'Ввод';
                $result_ok['content'] = 'Запись добавлена!';
                return $result_ok;
            } else {
                // Задаем выходной массив
                $result_inc['title'] = 'Ввод';
                // Подключаем файл шаблона
                $xtpl_inc = new XTemplate('./tpl/inc.xtpl');
                $xtpl_inc->assign('article', 'Название материала');
                $xtpl_inc->parse('inc');
                $result_inc['content'] = $xtpl_inc->text('inc');
                return $result_inc;
            }
        }
    }
    else {
        $result_inc['title'] = 'Ввод';
        $result_inc['content'] = 'Выполните вход!!';
        return $result_inc;
    }
}
?>
