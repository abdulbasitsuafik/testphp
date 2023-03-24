<?php
class Sitemap extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function sqlSorgu($sql,$array){
        $model = $this->load->model("index_model");
        return $model->sqlSorgu($sql,$array);  
    }
    public function index()
    {
        date_default_timezone_set('Europe/Istanbul');
        $model = $this->load->model("index_model");
        
        $headlinesList = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE a.status= :status order by a.id ASC" ,array(":status"=>1));
        $headlinesList = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id = b.head_id WHERE a.status= :status  order by a.id ASC",array(":status"=>1));
        $urunList = $this->sqlSorgu("SELECT * FROM ".PREFIX."urun a JOIN ".PREFIX."urun_dil b ON a.id = b.urun_id WHERE a.status= :status  order by a.id ASC",array(":status"=>1));
        $projeheadlinesList = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_headlines a JOIN ".PREFIX."proje_headlines_langs b ON a.id = b.head_id WHERE a.status= :status  order by a.id ASC",array(":status"=>1));
        $projeList = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje a JOIN ".PREFIX."proje_dil b ON a.id = b.proje_id WHERE a.status= :status  order by a.id ASC",array(":status"=>1));
        $hizmetheadlinesList = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_headlines a JOIN ".PREFIX."hizmet_headlines_langs b ON a.id = b.head_id WHERE a.status= :status  order by a.id ASC",array(":status"=>1));
        $hizmetList = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet a JOIN ".PREFIX."hizmet_dil b ON a.id = b.hizmet_id WHERE a.status= :status  order by a.id ASC",array(":status"=>1));
        $haberList = $this->sqlSorgu("SELECT * FROM ".PREFIX."makale a JOIN ".PREFIX."makale_dil b ON a.id = b.makale_id WHERE a.status= :status  order by a.id ASC",array(":durum"=>1));
        $etkinlikList = $this->sqlSorgu("SELECT * FROM ".PREFIX."etkinlik a JOIN ".PREFIX."etkinlik_dil b ON a.id = b.etkinlik_id WHERE a.status= :status  order by a.id ASC",array(":durum"=>1));
        $siteAdresi = SITE_URL;
        header('Content-type: application/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        echo '  
<url>
       <loc>'.$siteAdresi.'</loc>
       <lastmod>'.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").'+00:00</lastmod>
       <changefreq>daily</changefreq>
       <priority>1.00</priority>
</url>';
        foreach ($headlinesList as $key => $value){
          if($value["status"]=="1"){
            $dilSor = $model->dilSor($value["lang"]);            
            if(empty($value["top_head_id"])){
                $link = $siteAdresi.$value['seflink'];
            }else{
                $ustvarmi = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.head_id = :head_id and b.lang= :lang and a.status= :status order by a.id ASC",array(":head_id"=>$value["top_head_id"],":lang"=>$value['lang'],":durum"=>1));
                $link = $siteAdresi.$ustvarmi[0]["seflink"]."/".$value['seflink'];
            }
            //if(!empty($value['link'])){$link = $value['link'];}
            if($ustvarmi[0]["status"]=="1" || empty($value["top_head_id"])){
            echo '
<url>
       <loc>'.$link.'</loc>       
       <lastmod>'.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").'+00:00</lastmod>
       <changefreq>monthly</changefreq>
       <priority>0.80</priority>
</url>';     
            }
          }  
        }
        foreach ($headlinesList as $key => $value){
            if($value["status"]=="1"){
                $dilSor = $model->dilSor($value["lang"]);            
                if(empty($value["top_head_id"])){
                    $link = $siteAdresi.$value['seflink'];
                }else{
                    $ustvarmi = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.head_id = :head_id and b.lang= :lang and a.status= :status order by a.id ASC",array(":head_id"=>$value["top_head_id"],":lang"=>$value['lang'],":durum"=>1));
                    $link = $siteAdresi.$ustvarmi[0]["seflink"]."/".$value['seflink'];
                }
                if($ustvarmi[0]["status"]=="1" || empty($value["top_head_id"])){
            echo '
<url>
       <loc>'.$link.'</loc>
       <lastmod>'.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").'+00:00</lastmod>
       <changefreq>monthly</changefreq>
       <priority>0.80</priority>
</url>';       
                }
            }
        }
        foreach ($urunList as $key => $value){
            $dilSor = $model->dilSor($value["lang"]);
            $link = $siteAdresi.$value['seflink'];
            echo '
<url>
       <loc>'.$link.'</loc>
       <lastmod>'.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").'+00:00</lastmod>
       <changefreq>monthly</changefreq>
       <priority>0.80</priority>
</url>';       
        }
        foreach ($projeheadlinesList as $key => $value){
            $dilSor = $model->dilSor($value["lang"]);
            $link = $siteAdresi.$value['seflink'];
            echo '
<url>
       <loc>'.$link.'</loc>
       <lastmod>'.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").'+00:00</lastmod>
       <changefreq>monthly</changefreq>
       <priority>0.80</priority>
</url>';       
        }
        foreach ($projeList as $key => $value){
            $dilSor = $model->dilSor($value["lang"]);
            $link = $siteAdresi.$value['seflink'];
            echo '
<url>
       <loc>'.$link.'</loc>
       <lastmod>'.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").'+00:00</lastmod>
       <changefreq>monthly</changefreq>
       <priority>0.80</priority>
</url>';       
        }
        foreach ($hizmetheadlinesList as $key => $value){
            $dilSor = $model->dilSor($value["lang"]);
            $link = $siteAdresi.$value['seflink'];
            echo '
<url>
       <loc>'.$link.'</loc>
       <lastmod>'.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").'+00:00</lastmod>
       <changefreq>monthly</changefreq>
       <priority>0.80</priority>
</url>';       
        }
        foreach ($hizmetList as $key => $value){
            $dilSor = $model->dilSor($value["lang"]);
            $link = $siteAdresi.$value['seflink'];
            echo '
<url>
       <loc>'.$link.'</loc>
       <lastmod>'.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").'+00:00</lastmod>
       <changefreq>monthly</changefreq>
       <priority>0.80</priority>
</url>';       
        }
        foreach ($haberList as $key => $value){
            $dilSor = $model->dilSor($value["lang"]);
            $link = $siteAdresi.$value['seflink'];
            echo '
<url>
       <loc>'.$link.'</loc>
       <lastmod>'.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").'+00:00</lastmod>
       <changefreq>monthly</changefreq>
       <priority>0.80</priority>
</url>';       
        }
        foreach ($etkinlikList as $key => $value){
            $dilSor = $model->dilSor($value["lang"]);
            $link = $siteAdresi.$value['seflink'];
            echo '
<url>
       <loc>'.$link.'</loc>
       <lastmod>'.date("Y").'-'.date("m").'-'.date("d").'T'.date("H:i:s").'+00:00</lastmod>
       <changefreq>monthly</changefreq>
       <priority>0.80</priority>
</url>';       
        }
        echo "
</urlset>";
    }

}
