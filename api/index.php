<?php
// System dosyalarini otomatik include ediyoruz.
/* function __autoload($className){
    include_once 'system/libs/' . $className . '.php';
} */
//error_reporting(true);
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$betik_zd = date_default_timezone_get();
if (strcmp($betik_zd, ini_get('date.timezone'))){
    date_default_timezone_set('Europe/Istanbul');

} else {
//    echo "<br/>";
//    echo 'Betik zaman dilimi ini dosyasında belirtilenle aynı.';
}
$tolga_ayarlar['config']['url_ek'] = 'api/';
// Config dosyasini include ediyoruz.
include_once '../app/config/config.php';

include_once 'system/libs/doctrine.php';
include_once 'system/libs/controller.php';
include_once 'system/libs/database.php';
include_once 'system/libs/load.php';
include_once 'system/libs/view.php';
include_once 'system/libs/model.php';
include_once 'system/libs/session.php';
include_once 'system/libs/bootstrap.php';





// Bootstrap Baslangic
$boot = new Bootstrap();

