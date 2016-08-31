<?php
function menuParentList($category, $parent)
{
    if (!isset($category[$parent]))  return '';

    if($parent < 1){
        $class = 'nav navbar-nav';
    }
    else {
        $class = 'dropdown-menu';
    }
    $tree = '<ul class="' . $class . '">';
    foreach ($category[$parent] as $key => $cat) {
        if($key != 0 && array_key_exists($key, $category)){
            $parent_list = 'dropdown';
            $parent_link = 'href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"';
        }
        else {
            $parent_link = 'href="' . $cat['link'] . '"';
        }
        $tree .= '<li class="' . $parent_list . '"><a ' . $parent_link . '>' . $cat['title'] . '</a>';
        $tree .= menuParentList($category, $cat['id']);
        $tree .= '</li>';
        unset($parent_list);
    }
    $tree .= '</ul>';

    return $tree;
}

function menu($db) {
    $Query = mysqli_query($db, 'SELECT * FROM menu_admin WHERE public > 0 ORDER BY sort ASC');
    // В цикле формируем массив разделов, ключом будет id родительской категории, а также массив разделов, ключом будет id категории
    while ($cat = mysqli_fetch_assoc($Query)) {
        $category[$cat['parent']][$cat['id']] = $cat;
    }
    //print_r($category);
    $child = menuParentList($category, 0);
    $xtpl_menu = new XTemplate('./tpl/menu.xtpl');
    $xtpl_menu->assign('list_menu', $child);
    $xtpl_menu->parse('menu');
    $result_menu = $xtpl_menu->text('menu');
    return $result_menu;

}

if (isset($_POST['logout'])) {
    setcookie("id", "", time() - 3600);
    setcookie("id", "", time() - 3600, "/administrator/", 1);
    setcookie("hash", "", time() - 3600);
    setcookie("hash", "", time() - 3600, "/administrator/", 1);
    header("Location: /administrator/");
}


/* Work 2
if(isset($_POST['logout'])){
    setcookie ("id", "", time() - 3600);
    setcookie ("id", "", time() - 3600, "/administrator/", 1);
    setcookie ("hash", "", time() - 3600);
    setcookie ("hash", "", time() - 3600, "/administrator/", 1);
    header("Location: /administrator/");
}
else {
    function menu($db){
        $Query = mysqli_query($db, 'SELECT * FROM menu_admin WHERE public > 0 ORDER BY sort ASC');
        if (mysqli_num_rows($Query) > 0) {
            $category = array();
            //В цикле формируем массив разделов, ключом будет id родительской категории, а также массив разделов, ключом будет id категории
            while ($cat = mysqli_fetch_assoc($Query)) {
                $category[$cat['parent']][$cat['id']] = $cat;
            }
        }
        function menuParentList($category,$parent) {
            $xtpl_menu = new XTemplate('./tpl/menu.xtpl');
                $tree = '<ul>';
                    foreach ($category[$parent] as $cat) {
                        $tree .= '<li>' . $cat['title'];
                        $tree .= menuParentList($category, $cat['id']);
                        $tree .= '</li>';
                    }
                $tree .= '</ul>';
            return $tree;
        }
        return menuParentList($category, 0);
    }
}
*/
/* Work
function menu($db){
    if(isset($_POST['logout'])){
        setcookie ("id", "", time() - 3600);
        setcookie ("id", "", time() - 3600, "/administrator/", 1);
        setcookie ("hash", "", time() - 3600);
        setcookie ("hash", "", time() - 3600, "/administrator/", 1);
        header("Location: /administrator/");
    }
    else {
// Подключаем файл шаблона
        $xtpl_menu = new XTemplate('./tpl/menu.xtpl');
        $Query = mysqli_query($db, 'SELECT * FROM menu_admin WHERE public > 0 ORDER BY sort ASC');
        while ($row = mysqli_fetch_assoc($Query)) {
            $xtpl_menu->assign('menu_link', $row);
            $xtpl_menu->assign('menu_name', $row);
            $xtpl_menu->parse('menu.menu_list');
        }
// Подготавливаем шаблон с учетом переданных переменных и блоков
        $xtpl_menu->parse('menu');
        $result_menu = $xtpl_menu->text('menu');
    }
    return $result_menu;
}
*/
?>

