<?php
function generateCode($length=6)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clen)];
    }
    return $code;
}
function content_login($db)
{
    if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))    {
        $query = mysqli_query($db, "SELECT * FROM users WHERE id = '".intval($_COOKIE['id'])."' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        if(($userdata['hash'] !== $_COOKIE['hash']) or ($userdata['id'] !== $_COOKIE['id']))
        {
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/");
            $resultlogin['content'] = "Хм, что-то не получилось";
        }
        else
        {
            $resultlogin['content'] = "Привет, ".$userdata['login'].". Всё работает!";
        }
    }
    elseif(isset($_POST['enter'])){
        # Вытаскиваем из БД запись, у которой логин равняеться введенному
        $query = mysqli_query($db,"SELECT id,login, password FROM users WHERE login='".mysqli_real_escape_string($db,$_POST['login'])."' LIMIT 1");
        $data = mysqli_fetch_assoc($query);
        # Сравниваем пароли
        if($data['password'] ===  md5(md5(trim($_POST['password']))))
        {
            # Генерируем случайное число и шифруем его
            $hash = md5(generateCode(10));
            # Записываем в БД новый хеш авторизации и IP
            mysqli_query($db, "UPDATE users SET hash='".$hash."'");
            # Ставим куки
            setcookie("id", $data['id'], time()+60*60*24*30);
            setcookie("hash", $hash, time()+60*60*24*30);
            $resultlogin['content'] = 'ok';
        }
        else
        {
            $resultlogin['content'] =  "Вы ввели неправильный логин/пароль";
        }
    }
    else {
        $global_param['login_title'] = "Введите свои логин и пароль!";
        // Подключаем шаблон
        $xtpl_login = new XTemplate('./tpl/login.xtpl');
        // Напихиваем в шаблон
        $xtpl_login->assign('log_title', $global_param['login_title']);
        // Формируем шаблон
        $xtpl_login->parse('login');
        $resultlogin['content'] = $xtpl_login->text('login');
    }
    return $resultlogin;
}
/*V4
function content_login($db){
    $resultlogin['title'] = 'Страница входа';
    if(isset($_SESSION['USER_LOGIN_IN'])&&($_SESSION['USER_LOGIN'])&&($_SESSION['USER_PASSWORD'])) {
        if($_SESSION['USER_LOGIN_IN'] =1) {
            if (isset($_POST['logout'])) {
                unset($_SESSION['USER_LOGIN_IN']);
                $resultlogin['content'] = 'Вышел';
            }
            else {
                $global_param['login_title'] = "Вход выполнен";
                $previous_name = session_name("WebsiteID");

                echo "The previous session name was $previous_name<p>";
                // Подключаем шаблон
                $xtpl_login = new XTemplate('./tpl/login.xtpl');
                // Напихиваем в шаблон
                $xtpl_login->assign('log_title', $global_param['login_title']);
                // Формируем шаблон
                $xtpl_login->parse('login_out');
                $resultlogin['content'] = $xtpl_login->text('login_out');
            }
        }
    }
    else {
        if (isset($_POST['login']) && ($_POST['password'])) {
            $Row = mysqli_fetch_assoc(mysqli_query($db, "SELECT `login`, `password` FROM `users` WHERE `login` = '$_POST[login]'"));
            if ($Row['password'] != $_POST['password']) {
                $resultlogin['content'] = 'Неверный логин или пароль';
            } else {
                $resultlogin['content'] = 'Выполнен вход!';
                $_SESSION['USER_LOGIN'] = $Row['login'];
                $_SESSION['USER_PASSWORD'] = $Row['password'];
                $_SESSION['USER_LOGIN_IN'] = 3;
            }
        } else {
            $global_param['login_title'] = "Введите свои логин и пароль!";
            // Подключаем шаблон
            $xtpl_login = new XTemplate('./tpl/login.xtpl');
            // Напихиваем в шаблон
            $xtpl_login->assign('log_title', $global_param['login_title']);
            // Формируем шаблон
            $xtpl_login->parse('login');
            $resultlogin['content'] = $xtpl_login->text('login');
        }
    }
    return $resultlogin;
}
*/
/*V3
function content_login($db){
    $resultlogin['title'] = 'Страница входа';
    if(isset($_SESSION['USER_LOGIN_IN'])) {
        if($_SESSION['USER_LOGIN_IN'] =1) {
            $resultlogin['content'] = 'Login in';
        }
    }
    else {
        if (isset($_POST['login']) && ($_POST['password'])) {
            $Row = mysqli_fetch_assoc(mysqli_query($db, "SELECT `login`, `password` FROM `users` WHERE `login` = '$_POST[login]'"));
            if ($Row['password'] != $_POST['password']) {
                $resultlogin['content'] = 'Неверный логин или пароль';
            } else {
                $resultlogin['content'] = 'Выполнен вход!';
                $_SESSION['USER_LOGIN'] = $Row['login'];
                $_SESSION['USER_PASSWORD'] = $Row['password'];
                $_SESSION['USER_LOGIN_IN'] = 1;
            }
        } else {
            $global_param['login_title'] = "Введите свои логин и пароль!";
            // Подключаем шаблон
            $xtpl_login = new XTemplate('./tpl/login.xtpl');
            // Напихиваем в шаблон
            $xtpl_login->assign('log_title', $global_param['login_title']);
            // Формируем шаблон
            $xtpl_login->parse('login');
            $resultlogin['content'] = $xtpl_login->text('login');
        }
    }
    return $resultlogin;
}
*/

/* V2
function content_login($db){
        $resultlogin['title'] = 'Страница входа';
    if(isset($_SESSION['USER_LOGIN_IN'])) {
        if (isset($_POST['login']) && ($_POST['password'])) {
            $Row = mysqli_fetch_assoc(mysqli_query($db, "SELECT `login`, `password` FROM `users` WHERE `login` = '$_POST[login]'"));
            if ($Row['password'] != $_POST['password']) {
                $resultlogin['content'] = 'Неверный логин или пароль';
            } else {
                $resultlogin['content'] = 'Выполнен вход!';
                $_SESSION['USER_LOGIN'] = $Row['login'];
                $_SESSION['USER_PASSWORD'] = $Row['password'];
                $_SESSION['USER_LOGIN_IN'] = 1;
            }
        } else {
            $global_param['login_title'] = "Введите свои логин и пароль!";
            // Подключаем шаблон
            $xtpl_login = new XTemplate('./tpl/login.xtpl');
            // Напихиваем в шаблон
            $xtpl_login->assign('log_title', $global_param['login_title']);
            // Формируем шаблон
            $xtpl_login->parse('login');
            $resultlogin['content'] = $xtpl_login->text('login');
        }
    }
    else {
        $resultlogin['content'] = 'Login in';
    }
    return $resultlogin;
}
*/

/* V1
$global_param['login_title'] = "Введите свои логин и пароль!";


function content_login($global_param) {
    if($_POST['enter']){
        $resultlogin['content'] = 'Логин збс';

    }
else {
    $resultlogin['title'] = 'Страница входа';
    $resultlogin['content'] = 'test';
    // Подключаем шаблон
    $xtpl_login = new XTemplate('./tpl/login.xtpl');
    // Напихиваем в шаблон
    $xtpl_login->assign('login_title', $global_param['login_title']);
    $xtpl_login->assign('log', $global_param['log']);
    $xtpl_login->assign('pass', 'Пароль');

    // Формируем шаблон
    $xtpl_login->parse('login');

    $resultlogin['content'] = $xtpl_login->text('login');
}
    return $resultlogin;
}
*/

?>