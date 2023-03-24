<?php
class Errors extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
//        Session::checkSession();
    }
    public function sayfabulunamadi(){
        $data = array();
        $data["status"] = "1";
        $data["dashboard"] = true;

        $this->view->render("errors/404",$data);
    }
    public function izinsiz_giris(){
        $data = array();
        $data["status"] = "2";
        $data["dashboard"] = true;

        $this->view->render("errors/404",$data);
    }
}
