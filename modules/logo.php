<?php
function logo($db){

// ���������� ���� �������
    $xtpl_logo = new XTemplate('./tpl/logo.xtpl');
    $xtpl_logo->assign('logo_link', '/');
    $xtpl_logo->assign('logo_img', '/images/logo-small.png');
    $xtpl_logo->parse('logo');
    $result_logo = $xtpl_logo->text('logo');
    return $result_logo;
}
?>
