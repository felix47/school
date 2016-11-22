<?php

// LDAP переменные
$ldaphost = "pdc1.elstandart.spb.ru";  // Ваш сервер ldap
$ldapport = 389;                 // Порт вашего сервера ldap
// используется ldap-привязка
$ldaprdn  = 'i.v.baranova@elstandart.spb.ru';     // ldap rdn или dn
$ldappass = '123456';  // ассоциированный пароль

// Соединение с LDAP
$ldapconn = ldap_connect($ldaphost, $ldapport)
or die("Невозможно соединиться с $ldaphost");

// Set some ldap options for talking to
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

if ($ldapconn) {
    // привязка к ldap-серверу
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

    if ($ldapbind) {
        $dn = "dc=elstandart,dc=spb,dc=ru";
        $attributes = array("*");
        $filter = "(&(objectCategory=person)(objectClass=user)(userAccountControl:1.2.840.113556.1.4.803:=2))";

        $result = ldap_search($ldapconn,$dn,$filter,$attributes) or die ("Error in search query: ".ldap_error($ldapconn));
        $data = ldap_get_entries($ldapconn, $result);
        echo $data["count"]." записей возвращено\n <br />";
        // SHOW ALL DATA
        echo '<h1>Dump all data</h1><pre>';
        print_r($data);
        echo '</pre>';
        ldap_unbind ($ldapconn, $ldaprdn, $ldappass) or die ("Разрыв соединения: ".ldap_error($ldapconn));

    }
    else {
        echo "LDAP-привязка не удалась...<br />";
    }
    $test = ldap_get_values_len($ldapconn , $dn , "objectguid" );
    var_dump($test);
}

?>