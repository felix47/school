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
function content_administrator($db)
{
    //Вывод тайтла из БД
    $id_menu = '1';
    $query = mysqli_query($db, "SELECT title FROM menu_admin WHERE id = '$id_menu' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
    $result['title'] = $userdata['title'];

    if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))    {
        $query = mysqli_query($db, "SELECT * FROM users WHERE id = '".intval($_COOKIE['id'])."' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        if(($userdata['hash'] !== $_COOKIE['hash']) or ($userdata['id'] !== $_COOKIE['id']))
        {
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/");
            $result['content'] = "Хм, что-то не получилось";
        }
        else
        {
            $result['content'] = "Привет, ".$userdata['login'].". Всё работает1!";
            $global_param['title'] = "Введите свои логин и пароль!";
            // Подключаем шаблон
            $xtpl_login = new XTemplate('./tpl/home.xtpl');
            // Напихиваем в шаблон
            $xtpl_login->assign('article', $global_param['title']);
            // Формируем шаблон
            $xtpl_login->parse('home');
            $result['content'] = $xtpl_login->text('home');
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
            $result['content'] = 'ok';
        }
        else
        {
            $result['content'] =  "Вы ввели неправильный логин/пароль";
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
        $result['content'] = $xtpl_login->text('login');
    }
    return $result;
}
?>
