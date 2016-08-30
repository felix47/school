<?php
error_reporting(E_ALL);
session_start();
include_once ('configuration.php');
include_once ('./libs/xtemplate.class.php');

// Убрать слэш в URL
$uri = preg_replace("/\?.*/i",'', $_SERVER['REQUEST_URI']);
if ((!strpos($uri, 'administrator'))  && (strlen($uri)>1)) {
    if (rtrim($uri,'/')!=$uri) {
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: http://'.$_SERVER['SERVER_NAME'].str_replace($uri, rtrim($uri,'/'), $_SERVER['REQUEST_URI']));
        exit();
    }
}

// Подключаем модуль меню
include_once ('./modules/menu.php');
// Подключаем модуль logo
include_once ('./modules/logo.php');

// Задаем переменной шаблон контента
$xtpl = new XTemplate('./tpl/content.xtpl');

// Задаем переменной данные для подключения к БД
$db = mysqli_connect(HOST, USER, PASS, DB);
mysqli_query($db,'SET NAMES UTF8');


// Тут начинается непонятная хуйня
$Page = isset($_REQUEST['mod'])?$_REQUEST['mod']:'index';

if ($Page == 'index') {
    include_once ('./page/home.php');
    $func = 'content_home';
    $data = $func($db);
    $xtpl->assign('title',  $data['title']);
    $xtpl->assign('messages', $data['content']);
}
else {
    include_once ('./page/'.$Page.'.php');

    // Формирование имени функции
    $func = 'content_'.$Page;

    // Переменной задается имя функции
    $data = $func($db);
    $xtpl->assign('title', $data['title']);
    $xtpl->assign('messages', $data['content']);
}
// Тут эта непонятная хуйня заканчивается


// Передаем в шаблон контента содержимое логотипа
$xtpl->assign('logo', logo($db));

// Передаем в шаблон контента содержимое меню
$xtpl->assign('menu', menu($db));


// Подготавливаем контент
$xtpl->parse('content');

// Вывод шаблона
$xtpl->out('content');

?>

<?php
// Скрипт добавления класса к активному пункту меню
?>
<script type="text/javascript">

    $(document).ready(function(){
        $(".nav .nav_link").each(function (i) {
            if(this.href==document.location.href){
                $(this).parent('').addClass('active');
            }
        });
    });
</script>




