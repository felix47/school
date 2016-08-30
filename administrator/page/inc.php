<?php
function content_inc($db){
    $result_inc['title'] = 'Добавить материал';
            if(isset($_POST['title']) && ($_POST['text']) && ($_POST['user']) && ($_FILES['uploadfile']['name']) != '') {
                $uploaddir = '../files/';
                $uploadfile = $uploaddir . basename($_FILES['uploadfile']['name']);
                copy($_FILES['uploadfile']['tmp_name'], $uploadfile);
                //Вставляем данные, подставляя их в запрос
                $query = "INSERT INTO content (title, text, user, filename, filetitle) VALUES ('" . $_POST['title'] . "' , '" . $_POST['text'] . "' , '" . $_POST['user'] . "' , '$uploaddir" . $_FILES['uploadfile']['name'] . "' ,'" . $_POST['filetitle'] . "' )";
                $result = mysqli_query($db, $query);
                $result_id = mysqli_query($db, 'SELECT id FROM content ORDER BY id DESC LIMIT 1;');
                $row = mysqli_fetch_array($result_id);
                $query_file = "INSERT INTO content_files ( id_content, file_name, file_link, file_title, date_upload) VALUES ('$row[id] ' , '$uploaddir" . $_FILES['name'] . "' , '$uploaddir" . $_FILES['uploadfile']['name'] . "' , '" . $_POST['filetitle'] . "' , NOW())";
                $result_file = mysqli_query($db, $query_file);
                // Задаем выходной массив
                $result_ok['content'] = 'Запись и файл добавлены!';
                return $result_ok;
            }
            elseif(isset($_POST['title']) && ($_POST['text']) && ($_POST['user'])) {
                //Вставляем данные, подставляя их в запрос
                $query = "INSERT INTO content (title, text, user) VALUES ('" . $_POST['title'] . "' , '" . $_POST['text'] . "' , '" . $_POST['user'] . "')";
                $result = mysqli_query($db, $query);
                // Задаем выходной массив
                $xtpl = new XTemplate('./tpl/table.xtpl');
                $Query = mysqli_query($db, 'SELECT * FROM content');
                while($row = mysqli_fetch_assoc($Query)) {
                    $xtpl->assign('data', $row);
                    $xtpl->parse('table.row.del');
                    $xtpl->parse('table.row');
                }
                $xtpl->parse('table.notify');
                $xtpl->parse('table');
                $result_inc['content'] = $xtpl->text('table');
                $_SESSION['flash'] = 'Запись добавлена';
                header("Location: /administrator/content");
            }
            else{
                // Задаем выходной массив
                // Подключаем файл шаблона
                $xtpl_inc = new XTemplate('./tpl/inc.xtpl');
                $xtpl_inc->assign('article', 'Название материала');
                $xtpl_inc->parse('inc');
                $result_inc['content'] = $xtpl_inc->text('inc');
                return $result_inc;
            }
    return $result_inc;
}
?>
