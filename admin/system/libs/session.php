<?php

class Session{
    public static function init(){
        if (!session_id()) {
//            ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
            session_start();
        }
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
        if(self::get("login") == false){
            self::destroy();
            header("Location: ". PANEL_URL ."admin/login");
        }
    }


    public static function destroy(){
        session_destroy();
    }
}