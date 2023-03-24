<?php

class Search extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function sqlSorgu($sql,$array){
        $model = $this->load->model("index_model");
        return $model->sqlSorgu($sql,$array);       
    }
    public function index(){

        $ortak = $this->load->controllers("index");        
         
        $data['gelen_kelime'] = $_REQUEST['kelime'];
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
        $headlines_sorgula  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.seflink LIKE :seflink and status= :status or b.headlines LIKE :headlines",array(":lang"=>$_SESSION["lang"],":seflink"=>"%".$kelime."%",":headlines"=>"%".$kelime."%",":status"=>"1"));
        foreach ($headlines_sorgula as $key => $value){
                $top_head_id_oku  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang = :lang and b.head_id= :head_id order by a.id ASC limit 1",array(":lang"=>$_SESSION["lang"],":head_id"=>$value['top_head_id']));
                 $resim  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines_resim WHERE head_id= :head_id order by id ASC limit 1",array(":head_id"=>$value['head_id']));
                if(!empty($top_head_id_oku)){
                    $link = SITE_URL.$top_head_id_oku[0]["seflink"]."/".$value["seflink"];
                }else{
                    $link = SITE_URL.$value["seflink"];
                }
                $sonuclar[] = array(
                    "headlines"=>$value["title"],
                    "link"=>"$link",
                    "toplam_kayit"=>count($headlines_sorgula),
                    "resim_link"=>$resim[0]["resim_link"]
                );
        }
        $headlines_sorgula  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.seflink LIKE :seflink and status= :status or b.headlines LIKE :headlines",array(":lang"=>$_SESSION["lang"],":seflink"=>"%".$kelime."%",":headlines"=>"%".$kelime."%",":status"=>"1"));
        foreach ($headlines_sorgula as $key => $value){
                $top_head_id_oku  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang = :lang and b.bhead_id= :head_id order by a.id ASC limit 1",array(":lang"=>$_SESSION["lang"],":head_id"=>$value['top_head_id']));
                $resim  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines_resim WHERE head_id= :head_id order by id ASC limit 1",array(":head_id"=>$value['head_id']));
                if(!empty($top_head_id_oku)){
                    $link = SITE_URL.$top_head_id_oku[0]["seflink"]."/".$value["seflink"];
                }else{
                    $link = SITE_URL.$value["seflink"];
                }
                $sonuclar[] = array(
                    "headlines"=>$value["title"],
                    "link"=>"$link",
                    "toplam_kayit"=>count($headlines_sorgula),
                    "resim_link"=>$value["headlines_resmi"]
                );
        }

        $urun_sorgula  = $this->sqlSorgu("SELECT * FROM ".PREFIX."urun a JOIN ".PREFIX."urun_dil b ON a.id=b.urun_id WHERE b.lang= :lang and b.seflink LIKE :seflink or b.headlines LIKE :headlines",array(":lang"=>$_SESSION["lang"],":seflink"=>"%".$kelime."%",":headlines"=>"%".$kelime."%"));
        foreach ($urun_sorgula as $key => $value){
            $idTemizle = str_replace(",", "", $value["kategor_ids"]);
            $top_head_id_oku  = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id = :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$idTemizle));
            $resim  = $this->sqlSorgu("SELECT * FROM ".PREFIX."urun_resim WHERE urun_id= :urun_id order by id ASC limit 1",array(":urun_id"=>$value['urun_id']));
            if(!empty($top_head_id_oku)){
                $link = SITE_URL.$top_head_id_oku[0]["seflink"]."/".$value['seflink'];
            }else{
                $link = SITE_URL.$value['seflink'];
            }
            $sonuclar[] = array(
                "headlines"=>$value["title"],
                "link"=>"$link",
                "toplam_kayit"=>count($urun_sorgula),
                "resim_link"=> $value["urun_resmi"]
            );
        } 
        return $sonuclar; 
    }
}