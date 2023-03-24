<?php
//Site Giriş Adresi
define("SITE_URL",  "http://18.197.115.104/osmanhamid-admin-api/");

// DATABASE
define("vt_driver",  "pdo_mysql");
define("vt_host","database-2.cd9rbberyumt.eu-central-1.rds.amazonaws.com");
define("vt_kullaniciadi",  "admin");
define("vt_sifre",         "SpH38Wr4vactaP2thdb");
define("vt_veritabaniadi", "osmandb");
define("PREFIX", "sys_");

// LANGUAGE
define("DEFAULT_LANG_CODE","tr");
define("DEFAULT_LANG","1");

// SETTINGS
define('USTDIZIN',  '../');

// FRONTEND
define('ANA_TEMA', 'public/temalar/default/'); //tema yolu
define('ANA_THEME_PATH', SITE_URL.ANA_TEMA); //tema yolu
define('ANA_ASSETS', ANA_TEMA.'assets/'); //tema yolu

define("FRONTEND_TEMPLATES",  "templates/");
define("FRONTEND_PLUGINS_ROAD",  USTDIZIN.FRONTEND_TEMPLATES);

// BACKEND
define('PANEL_URL', SITE_URL.@$tolga_ayarlar['config']['url_ek']);
define("PANEL_PUBLIC", PANEL_URL . "static/");
define("PANEL_TEMA", PANEL_URL . "static/temalar/default/");
define("PANEL_TEMPLATES",  "templates/");
define('PANEL_THEME_PATH', PANEL_TEMA); //tema yolu
define("PANEL_EK", PANEL_URL . "static/eklentiler/");
define("PANEL_ROOT", $_SERVER["DOCUMENT_ROOT"]);


@$urlbol = explode("/", @$_REQUEST["url"]);
if(@$urlbol){
    define("CONTROLLER",@$urlbol[0]);
    define("METHOD",@$urlbol[1]);
}else{
    define("CONTROLLER","");
    define("METHOD","");
}

if (!session_id()) {
//    print_r($_SERVER['DOCUMENT_ROOT']);
//    print_r(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/var/session'));
//    ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/var/session'));
    session_start();
}
// Textare Editoru Resim Yükleme Ayarı
@$_SESSION['ck_uploadpath'] = SITE_URL;

