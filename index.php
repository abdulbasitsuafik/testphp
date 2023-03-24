<?php
//error_reporting(true);
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
// System dosyalarını otomatik include ediyoruz.
$betik_zd = date_default_timezone_get();
if (strcmp($betik_zd, ini_get('date.timezone'))){
    date_default_timezone_set('Europe/Istanbul');

} else {
//    echo "<br/>";
//    echo 'Betik zaman dilimi ini dosyasında belirtilenle aynı.';
}
// Config dosyasını include ediyoruz.

if (is_dir("var")) {
} else {
    mkdir("var");
}
if (is_dir("var/session")) {
} else {
    mkdir("var/session");
}
include_once 'app/config/config.php';
include_once 'system/libs/doctrine.php';
include_once 'system/libs/controller.php';
include_once 'system/libs/database.php';
include_once 'system/libs/load.php';
include_once 'system/libs/view.php';
include_once 'system/libs/model.php';
include_once 'system/libs/session.php';
include_once 'system/libs/bootstrap.php';

// Bootstrap Bölümü
$boot = new Bootstrap();

//header("Refresh: 3; url=".SITE_URL."admin");
