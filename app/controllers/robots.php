<?php
class Robots extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function sqlSorgu($sql,$array){
        $model = $this->load->model("index_model");
        return $model->sqlSorgu($sql,$array);  
    }
    public function index(){
       error_reporting(0);
       // read static robots.txt template
       $robotsTxt = "User-agent: *\n\nDisallow: /cgi-bin/\nDisallow: /public/\nDisallow: /.git/\nDisallow: /tolga/\nDisallow: /app/\nDisallow: /system/\nDisallow: /vendor/\n\nSitemap: ".SITE_URL."sitemap.xml";
       header("Content-Type:text/plain");
       echo $robotsTxt;
    }
}
