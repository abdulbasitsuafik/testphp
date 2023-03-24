<?php
class index extends Controller{
    public function __construct() {
        parent::__construct();
        Session::init();
        $this->islemController = $this->load->controllers("islemler");
    }
    public function sqlSorgu($sql,$array){
        $model = $this->load->model("index_model");
        return $model->sqlSorgu($sql,$array);  
    }
    public function index(){
        $model = $this->load->model("index_model");      
        $ayar = $model->ayarList() ;
        $gelen_baslik = $model->ilkBaslikNe();
        $gelen_modul = $model->modulTek($gelen_baslik[0]["baslik_id"]);
        $data = array(); 
        $data["slayt"] = $model->slaytListAll($gelen_baslik[0]["slayt_id"]);
        $data["form_id"] = $gelen_baslik[0]["form_id"];
        $data["sayfaadi"] = $_SESSION["kontrolor"];
        $data["sitebilgi"] = $ayar[0];        
        $this->header_cek(); 
        
        if($gelen_modul==true){
            foreach ($gelen_modul as $key => $value) {
                $tpl_yolu = str_replace(".tpl", "", $value["tpl_yolu"]);
                if($tpl_yolu!='') {
                    $this->view->render("moduller/".$value["klasor"]."/" . $tpl_yolu, $data);
                }
            }     
        }else{
           $this->view->render("moduller/sayfalar/icerik", $data);
        }
        $this->footer_cek($gelen_baslik);      
    }
    public function icerik(){        
        $model = $this->load->model("index_model");
        $data["sayfaadi"] = $_SESSION["kontrolor"];
        $sayfa = $this->urlcek(0);
        if($this->urlcek(1)!='' && $this->urlcek(2)=='') $sayfa = $this->urlcek(1);
        if($this->urlcek(2)!='') $sayfa = $this->urlcek(2);
        $gelen_baslik = $model->gelenBaslik("baslik",$sayfa);
        $gelen_kategori = $model->gelenBaslik("kategori",$sayfa);
        $gelen_urun = $model->gelenBaslik("urun",$sayfa);  
        $gelen_projekategori = $model->gelenBaslik("proje_kategori",$sayfa);
        $gelen_proje = $model->gelenBaslik("proje",$sayfa); 
        $gelen_hizmetkategori = $model->gelenBaslik("hizmet_kategori",$sayfa);
        $gelen_hizmet = $model->gelenBaslik("hizmet",$sayfa); 
        $gelen_makale = $model->gelenBaslik("makale",$sayfa);
        $data["slayt"] = $model->slaytListAll($gelen_baslik[0]["slayt_id"]);
        $data["form_id"] = $gelen_baslik[0]["form_id"];
        if(!empty($gelen_baslik)){            
            $data['sayfadetay'] = $gelen_baslik[0];
        }else if(!empty($gelen_kategori)){
            $data['sayfadetay'] = $gelen_kategori[0]; 
        }else if(!empty($gelen_urun)){
            $data['sayfadetay'] = $gelen_urun[0]; 
        }else if(!empty($gelen_projekategori)){
            $data['sayfadetay'] = $gelen_projekategori[0]; 
        }else if(!empty($gelen_proje)){
            $data['sayfadetay'] = $gelen_proje[0]; 
        }else if(!empty($gelen_hizmetkategori)){
            $data['sayfadetay'] = $gelen_hizmetkategori[0]; 
        }else if(!empty($gelen_hizmet)){
            $data['sayfadetay'] = $gelen_hizmet[0]; 
        }else if(!empty($gelen_makale)){
            $data['sayfadetay'] = $gelen_makale[0]; 
        }
        
        $gelen_modul = $model->modulTek($gelen_baslik[0]["baslik_id"]);       
        $ayar = $model->ayarList() ;
        
        $data["sitebilgi"] = $ayar[0];
        if($ayar[0]["yayin_durumu"]=="1"){
            $this->header_cek(); 
            if($gelen_modul==true and $_SESSION["linkSistemi"] =="baslik"){            
                foreach ($gelen_modul as $key => $value) {
                    $tpl_yolu = str_replace(".tpl", "", $value["tpl_yolu"]);
                    if($tpl_yolu!='') {
                        $this->view->render("moduller/".$value["klasor"]."/" . $tpl_yolu, $data);
                    }
                }
            }else if($_SESSION["linkSistemi"] =="kategori"){
                $this->view->render("moduller/sayfalar/urunler", $data);            
            }else if($_SESSION["linkSistemi"] =="proje_kategori"){
                $this->view->render("moduller/sayfalar/projeler", $data);            
            }else if($_SESSION["linkSistemi"] =="hizmet_kategori"){
                $this->view->render("moduller/sayfalar/hizmetler", $data);            
            }else if($_SESSION["linkSistemi"] =="urun"){
                $this->view->render("moduller/sayfalar/urundetay", $data);            
            }else if($_SESSION["linkSistemi"] =="proje"){
                $this->view->render("moduller/sayfalar/projedetay", $data);            
            }else if($_SESSION["linkSistemi"] =="hizmet"){
                $this->view->render("moduller/sayfalar/hizmetdetay", $data);            
            }else if($_SESSION["linkSistemi"] =="makale"){
                $this->view->render("moduller/sayfalar/haberdetay", $data);            
            }else{
                $this->view->render("moduller/sayfalar/icerik", $data);
            }
            $this->footer_cek($gelen_baslik);
        }else{
            header('location: '.SITE_ADRESI);
        }
    }  
    public function html_sikistir(){
        $gzip_pres = true;
        function gzipKontrol(){
            $kontrol   = str_replace(" ", "", strtolower($_SERVER['HTTP_ACCEPT_ENCODING']));
            $kontrol   = explode(",", $kontrol);
            return in_array("gzip", $kontrol);
        }
        function bosluksil($kaynak){
            $kaynak    = preg_replace('#^\s*//.+$#m', null, $kaynak);
            $kaynak    = preg_replace("/\s+/", ' ', $kaynak);
            $kaynak    = preg_replace('/<!--(.|\s)*?-->/', null, $kaynak);
            $kaynak    = trim($kaynak);
            return $kaynak;
        }
        function kaynak_presle($kaynak){
            global $gzip_pres;
            $sayfa_cikti = bosluksil($kaynak);
            if(!gzipKontrol() || headers_sent() || !$gzip_pres)
                return $sayfa_cikti;
            header("Content-Encoding : gzip");
            return gzencode($sayfa_cikti);
        }
        ob_start("kaynak_presle");
    }
    public function urlcek($sira){
        if(!empty($_GET['url'])){
            $suanki_url = $_GET['url'];
            $suanki_url = explode("/",$suanki_url);
            return $suanki_url[$sira];
        }   
    }
    public  function dinamik_veriler(){
        if($_SESSION["kontrolor"]=="acilis"){  
            $baslik_oku = $this->sqlSorgu("SELECT * FROM ".PREFIX."baslik a JOIN ".PREFIX."baslik_dil b ON a.id=b.baslik_id WHERE b.dil_id= :dil_id and b.baslik_id= :baslik_id",array(":dil_id"=>$_SESSION["dil"],":baslik_id"=>"1"));
            $sayfa = $baslik_oku[0]["seflink"];
        }else{            
            $sayfa = $this->urlcek(0);
        }
        if($this->urlcek(1)!='' && $this->urlcek(2)=='') $sayfa = $this->urlcek(1);
        if($this->urlcek(2)!='') $sayfa = $this->urlcek(2);
        if(!empty($sayfa)){
            if($_SESSION["linkSistemi"]=='makale'){
                // Haber detay sayfası
                $baslik_oku      = $this->sqlSorgu("SELECT * FROM ".PREFIX."makale a JOIN ".PREFIX."makale_dil b ON a.id=b.makale_id WHERE b.dil_id= :dil_id and b.seflink= :seflink",array(":dil_id"=>$_SESSION["dil"],":seflink"=>$sayfa));
                $title           = $baslik_oku[0]['title'];
                $description     =  $baslik_oku[0]['aciklama'];
                $keywords        =  $baslik_oku[0]['keywords'];
                $meta_resim      =  $baslik_oku[0]['manset_resmi'];
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."baslik a JOIN ".PREFIX."baslik_dil b ON a.id=b.baslik_id WHERE b.dil_id= :dil_id and b.baslik_id= :baslik_id",array(":dil_id"=>$_SESSION["dil"],":baslik_id"=>str_replace(",","",$baslik_oku[0]["baslik_idler"])));
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."baslik a JOIN ".PREFIX."baslik_dil b ON a.id=b.baslik_id WHERE b.dil_id= :dil_id and b.baslik_id= :baslik_id",array(":dil_id"=>$_SESSION["dil"],":baslik_id"=>$linkSorgu[0]["ust_baslik_id"]));                      
                $ustKat = $linkUstSorgu[0]["baslik"];
                $kat = $linkSorgu[0]["baslik"];                   
                $degisecekler = array($ustKat,$kat,$baslik_oku[0]['baslik']);
                $degisenler = array("{{anaBaslik}}","{{altBaslik}}","{{baslik}}",); 
            }else if($_SESSION["linkSistemi"]=='kategori'){
                // Ürün Liste sayfası
                $baslik_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."kategori a JOIN ".PREFIX."kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.seflink= :seflink",array(":dil_id"=>$_SESSION["dil"],":seflink"=>$sayfa));
                $title          = $baslik_oku[0]['title'];
                $description    =  $baslik_oku[0]['aciklama'];
                $keywords       =  $baslik_oku[0]['keywords'];
                $meta_resim     =  $baslik_oku[0]['kategori_resmi'];
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."kategori a JOIN ".PREFIX."kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.kategori_id= :kategori_id",array(":dil_id"=>$_SESSION["dil"],":kategori_id"=>$baslik_oku[0]["ust_kategori_id"]));                      
                $ustKat = $linkUstSorgu[0]["baslik"];
                $kat = $baslik_oku[0]["baslik"];             
                $degisecekler = array($ustKat,$kat,$baslik_oku[0]['baslik']);
                $degisenler = array("{{anaBaslik}}","{{altBaslik}}","{{baslik}}"); 
            } else if($_SESSION["linkSistemi"]=='urun'){
                // Ürün detay sayfası
                 $baslik_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."urun a JOIN ".PREFIX."urun_dil b ON a.id=b.urun_id WHERE b.dil_id= :dil_id and b.seflink= :seflink",array(":dil_id"=>$_SESSION["dil"],":seflink"=>$sayfa));
                $title          = $baslik_oku[0]['title'];
                $description    =  $baslik_oku[0]['aciklama'];
                $keywords       =  $baslik_oku[0]['keywords'];
                $meta_resim     =  $baslik_oku[0]['urun_resmi'];
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."kategori a JOIN ".PREFIX."kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.kategori_id= :kategori_id",array(":dil_id"=>$_SESSION["dil"],":kategori_id"=>str_replace(",","",$baslik_oku[0]["kategori_idler"])));
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."kategori a JOIN ".PREFIX."kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.kategori_id= :kategori_id",array(":dil_id"=>$_SESSION["dil"],":kategori_id"=>$linkSorgu[0]["ust_kategori_id"]));                      
                $ustKat = $linkUstSorgu[0]["baslik"];
                $kat = $linkSorgu[0]["baslik"];                   
                $degisecekler = array($ustKat,$kat,$baslik_oku[0]['baslik']);
                $degisenler = array("{{anaBaslik}}","{{altBaslik}}","{{baslik}}"); 
            }else if($_SESSION["linkSistemi"]=='proje_kategori'){
                // Ürün Liste sayfası
                $baslik_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_kategori a JOIN ".PREFIX."proje_kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.seflink= :seflink",array(":dil_id"=>$_SESSION["dil"],":seflink"=>$sayfa));
                $title          = $baslik_oku[0]['title'];
                $description    =  $baslik_oku[0]['aciklama'];
                $keywords       =  $baslik_oku[0]['keywords'];
                $meta_resim     =  $baslik_oku[0]['kategori_resmi'];
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_kategori a JOIN ".PREFIX."proje_kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.kategori_id= :kategori_id",array(":dil_id"=>$_SESSION["dil"],":kategori_id"=>$baslik_oku[0]["ust_kategori_id"]));                      
                $ustKat = $linkUstSorgu[0]["baslik"];
                $kat = $baslik_oku[0]["baslik"];             
                $degisecekler = array($ustKat,$kat,$baslik_oku[0]['baslik']);
                $degisenler = array("{{anaBaslik}}","{{altBaslik}}","{{baslik}}"); 
            } else if($_SESSION["linkSistemi"]=='proje'){
                // Ürün detay sayfası
                 $baslik_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje a JOIN ".PREFIX."proje_dil b ON a.id=b.proje_id WHERE b.dil_id= :dil_id and b.seflink= :seflink",array(":dil_id"=>$_SESSION["dil"],":seflink"=>$sayfa));
                $title          = $baslik_oku[0]['title'];
                $description    =  $baslik_oku[0]['aciklama'];
                $keywords       =  $baslik_oku[0]['keywords'];
                $meta_resim     =  $baslik_oku[0]['proje_resmi'];
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_kategori a JOIN ".PREFIX."proje_kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.kategori_id= :kategori_id",array(":dil_id"=>$_SESSION["dil"],":kategori_id"=>str_replace(",","",$baslik_oku[0]["kategori_idler"])));
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_kategori a JOIN ".PREFIX."proje_kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.kategori_id= :kategori_id",array(":dil_id"=>$_SESSION["dil"],":kategori_id"=>$linkSorgu[0]["ust_kategori_id"]));                      
                $ustKat = $linkUstSorgu[0]["baslik"];
                $kat = $linkSorgu[0]["baslik"];                   
                $degisecekler = array($ustKat,$kat,$baslik_oku[0]['baslik']);
                $degisenler = array("{{anaBaslik}}","{{altBaslik}}","{{baslik}}",); 
            }else if($_SESSION["linkSistemi"]=='hizmet_kategori'){
                // Ürün Liste sayfası
                $baslik_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_kategori a JOIN ".PREFIX."hizmet_kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.seflink= :seflink",array(":dil_id"=>$_SESSION["dil"],":seflink"=>$sayfa));
                $title          = $baslik_oku[0]['title'];
                $description    =  $baslik_oku[0]['aciklama'];
                $keywords       =  $baslik_oku[0]['keywords'];
                $meta_resim     =  $baslik_oku[0]['kategori_resmi'];
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_kategori a JOIN ".PREFIX."hizmet_kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.kategori_id= :kategori_id",array(":dil_id"=>$_SESSION["dil"],":kategori_id"=>$baslik_oku[0]["ust_kategori_id"]));                      
                $ustKat = $linkUstSorgu[0]["baslik"];
                $kat = $baslik_oku[0]["baslik"];             
                $degisecekler = array($ustKat,$kat,$baslik_oku[0]['baslik']);
                $degisenler = array("{{anaBaslik}}","{{altBaslik}}","{{baslik}}"); 
            } else if($_SESSION["linkSistemi"]=='hizmet'){
                // Ürün detay sayfası
                 $baslik_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet a JOIN ".PREFIX."hizmet_dil b ON a.id=b.hizmet_id WHERE b.dil_id= :dil_id and b.seflink= :seflink",array(":dil_id"=>$_SESSION["dil"],":seflink"=>$sayfa));
                $title          = $baslik_oku[0]['title'];
                $description    =  $baslik_oku[0]['aciklama'];
                $keywords       =  $baslik_oku[0]['keywords'];
                $meta_resim     =  $baslik_oku[0]['hizmet_resmi'];
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_kategori a JOIN ".PREFIX."hizmet_kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.kategori_id= :kategori_id",array(":dil_id"=>$_SESSION["dil"],":kategori_id"=>str_replace(",","",$baslik_oku[0]["kategori_idler"])));
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_kategori a JOIN ".PREFIX."hizmet_kategori_dil b ON a.id=b.kategori_id WHERE b.dil_id= :dil_id and b.kategori_id= :kategori_id",array(":dil_id"=>$_SESSION["dil"],":kategori_id"=>$linkSorgu[0]["ust_kategori_id"]));                      
                $ustKat = $linkUstSorgu[0]["baslik"];
                $kat = $linkSorgu[0]["baslik"];                   
                $degisecekler = array($ustKat,$kat,$baslik_oku[0]['baslik']);
                $degisenler = array("{{anaBaslik}}","{{altBaslik}}","{{baslik}}",); 
            }else if($sayfa=='arama'){
                // Arama sonuç sayfası
                $title = "Arama Sonuçları";
                if($_REQUEST['kelime']!='') $title = '"'.$_REQUEST['kelime'].'" - '.$title;
            }else if($sayfa=='etiketler'){
                // Etiket sayfası
                $title = "Etiket Sonuçları";
                if($this->urlcek(1)!='') $title = '"'.$this->urlcek(1).'" - '.$title;
            }else if($_SESSION["linkSistemi"]=='etkinlik'){
                $degisenler = array("{{anaBaslik}}","{{altBaslik}}","{{baslik}}"); 
            }else {
                // sabit sayfalar
                $baslik_oku = $this->sqlSorgu("SELECT * FROM ".PREFIX."baslik a JOIN ".PREFIX."baslik_dil b ON a.id=b.baslik_id WHERE b.dil_id= :dil_id and b.seflink= :seflink",array(":dil_id"=>$_SESSION["dil"],":seflink"=>$sayfa));
                $title = $baslik_oku[0]['title'];
                $description =  $baslik_oku[0]['aciklama'];
                $keywords =  $baslik_oku[0]['keywords'];
                $aktifsayfa = $baslik_oku[0]['baslik_id'];
                $meta_resim   =  $this->sqlSorgu("SELECT * FROM ".PREFIX."baslik_resim WHERE baslik_id= :baslik_id and boyut= :boyut order by id asc limit 1",array(":baslik_id"=>$baslik_oku[0]["baslik_id"],":boyut"=>1))[0]["resim_link"];
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."baslik a JOIN ".PREFIX."baslik_dil b ON a.id=b.baslik_id WHERE b.dil_id= :dil_id and b.baslik_id= :baslik_id",array(":dil_id"=>$_SESSION["dil"],":baslik_id"=>$baslik_oku[0]["ust_baslik_id"]));                      
                $ustKat = $linkUstSorgu[0]["baslik"];
                $kat = $baslik_oku[0]["baslik"]; 
                $degisecekler = array($ustKat,$kat,$baslik_oku[0]['baslik']);  
                $degisenler = array("{{anaBaslik}}","{{altBaslik}}","{{baslik}}"); 
            }
        }

        if($title!='') $title .= ' - ';
        if($meta_resim!='') $meta_resim = SITE_ADRESI.$meta_resim;              
        $data = array(
            "title"=>str_replace($degisenler, $degisecekler, stripslashes($title)),
            "description"=>str_replace($degisenler, $degisecekler, stripslashes($description)),
            "keywords"=>stripslashes($keywords),
            "meta_resim"=>$meta_resim,
            "aktifsayfaid"=>$aktifsayfa,
            "diger" => $sayfa,
            "linkSistemi"=>$_SESSION["linkSistemi"]
        );
        return $data;
    }   
    public  function header_cek(){
        //$this->html_sikistir();
        $model = $this->load->model("index_model");    
        $ayar = $model->ayarList() ;
        $seoAyar = $model->seoAyar() ;
        
        foreach ($seoAyar as $value) {
            $title = $value["title"];
            $keywords = $value["keywords"];
            $description = $value["aciklama"];
        }
        $degisecekler = array($ayar[0]["unvani"]);  
        $degisenler = array("{{firma_unvani}}"); 
        $data["title"] = str_replace($degisenler, $degisecekler, stripslashes($title));
        $data["orj_title"] = str_replace($degisenler, $degisecekler, stripslashes($title));
        $data["keywords"] = str_replace($degisenler, $degisecekler, stripslashes($keywords));
        $data["description"] = str_replace($degisenler, $degisecekler, stripslashes($description));

        $dinamik_data =  $this->dinamik_veriler();
        /*dinamik ayar*/
        if($this->urlcek(0)!=""){
            if($dinamik_data['title']!=''){ $data["title"] = str_replace($degisenler, $degisecekler, stripslashes($dinamik_data['title'].$data["title"]));}
            if($dinamik_data['description']!=''){ $data["description"] = str_replace($degisenler, $degisecekler, stripslashes($dinamik_data['description']));}
            if($dinamik_data['keywords']!=''){ $data["keywords"] = $dinamik_data['keywords'];}
        }else{            
            if($dinamik_data['title']!=''){ $data["title"] = $data["title"];}
            if($dinamik_data['description']!=''){ $data["description"] = $data["description"];}
            if($dinamik_data['keywords']!=''){ $data["keywords"] = $data["keywords"];}
        }
        if($dinamik_data['meta_resim']!=''){
            $data['meta_resim'] = $dinamik_data['meta_resim'];
        }else{
            $data['meta_resim'] = SITE_ADRESI."resimler/logo.png";
        }
        $data['aktif_sayfaid'] = $dinamik_data['aktifsayfaid'];
        $data['sitebilgi'] = $ayar[0];
        /**/
        $data["ustmenu"] = $model->baslikList(array("ust_baslik_id"=>"0"));
        $data["ustmenukategoriler"] = $model->kategoriList(array("ust_kategori_id"=>"0"));
        $data['suanki_link'] = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

        $this->view->render("header", $data);

    }
    public  function footer_cek($gelen_baslik){
        $model = $this->load->model("index_model");
        $data = array();
        $data["hizlimenu"] = $model->baslikList(array("ust_baslik_id"=>"0"));
        //$data["sonhaberler"] = $this->ortak_model->ortakSorgu("makale",array("join"=>"mak_id","limit"=>"2","dil"=>$_SESSION[dil]));
        $ayar = $model->ayarList();
        $data["sitebilgi"] = $ayar[0];
        $this->view->render("footer", $data);        
        echo $data["sitebilgi"]['analytics'];
        echo $this->popupModal($gelen_baslik[0]["popup_id"]);         
    }
    public function popupModal($id){
        $model = $this->load->model("index_model");
        $popup_oku = $model->popupModal($id);        
        $popup_oku = $popup_oku[0];
        $sayfa = $this->urlcek(0);
         if(($popup_oku['goster']=='2' || $_SESSION['popupgoster']!="1" ) and $popup_oku['durum']=='1'  ){?>  
        <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none;margin-top:2%;">
            <div class="modal-dialog">
                <div class="modal-content" style=" <?php if(!empty($popup_oku['width'])){  ?> width: <?=$popup_oku['width'];?>px;max-width: inherit;<?php } ?>
                    <?php if(!empty($popup_oku['height'])){  ?> min-height: <?=$popup_oku['height'];?>px;<?php } ?>

                    <?php if($popup_oku['resim"']!='' && $popup_oku['icerik']==''){
                        $rbilgiler = getimagesize($popup_oku['resim']);
                        ?>
                        width: <?=$rbilgiler[0];?>px;
                    <?php } ?>">
                    <!--<div class="modal-header">
                       
                        <h3 class="modal-title" id="myModalLabel2">Popup</h3>
                    </div>-->
                    <button type="button" class="popup_close" data-dismiss="modal" aria-hidden="true">×</button>
                    <div class="modal-body" >
                         <?php if($popup_oku['resim']!=''){ ?>
                            <?php if($popup_oku['link']!=''){ ?><a href="<?=$popup_oku['link']?>" target="_blank"><?php } ?>
                            <div class="popup_div_resim" style="max-height: <?=$popup_oku['height'];?>px;overflow: hidden;">
                                <img class="img-responsive" src="<?php echo $this->islemController->resimcek($popup_oku['resim'],$popup_oku['width'],$popup_oku['height'],1);?>" alt="">
                            </div>
                            <?php if($popup_oku['link']!=''){ ?></a><?php } ?>
                        <?php } ?>
                        <?php if($popup_oku['icerik']!=''){ ?>
                            <div class="popup_div_metin">
                                <h1><?=stripslashes($popup_oku['aciklama']);?></h1>
                                <h2><?=stripslashes($popup_oku['icerik']);?></h2>
                            </div>
                        <?php } ?>
                        <?php if($popup_oku['kod']!=''){ ?>
                            <div class="popup_div_embed"><?=stripslashes($popup_oku['kod']);?></div>
                        <?php } ?>

                        <div class="clear"></div>
                        <script>
                            $(document).ready(function () {
                                $('#popupModal').modal();
                            })
                        </script>                    
                    </div>
                             
                </div>
            </div>
        </div>
        <?php
        }
         $_SESSION['popupgoster'] = '1';  
    }
    public function sayfaBulunamadi(){
        $this->header_cek();
        $this->view->render("moduller/sayfalar/error");
        $this->footer_cek();  
    }   
}