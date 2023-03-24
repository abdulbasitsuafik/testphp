<?php
class ekislem extends Controller {
    public function __construct() {
        parent::load();
        Session::init();
        $this->islemController = $this->load->controllers("islemler");
    }    
    public function deneme(){
    	echo "deneme geldi";
    }    
}