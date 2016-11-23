<?php
function content_home($db){
    $id_menu = '2';
    $query = mysqli_query($db, "SELECT title FROM menu WHERE id = '$id_menu' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
    $result['title'] = $userdata['title'];
    $xtpl = new XTemplate('./tpl/home.xtpl');
    if(isset($_REQUEST['item'])){
        $query = mysqli_query($db, "SELECT * FROM content WHERE id = '".intval($_REQUEST['item'])."' LIMIT 1");
        $row = mysqli_fetch_assoc($query);
        if($_REQUEST['item'] == $row['id']) {
            $xtpl->assign('data', $row);
            $xtpl->parse('material');
            $result['content'] = $xtpl->text('material');
        }
        else {
            header("Location: /");
        }
    }
    elseif(isset($_POST['from'])){
            $a = $_POST['from'];
            $b = $_POST['to'];
            echo "$a $b";
        $Query = mysqli_query($db, 'SELECT * FROM content WHERE date_create > "'.$a.'" AND date_create < "'.$b.'" ORDER BY id DESC');
        unset($_POST['from']);
        unset($_POST['to']);
        while ($row = mysqli_fetch_assoc($Query)) {
            $xtpl->assign('data', $row);
            $xtpl->parse('home.row');
        }
        $xtpl->parse('home');
        $result['content'] = $xtpl->text('home');
    }
    else {
       // $Query = mysqli_query($db, 'SELECT * FROM content WHERE date_create > "2016-08-19 00:00:00" AND date_create < "2016-08-19 23:59:59"');
        $Query = mysqli_query($db, 'SELECT * FROM content ORDER BY id DESC');
        while ($row = mysqli_fetch_assoc($Query)) {
            $xtpl->assign('data', $row);
            $xtpl->parse('home.row');
        }
        $xtpl->parse('home');
        $result['content'] = $xtpl->text('home');
    }
    return $result;
}
?>
