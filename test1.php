<!DOCTYPE html>
<html class="img-no-display"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Создание ваучеров Отель "Екатерина"</title>
    <link href="../css/bootstrap.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="../js/jQuery.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <style>
        body {
            min-height: 100vh;
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #dae0ea), color-stop(100%, #fff));
            background: -webkit-linear-gradient(top, #dae0ea 0%, #fff 100%);
            background: -o-linear-gradient(top, #dae0ea 0%, #fff 100%);
            background: -ms-linear-gradient(top, #dae0ea 0%, #fff 100%);
            background: linear-gradient(to bottom, #dae0ea 0%, #fff 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dae0ea', endColorstr='#fff', GradientType=0 );
        }
        .btn {
            border-radius: 0px;
        }
    </style>
</head>
<body>
<div class="container">
<?php
if(!$_POST){
    include_once('index1.html');
}
elseif($_POST){
    // для метода POST
    $a = $_POST['amount'];
    $b = $_POST['expire'];
    $c = $_POST['data'];
    echo "$a <br /> $b <br /> $c <br />";
}
else{
    echo 'Что-то пошло не так';
}
?>
</div>
</body>
</html>
