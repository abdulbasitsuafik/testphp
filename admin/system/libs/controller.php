<?php
class Controller{
    public $view;
    public $doctrine;
    protected $load = array();
    public function __construct() {
        $this->load = new load();
        $this->doctrine = new Doctrine();
        $this->view = new View();
        Session::init();
    }
    public function load(){
        $this->load = new load();
    }
}