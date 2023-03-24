<?php
class Voucher extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function urlcek($rank){
        $suanki_url = @$_GET['url'];
        $suanki_url = explode("/",$suanki_url);
        return @$suanki_url[$rank];
    }
    public function index(){
        $code = $this->urlcek(2);
        $this->view->render("voucher/index",["code"=>$code]);
    }
}