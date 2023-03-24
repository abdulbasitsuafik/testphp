<?php
class Index extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
//        Session::checkSession();
    }
    public function index(){
        echo "Welcome to Api";
//        header("Location:". PANEL_URL."exams" );
    }
}
