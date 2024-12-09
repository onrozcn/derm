<?php

$_SESSION["requesturl"] = $httpText . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '' . $_SERVER['REQUEST_URI'];


if (!isset($_SESSION['logged'])) {
    header('location:' . $siteUrl . 'login.php');
    die();
}

if ($CurrentUser['active'] == 0) {
    header('location:' . $siteUrl . 'login.php');
    die();
}

if ( $setting['maintinance'] == 1 && ($CurrentUser['permission']['superadmin'] != 1 && $CurrentUser['permission']['admin'] != 1) ) {
    header('Location: assets/maintinancemode');
}

if ( $setting['super-maintinance'] == 1 && $CurrentUser['permission']['superadmin'] != 1 ) {
    header('Location: assets/maintinancemode');
}

//print_r($CurrentUser);

?>