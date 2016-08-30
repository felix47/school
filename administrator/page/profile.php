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
function content_profile($db)
{
    $result['title']='Профиль пользователя!';
    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){
        $query = mysqli_query($db, "SELECT * FROM users WHERE id = '".intval($_COOKIE['id'])."' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        if(($userdata['hash'] !== $_COOKIE['hash']) or ($userdata['id'] !== $_COOKIE['id']))
        {
            setcookie("id", "", time() - 3600*24*30*12, "/administrator");
            setcookie("hash", "", time() - 3600*24*30*12, "/administrator");
            $result['content'] = "Хм, что-то не получилось";
        }
        elseif(isset($_POST['logout'])){
            if(($userdata['hash'] == $_COOKIE['hash']) and ($userdata['id'] == $_COOKIE['id'])) {
                setcookie ("id", "", time() - 3600);
                setcookie ("id", "", time() - 3600, "/administrator/", 1);
                setcookie ("hash", "", time() - 3600);
                setcookie ("hash", "", time() - 3600, "/administrator/", 1);
                header("Location: /administrator/");
            }
        }
        else
        {
            $xtpl = new XTemplate('./tpl/profile.xtpl');
            // Напихиваем в шаблон
            $xtpl->assign('profile_title', 'test');
            // Формируем шаблон
            $xtpl->parse('profile');
            $result['content'] = $xtpl->text('profile');
        }
    }
    else {
        header("Location: /administrator/");
    }
    return $result;
}


?>