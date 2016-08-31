<?php
error_reporting(E_ALL);
session_start();
include_once('../configuration.php');
include_once('../libs/xtemplate.class.php');

// Убрать слэш в URL
$uri = preg_replace("/\?.*/i", '', $_SERVER['REQUEST_URI']);
if ((!strpos($uri, 'administrator')) && (strlen($uri) > 1)) {
    if (rtrim($uri, '/') != $uri) {
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: http://' . $_SERVER['SERVER_NAME'] . str_replace($uri, rtrim($uri, '/'), $_SERVER['REQUEST_URI']));
        exit();
    }
}

// Задаем переменной шаблон контента
$xtpl = new XTemplate('./tpl/content.xtpl');

// Задаем переменной данные для подключения к БД
$db = mysqli_connect(HOST, USER, PASS, DB);
mysqli_query($db, 'SET NAMES UTF8');

// Тут начинается непонятная хуйня
$Page = isset($_REQUEST['mod']) ? $_REQUEST['mod'] : 'index';

if ($Page == 'index') {
    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
        $query = mysqli_query($db, "SELECT * FROM users WHERE id = '" . intval($_COOKIE['id']) . "' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        if (($userdata['hash'] == $_COOKIE['hash']) and ($userdata['id'] == $_COOKIE['id'])) {
            setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
            setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");

            // Подключаем модуль меню
            include_once('./modules/menu.php');
            // Передаем в шаблон контента содержимое меню
            $xtpl->assign('menu', menu($db));
            include_once('./page/administrator_home.php');
            $func = 'content_administrator';
            $data = $func($db);
            $xtpl->assign('title', $data['title']);
            $xtpl->assign('messages', $data['content']);
        } elseif (($userdata['hash'] !== $_COOKIE['hash']) or ($userdata['id'] !== $_COOKIE['id'])) {
            include_once('./page/administrator_login.php');
            $func = 'content_administrator_login';
            $data = $func($db);
            $xtpl->assign('title', $data['title']);
            $xtpl->assign('messages', $data['content']);
        }
    } else {
        include_once('./page/administrator_login.php');
        $func = 'content_administrator_login';
        $data = $func($db);
        $xtpl->assign('title', $data['title']);
        $xtpl->assign('messages', $data['content']);
    }
}
elseif($Page == 'documents' . $Page ){
    echo 'hello';
}
else {
    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
        $query = mysqli_query($db, "SELECT * FROM users WHERE id = '" . intval($_COOKIE['id']) . "' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        if (($userdata['hash'] == $_COOKIE['hash']) and ($userdata['id'] == $_COOKIE['id'])) {
            setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
            setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");

            // Подключаем модуль меню
            include_once('./modules/menu.php');
            // Передаем в шаблон контента содержимое меню
            $xtpl->assign('menu', menu($db));

            include_once('./page/' . $Page . '.php');

            // Формирование имени функции
            $func = 'content_' . $Page;
            // Переменной задается имя функции
            $data = $func($db);
            $xtpl->assign('title', $data['title']);
            $xtpl->assign('messages', $data['content']);
        } else {
            $resultlogin['content'] = 'Требуется авторизация';
        }
    } else {
        include_once('./page/administrator_login.php');
        $func = 'content_administrator_login';
        $data = $func($db);
        $data['content'] = '1';
        $xtpl->assign('title', $data['title']);
        $xtpl->assign('messages', $data['content']);
        header("Location: /administrator/");
    }
}
// Тут эта непонятная хуйня заканчивается


// Подготавливаем контент
$xtpl->parse('content');

// Вывод шаблона
$xtpl->out('content');

?>

<?php
// Скрипт добавления класса к активному пункту меню
?>
<script type="text/javascript">

    $(document).ready(function () {
        $(".nav .nav_link").each(function (i) {
            if (this.href == document.location.href) {
                $(this).parent('').addClass('active');
            }
        });
    });
</script>
<?php
// скрипт добавления нового инпута при  нажатии кнопки
?>
<script type="text/javascript">
    var i = 2;
    function ff() {
        document.getElementById('form_inner').innerHTML = document.getElementById('form_inner').innerHTML +
            "<div class='row'><div class='col-lg-6'><input class='form-control' placeholder='Название ссылки на файл' type='text' name='input_no_" + i + "' /></div><div class='col-lg-6'><input type='file' id='exampleInputFileAdd' name='uploadfile_" + i + "'></div></div><br />";

        i++;
    }
</script>
