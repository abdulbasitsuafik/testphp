<?php

class Payment extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function ok(){

        echo '<p style="width:100%;text-align: center;">Ödeme Başarılı</p>';
        echo '<p style="width:100%;text-align: center;"><img style="height: 200px;" src="'.SITE_URL.'uploads/check.png"></p>';
        echo '<p style="width:100%;text-align: center;">Geri Dönebilirsiniz.</p>';
        echo "<pre>";
        print_r($post);
        echo "</pre>";
    }
    public function fail(){
        $post = $_POST;
        echo '<p style="width:100%;text-align: center;">Ödeme başarısız</p>';
        echo '<p style="width:100%;text-align: center;"><img style="height: 200px;" src="'.SITE_URL.'uploads/fail.png"></p>';
        echo '<p style="width:100%;text-align: center;">Tekrar Deneyiniz</p>';
        echo '<p style="width:100%;text-align: center;">Tekrar Deneyiniz</p>';
        echo "<pre>";
        print_r($post);
        echo "</pre>";
    }
}