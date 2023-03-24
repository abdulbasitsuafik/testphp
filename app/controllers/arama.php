<?php

class Arama extends Controller{
    public function __construct() {
        parent::__construct();
        $this->islemController = $this->load->controllers("islemler");
    }
    public function sqlSorgu($sql,$array){
        $model = $this->load->model("index_model");
        return $model->sqlSorgu($sql,$array);       
    }
    public function index(){

        $ortak = $this->load->controllers("index");        
        $form = $this->load->otherClasses("Form");
        $form->get("kelime");

        $data['gelen_kelime'] = htmlspecialchars($form->values['kelime']);
        if($data['gelen_kelime']==''){
            header("location: " . SITE_URL);
        }

        $data['sonuclar'] = $this->arama_sonuclar($data['gelen_kelime']);

        $ortak->header_cek();
        $this->view->render("sayfalar/arama", $data);
        $ortak->footer_cek();

    }
    public function arama_sonuclar($kelime){
        $form = $this->load->otherClasses("Form");
        $kelime = $form->seo($kelime);
        $headlines_sorgula  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and status= :status and (b.seflink LIKE :seflink  or b.headlines LIKE :headlines)",array(":lang"=>$_SESSION["lang"],":seflink"=>"%".$kelime."%",":headlines"=>"%".$kelime."%",":status"=>"1"));
        foreach ($headlines_sorgula as $key => $value){
                $top_head_id_oku  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang = :lang and b.head_id= :head_id order by a.id ASC limit 1",array(":lang"=>$_SESSION["lang"],":head_id"=>$value['top_head_id']));
                 $resim  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines_resim WHERE head_id= :head_id order by id ASC limit 1",array(":head_id"=>$value['head_id']));
                if($value["link"]!=""){
                   $link= $this->islemController->linkSor($value);
                 }else{
                    if(!empty($top_head_id_oku)){
                        $link = SITE_URL.$top_head_id_oku[0]["seflink"]."/".$value["seflink"];
                    }else{
                        $link = SITE_URL.$value["seflink"];
                    }
                 }
                $sonuclar[] = array(
                    "headlines"=>$value["title"],
                    "link"=>"$link",
                    "toplam_kayit"=>count($headlines_sorgula),
                    "resim_link"=>$resim[0]["resim_link"]
                );
        }
        $headlines_sorgula  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and status= :status and (b.seflink LIKE :seflink  or b.headlines LIKE :headlines)",array(":lang"=>$_SESSION["lang"],":seflink"=>"%".$kelime."%",":headlines"=>"%".$kelime."%",":status"=>"1"));
        foreach ($headlines_sorgula as $key => $value){
                $top_head_id_oku  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang = :lang and b.bhead_id= :head_id order by a.id ASC limit 1",array(":lang"=>$_SESSION["lang"],":head_id"=>$value['top_head_id']));
                $resim  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines_resim WHERE head_id= :head_id order by id ASC limit 1",array(":head_id"=>$value['head_id']));
                if($value["link"]!=""){
                   $link= $this->islemController->linkSor($value);
                 }else{
                    if(!empty($top_head_id_oku)){
                        $link = SITE_URL.$top_head_id_oku[0]["seflink"]."/".$value["seflink"];
                    }else{
                        $link = SITE_URL.$value["seflink"];
                    }
                 }
                $sonuclar[] = array(
                    "headlines"=>$value["title"],
                    "link"=>"$link",
                    "toplam_kayit"=>count($headlines_sorgula),
                    "resim_link"=>$value["headlines_resmi"]
                );
        }

        $urun_sorgula  = $this->sqlSorgu("SELECT * FROM ".PREFIX."urun a JOIN ".PREFIX."urun_dil b ON a.id=b.urun_id WHERE b.lang= :lang and b.seflink LIKE :seflink or b.headlines LIKE :headlines",array(":lang"=>$_SESSION["lang"],":seflink"=>"%".$kelime."%",":headlines"=>"%".$kelime."%",":status"=>1));
        foreach ($urun_sorgula as $key => $value){
            $idTemizle = str_replace(",", "", $value["kategor_ids"]);
            $top_head_id_oku  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id = :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$idTemizle));
            $resim  = $this->sqlSorgu("SELECT * FROM ".PREFIX."urun_resim WHERE urun_id= :urun_id order by id ASC limit 1",array(":urun_id"=>$value['urun_id']));
            if($value["link"]!=""){
               $link= $this->islemController->linkSor($value);
             }else{
                if(!empty($top_head_id_oku)){
                    $link = SITE_URL.$top_head_id_oku[0]["seflink"]."/".$value["seflink"];
                }else{
                    $link = SITE_URL.$value["seflink"];
                }
             }
            $sonuclar[] = array(
                "headlines"=>$value["title"],
                "link"=>"$link",
                "toplam_kayit"=>count($urun_sorgula),
                "resim_link"=> $value["urun_resmi"]
            );
        } 
        $projeheadlines_sorgula  = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_headlines a JOIN ".PREFIX."proje_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and status= :status and (b.seflink LIKE :seflink  or b.headlines LIKE :headlines)",array(":lang"=>$_SESSION["lang"],":seflink"=>"%".$kelime."%",":headlines"=>"%".$kelime."%",":status"=>"1"));
        foreach ($projeheadlines_sorgula as $key => $value){
                $top_head_id_oku  = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_headlines a JOIN ".PREFIX."proje_headlines_langs b ON a.id=b.head_id WHERE b.lang = :lang and b.bhead_id= :head_id order by a.id ASC limit 1",array(":lang"=>$_SESSION["lang"],":head_id"=>$value['top_head_id']));
                $resim  = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_headlines_resim WHERE head_id= :head_id order by id ASC limit 1",array(":head_id"=>$value['head_id']));
                if($value["link"]!=""){
                   $link= $this->islemController->linkSor($value);
                 }else{
                    if(!empty($top_head_id_oku)){
                        $link = SITE_URL.$top_head_id_oku[0]["seflink"]."/".$value["seflink"];
                    }else{
                        $link = SITE_URL.$value["seflink"];
                    }
                 }
                $sonuclar[] = array(
                    "headlines"=>$value["title"],
                    "link"=>"$link",
                    "toplam_kayit"=>count($projeheadlines_sorgula),
                    "resim_link"=>$value["headlines_resmi"]
                );
        }

        $proje_sorgula  = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje a JOIN ".PREFIX."proje_dil b ON a.id=b.proje_id WHERE b.lang= :lang and b.seflink LIKE :seflink or b.headlines LIKE :headlines",array(":lang"=>$_SESSION["lang"],":seflink"=>"%".$kelime."%",":headlines"=>"%".$kelime."%",":status"=>1));
        foreach ($proje_sorgula as $key => $value){
            $idTemizle = str_replace(",", "", $value["kategor_ids"]);
            $top_head_id_oku  = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_headlines a JOIN ".PREFIX."proje_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id = :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$idTemizle));
            $resim  = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_resim WHERE proje_id= :proje_id order by id ASC limit 1",array(":proje_id"=>$value['proje_id']));
            if($value["link"]!=""){
               $link= $this->islemController->linkSor($value);
             }else{
                if(!empty($top_head_id_oku)){
                    $link = SITE_URL.$top_head_id_oku[0]["seflink"]."/".$value["seflink"];
                }else{
                    $link = SITE_URL.$value["seflink"];
                }
             }
            $sonuclar[] = array(
                "headlines"=>$value["title"],
                "link"=>"$link",
                "toplam_kayit"=>count($proje_sorgula),
                "resim_link"=> $value["urun_resmi"]
            );
        } 
        $hizmetheadlines_sorgula  = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_headlines a JOIN ".PREFIX."hizmet_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and status= :status and (b.seflink LIKE :seflink  or b.headlines LIKE :headlines)",array(":lang"=>$_SESSION["lang"],":seflink"=>"%".$kelime."%",":headlines"=>"%".$kelime."%",":status"=>"1"));
        foreach ($hizmetheadlines_sorgula as $key => $value){
                $top_head_id_oku  = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_headlines a JOIN ".PREFIX."hizmet_headlines_langs b ON a.id=b.head_id WHERE b.lang = :lang and b.head_id= :head_id order by a.id ASC limit 1",array(":lang"=>$_SESSION["lang"],":head_id"=>$value['top_head_id']));
                $resim  = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_headlines_resim WHERE head_id= :head_id order by id ASC limit 1",array(":head_id"=>$value['head_id']));
                if($value["link"]!=""){
                   $link= $this->islemController->linkSor($value);
                 }else{
                    if(!empty($top_head_id_oku)){
                        $link = SITE_URL.$top_head_id_oku[0]["seflink"]."/".$value["seflink"];
                    }else{
                        $link = SITE_URL.$value["seflink"];
                    }
                 }
                $sonuclar[] = array(
                    "headlines"=>$value["title"],
                    "link"=>"$link",
                    "toplam_kayit"=>count($hizmetheadlines_sorgula),
                    "resim_link"=>$value["headlines_resmi"]
                );
        }

        $hizmet_sorgula  = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet a JOIN ".PREFIX."hizmet_dil b ON a.id=b.hizmet_id WHERE b.lang= :lang and status= :status and (b.seflink LIKE :seflink  or b.headlines LIKE :headlines)",array(":lang"=>$_SESSION["lang"],":seflink"=>"%".$kelime."%",":headlines"=>"%".$kelime."%",":status"=>1));
        foreach ($hizmet_sorgula as $key => $value){
            $idTemizle = str_replace(",", "", $value["kategor_ids"]);
            $top_head_id_oku  = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_headlines a JOIN ".PREFIX."hizmet_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id = :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$idTemizle));
            $resim  = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_resim WHERE hizmet_id= :hizmet_id order by id ASC limit 1",array(":hizmet_id"=>$value['hizmet_id']));
            if($value["link"]!=""){
               $link= $this->islemController->linkSor($value);
             }else{
                if(!empty($top_head_id_oku)){
                    $link = SITE_URL.$top_head_id_oku[0]["seflink"]."/".$value["seflink"];
                }else{
                    $link = SITE_URL.$value["seflink"];
                }
             }
            $sonuclar[] = array(
                "headlines"=>$value["title"],
                "link"=>"$link",
                "toplam_kayit"=>count($hizmet_sorgula),
                "resim_link"=> $value["urun_resmi"]
            );
        } 
        $makale_sorgula  = $this->sqlSorgu("SELECT * FROM ".PREFIX."makale a JOIN ".PREFIX."makale_dil b ON a.id=b.makale_id WHERE b.lang= :lang and status= :status and (b.seflink LIKE :seflink  or b.headlines LIKE :headlines)",array(":lang"=>$_SESSION["lang"],":seflink"=>"%".$kelime."%",":headlines"=>"%".$kelime."%",":status"=>1));
        foreach ($makale_sorgula as $key => $value){
            $idTemizle = str_replace(",", "", $value["head_ids"]);
            $top_head_id_oku  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id = :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$idTemizle));
            $resim  = $this->sqlSorgu("SELECT * FROM ".PREFIX."makale_resim WHERE makale_id= :makale_id order by id ASC limit 1",array(":makale_id"=>$value['makale_id']));
            if($value["link"]!=""){
               $link= $this->islemController->linkSor($value);
             }else{
                if(!empty($top_head_id_oku)){
                    $link = SITE_URL.$top_head_id_oku[0]["seflink"]."/".$value["seflink"];
                }else{
                    $link = SITE_URL.$value["seflink"];
                }
             }
            $sonuclar[] = array(
                "headlines"=>$value["title"],
                "link"=>"$link",
                "toplam_kayit"=>count($hizmet_sorgula),
                "resim_link"=> $value["manset_resmi"]
            );
        }
        return $sonuclar; 
    }
}