<?php
class Session{
    public static function init(){
        ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/tmp'));
        ini_set('session.gc_probability', 1);
        if(!isset($_SESSION)){ @session_start();}
    }
    public static function set($key, $val){
        $_SESSION[$key] = $val;
    }
    public static function get($key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }else{
            return false;
        }
    }
    public static function checkSession(){
        self::init();
        if(self::get("uye_giris") == false){
            self::destroy();
            header("Location: ". SITE_URL ."memberships/login");
        }
    }
    public static function destroy(){
        session_destroy();
    }
}
