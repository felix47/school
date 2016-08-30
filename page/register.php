<?php
$global_param['login_title'] = "Введите свои данные";
$global_param['log'] = 'Логин';
$global_param['pass'] = 'Пароль';
$global_param['email'] = 'EMail';

function content_register($global_param) {
    if($_POST['enter']){
        $resultregister['content'] = 'Логин збс';

    }
    else {
        $resultregister['title'] = 'Страница регистрации';
        $resultregister['content'] = 'test';
        // Подключаем шаблон
        $xtpl_register = new XTemplate('./tpl/register.xtpl');
        // Напихиваем в шаблон
        $xtpl_register->assign('login_title', $global_param['login_title']);
        $xtpl_register->assign('log', $global_param['log']);
        $xtpl_register->assign('pass', $global_param['pass']);
        $xtpl_register->assign('email', $global_param['email']);

        // Формируем шаблон
        $xtpl_register->parse('register');

        $resultregister['content'] = $xtpl_register->text('register');
    }
    return $resultregister;
}


?>