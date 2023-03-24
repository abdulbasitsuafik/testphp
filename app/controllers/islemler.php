<?php
class islemler extends Controller {
    public function __construct() {
        parent::load();
        Session::init();
    }
    public function sqlSorgu($sql,$array){
        $model = $this->load->model("index_model");
        return $model->sqlSorgu($sql,$array);
    }
    public function tarih($tarih){
        $date = date("d-m-Y", $tarih);
        return $date;
    }
    public function urlcek($rank){
        $model = $this->load->model("index_model");
        $suanki_url = @$_GET['url'];
        $suanki_url = explode("/",$suanki_url);
        return @$suanki_url[$rank];
    }
    public function postcek($key){
        $form = $this->load->otherClasses("Form");
        $form->post($key);
        return $form->values[$key];
    }
    public function getcek($key){
        $form = $this->load->otherClasses("Form");
        $form->get($key);
        return $form->values[$key];
    }
    public function kisalt($data,$sayi){
        $form = $this->load->otherClasses("Form");
        if($data){ return $form->kisalt($data,$sayi); }
    }
    public function imageSize($image) {
       list($width, $height) = getimagesize($image);
       return array("width"=>$width,"height"=>$height);
    }
    public function dilcek(){
        $dilkod  = strtolower($_SESSION["lang_code"]);
        $dil_dosyasi = "system/language/".$dilkod."/dil.php";
        if(file_exists($dil_dosyasi)){
            require ($dil_dosyasi);
        }else{
//            $DEFAULT_LANG = strtolower($_SESSION['route']['default']['dil']);
            $dil_dosyasi = "system/language/tr/dil.php";
            require ($dil_dosyasi);
        }
        return $_;
    }
    public function base64_decode($content){
        return base64_decode($content);
    }
    public function hitArtir($id){
        $model = $this->load->model("index_model");
        $makale_hit = $model->makalehit($id);
        $yeniHit = $makale_hit[0]["hit"] + 1;
        $data = array("id"=>$id,"hit"=>$yeniHit);
        $model->hitArtir($data);
    }
    public function sayfalama($tablo,$sayfada,$p,$version){
        $sonuc = $this->sqlSorgu("SELECT COUNT(*) AS toplam FROM ".PREFIX.$tablo." a JOIN ".PREFIX.$tablo."_langs b ON a.id=b.".$tablo."_id WHERE b.lang= :lang and a.status= :status",array(":lang"=>1,":status"=>1));
        $toplam_content = $sonuc[0]['toplam'];
        $toplam_sayfa = ceil($toplam_content / $sayfada);

        // Sayfa değeri boş ise 1 olarak belirlensin
        $sayfa = isset($p) ? (int) $p : 1;
        // 1'den küçük bir sayfa değeri girildiyse 1 olsun.
        if($sayfa < 1){ $sayfa = 1;}
        // Toplam sayfa miktarından fazla bir değer girilirse son sayfa baz alınsın.
        if($sayfa > $toplam_sayfa){ $sayfa = $toplam_sayfa;}
        // Kaçıncı içerikten başlanacağını ifade eden limit değeri.
        $limit = ($sayfa - 1) * $sayfada;
        $sorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX.$tablo." a JOIN ".PREFIX.$tablo."_langs b ON a.id=b.".$tablo."_id WHERE b.lang= :lang and a.status= :status LIMIT " . $limit . ", " . $sayfada,array(":lang"=>$_SESSION["lang"],":status"=>1));
        foreach ($sorgu as $key => $value) {
            ?>
            <?php if($version!="1"){?>
                <div class="media">
                    <div class="media-left hidden-xs hidden-sm">
                        <img src="<?php echo $this->resimcek($value["manset_resmi"],200,155,1);?>" alt="<?php echo $value["title"]?>" class="media-object"/>
                    </div>
                    <div class="media-body">
                        <h2 class="media-heading"><?php echo $value["title"]?></h2>
                        <p><?php echo $this->kisalt($value["description"],250)?></p>

                        <div class="buttonlar">
                            <a class="teklif hidden" href="#"><i class="icon-pencil"></i> Teklif Ver</a>
                            <a class="content" href="<?php echo SITE_URL.$value["seflink"]?>"><i class="licon-arrow-right"></i> Detaylar</a>
                        </div>
                    </div>
                </div>
                <hr>
                <?php }else{?>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="liste">
                        <a href="<?php echo SITE_URL.$value["seflink"]?>">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="resim"><img src="<?php echo $this->resimcek($value["manset_resmi"],600,300,1);?>" alt="<?php echo $value["title"]?>" /></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="description">
                                        <h3><?php echo $this->kisalt($value["title"],70)?></h3>
                                        <h4><?php echo $this->kisalt($value["description"],100)?></h4>
                                        <div class="detay">detay</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php }?>
            <?php
        }

        // yukarıdan geldiği varsayılan değişkenler:
        // $toplam_sayfa ve $sayfa

        $sayfa_goster = 11; // gösterilecek sayfa sayısı

        $en_az_orta = ceil($sayfa_goster/2);
        $en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;

        $sayfa_orta = $sayfa;
        if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
        if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;

        $sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
        $sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta);

        if($sol_sayfalar < 1) $sol_sayfalar = 1;
        if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;

        ?>
            <nav aria-label="Page navigation">
              <ul class="pagination">
                <?php if($sayfa != 1){?>
                    <li>
                      <a href="?p=1" aria-label="İlk sayfa">
                        <span aria-hidden="true">&lt;&lt; İlk sayfa</span>
                      </a>
                    </li>
                <?php }?>
                <?php if($sayfa != 1){?>
                    <li>
                      <a href="?p=<?php echo ($sayfa-1);?>" aria-label="Önceki">
                        <span aria-hidden="true">&lt; Önceki</span>
                      </a>
                    </li>
                <?php }?>
                <?php for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
                        if($sayfa == $s) {?>
                        <li class="active"><a>[<?php echo $s;?>]</a></li>
                        <?php } else {?>
                        <li><a href="?p=<?php echo $s;?>"><?php echo $s;?></a></li>
                        <?php }
                    }?>
                <?php if($sayfa != $toplam_sayfa){?>
                    <li>
                      <a href="?p=<?php echo ($sayfa+1);?>" aria-label="Sonraki">
                        <span aria-hidden="true">Sonraki &gt;</span>
                      </a>
                    </li>
                <?php }?>
                <?php if($sayfa != $toplam_sayfa){?>
                    <li>
                      <a href="?p=<?php echo $toplam_sayfa;?>" aria-label="Son sayfa">
                        <span aria-hidden="true">Son sayfa &gt;&gt;</span>
                      </a>
                    </li>
                <?php }?>
              </ul>
            </nav>
        <?php
    }
    public function anasayfaCek(){
        $anasayfa = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang = :lang and a.status= :status order by a.rank ASC limit 1",array(":lang"=>$_SESSION["lang"],":status"=>1));
        return $anasayfa[0];
    }
    public function breadcrumbCek($active_page_details){
        if($_SESSION["url_system"]=='makale'){
            $headlines_oku      = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>str_replace(",", "", $active_page_details["head_ids"])));
        }else if($_SESSION["url_system"]=='headlines'){
            $headlines_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$active_page_details["top_head_id"]));
        }else if($_SESSION["url_system"]=='urun'){
             $headlines_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>str_replace(",", "", $active_page_details["head_ids"])));
        }else if($_SESSION["url_system"]=='proje_headlines'){
            $headlines_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_headlines a JOIN ".PREFIX."proje_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$active_page_details["top_head_id"]));
        }else if($_SESSION["url_system"]=='proje'){
             $headlines_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_headlines a JOIN ".PREFIX."proje_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>str_replace(",", "", $active_page_details["head_ids"])));
        }else if($_SESSION["url_system"]=='hizmet_headlines'){
            $headlines_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_headlines a JOIN ".PREFIX."hizmet_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$active_page_details["top_head_id"]));
        }else if($_SESSION["url_system"]=='hizmet'){
             $headlines_oku     = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_headlines a JOIN ".PREFIX."hizmet_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>str_replace(",", "", $active_page_details["head_ids"])));
        }else{
            $headlines_oku = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>@$_SESSION["lang"],":head_id"=>@$active_page_details["top_head_id"]));
        }
        $anasayfa = $this->anasayfaCek();
        ?>
        <ol style="float: left;margin-top: -5px;" class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="<?php echo SITE_URL.$anasayfa["seflink"];?>">
                    <span itemprop="name"><?php echo $anasayfa["title"];?></span>
                    <span class="ayrac"></span>
                    <meta itemprop="position" content="1">
                </a>
            </li>
            <?php if(count($headlines_oku) > 0){?>
              <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="<?php echo SITE_URL.$headlines_oku[0]["seflink"];?>">
                    <span itemprop="name"><?php echo $headlines_oku[0]["title"];?></span>
                    <span class="ayrac"></span>
                    <meta itemprop="position" content="2">
                </a>
            </li>
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="active">
                <span itemprop="name"><?php echo $active_page_details["title"];?></span>
                <span class="ayrac"></span>
                <meta itemprop="position" content="3">
            </li>
            <?php }else{?>
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="active">
                <span itemprop="name"><?php echo $active_page_details["title"];?></span>
                <span class="ayrac"></span>
                <meta itemprop="position" content="2">
            </li>
            <?php }?>
        </ol>
        <?php
    }
    public function languagesGetir($sekil,$rescesit){
        $sayfa = $this->urlcek(0);
        if($this->urlcek(1)!='' && $this->urlcek(2)=='') $sayfa = $this->urlcek(1);
        if($this->urlcek(2)!='') $sayfa = $this->urlcek(2);
        $tablo = $_SESSION["url_system"];
        if($tablo=="hizmet_headlines" || $tablo=="proje_headlines"){$tablo2 = "headlines";}else{$tablo2 = $tablo;}
        $languages =  $this->sqlSorgu("SELECT * FROM ".PREFIX."languages WHERE status= :status order by rank ASC",array(":status"=>1));
        if($sayfa==""){
            $mevcutheadlines =  $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang order by a.rank ASC limit 1",array(":lang"=>$_SESSION["lang"]));
        }else{
            $mevcutheadlines = $this->sqlSorgu("SELECT * FROM ".PREFIX.$_SESSION["url_system"]." a JOIN ".PREFIX.$_SESSION["url_system"]."_langs b ON a.id=b.head_id WHERE b.seflink= :seflink",array(":seflink"=>$sayfa));
        }
        foreach ($languages as $key => $value) {
            $digerheadlines = $this->sqlSorgu("SELECT * FROM ".PREFIX.$_SESSION["url_system"]." a JOIN ".PREFIX.$_SESSION["url_system"]."_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :gelen_id",array(":lang"=>$value["rank"],":gelen_id"=>$mevcutheadlines[0]["head_id"]));
            if($_SESSION["url_system"]=='makale'){ $ust_id = "head_ids";
            }else if($_SESSION["url_system"]=='headlines' or $_SESSION["url_system"]=='proje_headlines' or $_SESSION["url_system"]=='hizmet_headlines'){
                $ust_id = "top_head_id";
            }else if($_SESSION["url_system"]=='urun' or $_SESSION["url_system"]=='proje' or $_SESSION["url_system"]=='hizmet'){$ust_id = "head_ids";
            }else{ $ust_id = "top_head_id"; }
            $ustheadlines = $this->sqlSorgu("SELECT * FROM ".PREFIX.$_SESSION["url_system"]." a JOIN ".PREFIX.$_SESSION["url_system"]."_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :gelen_id",array(":lang"=>$value["rank"],":gelen_id"=>$digerheadlines[0][$ust_id]));
            if(count($ustheadlines) > 0){ $link = SITE_URL.$ustheadlines[0]["seflink"]."/".$digerheadlines[0]["seflink"];
            }else{ $link = SITE_URL.$digerheadlines[0]["seflink"]; }
            if($sekil=="resim"){ $bayrakRes = '<img src="'.SITE_URL.'public/images/bayraklar/'.$rescesit.'/dil_'.$value["code"].'.png"> '.$value["code"];
            }else{ $bayrakRes = $value["code"];  } ?>
            <li><a href="<?php echo $link;?>"><?php echo $bayrakRes;?></a></li>
   <?php }
    }
    public function resimcek($resim,$w,$h,$zc=null,$q=null){
        if(strstr($resim, ".gif")){
            $resim_yeni = SITE_URL.$resim;
        }else{
            if(file_exists($resim)){
                $resim_yeni =  SITE_URL."thumb/".$resim;
                if($w!='')$resim_yeni.="/w".$w;
                if($h!='')$resim_yeni.="/h".$h;
                if($zc!='')$resim_yeni.="/zc".$zc;
                if($q!='')$resim_yeni.="/q".$q;
            }else{
                $resim_yeni =  SITE_URL."public/images/resimyok.jpg";
                if($w!='')$resim_yeni.="/w".$w;
                if($h!='')$resim_yeni.="/h".$h;
                if($zc!='')$resim_yeni.="/zc".$zc;
            }
        }
        return $resim_yeni;
    }
    public function ilkaltmenu($id){
        $model = $this->load->model("index_model");
        $ilkheadlines = $model->ilkAltMenu($id);
        return $ilkheadlines[0]["seflink"];
    }
    public function ustMenu($duzen,$aktif_sayfa,$limit=""){
        $model = $this->load->model("index_model");
        $ustmenu = @$model->menuList($duzen,"0",@$_SESSION["lang"],$limit);
            foreach ($ustmenu as $key => $value) {
                $altmenu = @$this->altmenu_fnc($duzen,$value["head_id"]);
                //$altmenu_urunler =  $this->altmenu_urunler_fnc($value["head_id"],'2',true);
                //$altmenu_projeler =  $this->altmenu_projeler_fnc($value["head_id"],'3',true);
                //$altmenu_hizmetler =  $this->altmenu_hizmetler_fnc($value["head_id"],'4',true);
                $ilkaltmenu = @$model->ilkAltMenu($duzen,$value["head_id"])[0]["seflink"];
                //$dropdownClassName = "dropdown";
                $dropdownClassName = "has-submenu";
                //$aTags_in = 'class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"';
                $aTags_in = "";
                $tick = '<i class="fas fa-chevron-down"></i>';
                $link = @$this->linkSor($value);
                      if( $value["link"]!=''){ $yenilink = $link;
                }else if(@$value["first_bottom_head"] == '1'){ $yenilink = SITE_URL.$value["seflink"]."/".$ilkaltmenu;
                }else{ $yenilink = SITE_URL.$value["seflink"]; }
                if ($altmenu["varmi"] == '1' || @$altmenu_urunler["varmi"] == '1' || @$altmenu_projeler["varmi"]=='1' || @$altmenu_hizmetler["varmi"]=='1'){
                    $yeniHref = "";$dropdownClass = $dropdownClassName;$aSpan = $tick;$aTags = $aTags_in;
                }else{ $yeniHref = 'href="'.$yenilink.'"';$dropdownClass = "";$aSpan = "";$aTags = ""; }
                if ($aktif_sayfa == $value["seflink"] || ($value["head_id"] == '1' and $this->urlcek(0)=="")){$liActive = "active";}else{$liActive ="";}
                if($value["link_opening"]!=""){ $aTarget = 'target="'.$value["link_opening"].'"'; }else{$aTarget ="";}
                ?>

                <li class="nav-item <?php echo @$dropdownClass;?> <?php echo @$liActive;?> <?php if ($value["rank"] =='2'){ ?>bosluklu-menu<?php }?>">
                    <a class='nav-link' <?php echo @$yeniHref;?> <?php echo @$aTags;?> <?php echo @$aTarget;?>><?php echo @$value["title"];?> <?php echo @$aSpan;?> </a>

                    <?php
                        if ($altmenu["varmi"]=='1'){
                            $this->altmenu_yazdir($duzen,$value["head_id"],$value["seflink"]);
                        }
                        if (@$altmenu_urunler["varmi"]=='1'){
                            $this->altmenu_yazdir($duzen,$value["head_id"],$value["seflink"]);
                            //$this->altmenu_yazdir_resimli($duzen,$value["head_id"],$value["seflink"]);
                        }
                        if (@$altmenu_projeler["varmi"]=='1'){
                            $this->altmenu_yazdir($duzen,$value["head_id"],$value["seflink"]);
                            //$this->altmenu_yazdir_resimli($duzen,$value["head_id"],$value["seflink"]);
                        }
                        if (@$altmenu_hizmetler["varmi"]=='1'){
                            $this->altmenu_yazdir($duzen,$value["head_id"],$value["seflink"]);
                            //$this->altmenu_yazdir_resimli($duzen,$value["head_id"],$value["seflink"]);
                        }
                    ?>
                </li>
             <?php
            }
    }
    public function altmenu_fnc($duzen,$id,$durum = true) {
        $model = $this->load->model("index_model");
        if($duzen=="headlines"){
            $all_headlines= $model->acilmayacaklar();
            foreach ($all_headlines as $value) {
                @$acilmayacaklar[] = @$value["head_id"];
            }
        }
            if(@$id!=''  && @!in_array(@$id,@$acilmayacaklar) && @$durum){
                // Değer doluysa ve deger 1 değilse(anasayfanın id si değilse)
                $alt_menu_oku = @$model->menuList(@$duzen,@$id,@$_SESSION["lang"]);
                if(!empty(@$alt_menu_oku)){
                    $sonuc = array("varmi"=>"1","veriler"=>@$alt_menu_oku);
                }else{
                    $sonuc = array("varmi"=>"0");
                }
            }else{
                $sonuc = array("varmi"=>"0");
            }
        return $sonuc;
    }
    public function altmenu_yazdir($duzen,$head_id,$ana_seflink){
        $islemlerModel = $this->load->model("index_model");
        $altmenu         = $this->altmenu_fnc($duzen,$head_id);
        //$altmenu_urunler = $this->altmenu_urunler_fnc($head_id,"2",true);
        //$altmenu_projeler =  $this->altmenu_projeler_fnc($head_id,'3',true);
        //$altmenu_hizmetler =  $this->altmenu_hizmetler_fnc($head_id,'4',true);
        $altgoster = @$altmenu["veriler"][0]["bottom_status"];
//        $dropdownMenu = "dropdown-menu";
        $dropdownMenu = "submenu";
        if($altmenu['varmi']=='1'){ ?>
            <ul class="<?php echo $dropdownMenu;?>">
                <?php
                foreach ($altmenu['veriler'] as $key => $value){
                    $altmenu2         = $this->altmenu_fnc($duzen,$value["head_id"]);
                    $ilkaltmenu = @$islemlerModel->ilkAltMenu($duzen,$value["head_id"])[0]["seflink"];
                    $link  = $this->linkSor($value);
                    ?>
                <li><a <?php if($value["link_opening"]!=""){ ?> target="<?php echo $value["link_opening"];?>"<?php }?>
                            <?php if($altmenu2['varmi']!='1'){ ?>
                                href="<?php if($value['link']!=''){?><?php echo $link;?><?php }elseif($value['first_bottom_head']=="1"){?><?=SITE_URL;?><?php echo $ilkaltmenu;?><?php }else{?><?=SITE_URL;?><?=$value['seflink']?><?php }?>"
                            <?php } ?>
                        ><?=$value["title"];?></a>
                        <?=$this->altmenu_yazdir($duzen,$value["head_id"],$ana_seflink);?>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
        if(@$altmenu_urunler['varmi']=='1'){ ?>
            <ul>
                <?php
                foreach (@$altmenu_urunler['veriler'] as $key => $value){
                    ?>
                    <li><a href="<?=$value['link'];?>"><?=$value["title"];?></a></li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
        if(@$altmenu_projeler['varmi']=='1'){ ?>
            <ul>
                <?php
                foreach (@$altmenu_projeler['veriler'] as $key => $value){
                    ?>
                    <li><a href="<?=$value['link'];?>"><?=$value["title"]?></a></li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
        if(@$altmenu_hizmetler['varmi']=='1'){ ?>
            <ul>
                <?php
                foreach (@$altmenu_hizmetler['veriler'] as $key => $value){
                    ?>
                    <li><a href="<?=$value['link'];?>"><?=$value["title"]?></a></li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
    }
    public function altmenu_yazdir_resimli($duzen,$head_id,$ana_seflink){
        $islemlerModel = $this->load->model("index_model");
        $altmenu         = $this->altmenu_fnc($duzen,$head_id);
        //$altmenu_urunler = $this->altmenu_urunler_fnc($head_id,"2",true);
        //$altmenu_projeler =  $this->altmenu_projeler_fnc($head_id,'3',true);
        //$altmenu_hizmetler =  $this->altmenu_hizmetler_fnc($head_id,'4',true);
        $altgoster = $altmenu["veriler"][0]["bottom_status"];

        if($altmenu['varmi']=='1'){ ?>
            <ul class="dropdown-menu">
                <?php
                foreach ($altmenu['veriler'] as $key => $value){
                    $altmenu2         = $this->altmenu_fnc($duzen,$value["head_id"]);
                    $ilkaltmenu = $islemlerModel->ilkAltMenu($duzen,$value["head_id"])[0]["seflink"];
                    ?>
                 <li><a <?php if($value["link_opening"]!=""){ ?> target="<?php echo $value["link_opening"];?>"<?php }?>
                            <?php if($altmenu2['varmi']!='1'){ ?>
                                href="<?php if($value['link']!=''){?><?php echo $value['link'];?><?php }elseif($value['first_bottom_head']=="1"){?><?=SITE_URL;?><?php echo $ilkaltmenu;?><?php }else{?><?=SITE_URL;?><?=$ana_seflink?>/<?=$value['seflink']?><?php }?>"
                            <?php } ?>
                        ><?=$value["title"];?></a>
                        <?=$this->altmenu_yazdir_resimli($duzen,$value["head_id"],$ana_seflink);?>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
        if($altmenu_urunler['varmi']=='1'){ ?>
            <ul class="dropdown-menu">
                <?php
                foreach ($altmenu_urunler['veriler'] as $key => $value){print_r($altmenu_urunler['veriler'][0][alt_headlines][0]["seflink"]);
                    ?>

                        <div class="acilir_urun">
                            <a href="<?=$value['link'];?>">
                                <span class="resim"><img src="<?php echo SITE_URL;?><?php echo $value["headlines_resmi"];?>" alt="<?php echo $value["title"];?>"></span>
                                <span class="hover">
                                    <i class="icon-search"></i>
                                </span>
                                <span class="headlines"><?=$value["title"];?></span>
                            </a>
                        </div>

                    <?php
                }
                ?>
            </ul>
            <?php
        }
        if($altmenu_projeler['varmi']=='1'){ ?>
            <ul class="dropdown-menu">
                <?php
                foreach ($altmenu_projeler['veriler'] as $key => $value){print_r($altmenu_projeler['veriler'][0][alt_headlines][0]["seflink"]);
                    ?>

                        <div class="acilir_urun">
                            <a href="<?=$value['link'];?>">
                                <span class="resim"><img src="<?php echo SITE_URL;?><?php echo $value["headlines_resmi"];?>" alt="<?php echo $value["title"];?>"></span>
                                <span class="hover">
                                    <i class="icon-search"></i>
                                </span>
                                <span class="headlines"><?=$value["title"];?></span>
                            </a>
                        </div>

                    <?php
                }
                ?>
            </ul>
            <?php
        }
         if($altmenu_hizmetler['varmi']=='1'){ ?>
            <ul class="dropdown-menu">
                <?php
                foreach ($altmenu_hizmetler['veriler'] as $key => $value){print_r($altmenu_hizmetler['veriler'][0][alt_headlines][0]["seflink"]);
                    ?>

                        <div class="acilir_urun">
                            <a href="<?=$value['link'];?>">
                                <span class="resim"><img src="<?php echo SITE_URL;?><?php echo $value["headlines_resmi"];?>" alt="<?php echo $value["title"];?>"></span>
                                <span class="hover">
                                    <i class="icon-search"></i>
                                </span>
                                <span class="headlines"><?=$value["title"];?></span>
                            </a>
                        </div>

                    <?php
                }
                ?>
            </ul>
            <?php
        }
    }
    public function altmenu_urunler_fnc($head_id,$urunler_head_id,$durum = false){
        if($head_id==$urunler_head_id && $durum){
            $sayfa_oku = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.head_id = :head_id and b.lang= :lang order by id ASC limit 1",array(":head_id"=>$urunler_head_id,":lang"=>$_SESSION["lang"]));
            $headlines_listesi = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE a.top_head_id = :top_head_id and b.lang= :lang order by rank ASC",array(":top_head_id"=>"0",":lang"=>$_SESSION["lang"]));

            foreach ($headlines_listesi as $key => $headlines_oku) {
                $alt_headlines = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE a.top_head_id = :top_head_id and b.lang= :lang order by a.rank ASC",array(":top_head_id"=>$headlines_oku["head_id"],":lang"=>$_SESSION["lang"]));
                if($alt_headlines > 0){
                    $link = SITE_URL.$headlines_oku['seflink']."/".$alt_headlines[0]["seflink"] ;
                }else{
                    $link = SITE_URL.$headlines_oku['seflink'];
                }
                $veriler[] = array("link"=>$link,"headlines"=>$headlines_oku['title'],"headlines_resmi"=>$headlines_oku['headlines_resmi']);
            }
        }else{
            $sonuc = array("varmi"=>"0");
        }
        if(is_array($veriler)){
            $sonuc = array("varmi"=>"1","veriler"=>$veriler);
        }
        return $sonuc;
    }
    public function altmenu_projeler_fnc($head_id,$urunler_head_id,$durum = false){
        if($head_id==$urunler_head_id && $durum){
            $sayfa_oku = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.head_id = :head_id and b.lang= :lang order by id ASC limit 1",array(":head_id"=>$urunler_head_id,":lang"=>$_SESSION["lang"]));
            $headlines_listesi = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_headlines a JOIN ".PREFIX."proje_headlines_langs b ON a.id=b.head_id WHERE a.top_head_id = :top_head_id and b.lang= :lang order by rank ASC",array(":top_head_id"=>"0",":lang"=>$_SESSION["lang"]));

            foreach ($headlines_listesi as $key => $headlines_oku) {
                $alt_headlines = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_headlines a JOIN ".PREFIX."proje_headlines_langs b ON a.id=b.head_id WHERE a.top_head_id = :top_head_id and b.lang= :lang order by a.rank ASC",array(":top_head_id"=>$headlines_oku["head_id"],":lang"=>$_SESSION["lang"]));
                if($alt_headlines > 0){
                    $link = SITE_URL.$headlines_oku['seflink']."/".$alt_headlines[0]["seflink"] ;
                }else{
                    $link = SITE_URL.$headlines_oku['seflink'];
                }
                $veriler[] = array("link"=>$link,"headlines"=>$headlines_oku['title'],"headlines_resmi"=>$headlines_oku['headlines_resmi']);
            }
        }else{
            $sonuc = array("varmi"=>"0");
        }
        if(is_array($veriler)){
            $sonuc = array("varmi"=>"1","veriler"=>$veriler);
        }
        return $sonuc;
    }
    public function altmenu_hizmetler_fnc($head_id,$urunler_head_id,$durum = false){
        if($head_id==$urunler_head_id && $durum){
            $sayfa_oku = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.head_id = :head_id and b.lang= :lang order by id ASC limit 1",array(":head_id"=>$urunler_head_id,":lang"=>$_SESSION["lang"]));
            $headlines_listesi = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_headlines a JOIN ".PREFIX."hizmet_headlines_langs b ON a.id=b.head_id WHERE a.top_head_id = :top_head_id and b.lang= :lang order by rank ASC",array(":top_head_id"=>"0",":lang"=>$_SESSION["lang"]));

            foreach ($headlines_listesi as $key => $headlines_oku) {
                $alt_headlines = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_headlines a JOIN ".PREFIX."hizmet_headlines_langs b ON a.id=b.head_id WHERE a.top_head_id = :top_head_id and b.lang= :lang order by a.rank ASC",array(":top_head_id"=>$headlines_oku["head_id"],":lang"=>$_SESSION["lang"]));
                if($alt_headlines > 0){
                    $link = SITE_URL.$headlines_oku['seflink']."/".$alt_headlines[0]["seflink"] ;
                }else{
                    $link = SITE_URL.$headlines_oku['seflink'];
                }
                $veriler[] = array("link"=>$link,"headlines"=>$headlines_oku['title'],"headlines_resmi"=>$headlines_oku['headlines_resmi']);
            }
        }else{
            $sonuc = array("varmi"=>"0");
        }
        if(is_array($veriler)){
            $sonuc = array("varmi"=>"1","veriler"=>$veriler);
        }
        return $sonuc;
    }
    public function altsayfa_kontrol($sayfa="",$status=""){
        if($durum){
            $altsayfa         = @$this->altmenu_fnc(@$sayfa['head_id']);
            if($altsayfa['varmi']=='1'){
                $altsayfa_ilkkayit = $altsayfa['veriler'][0];
                $link = SITE_URL.$sayfa['seflink'].'/'.$altsayfa_ilkkayit['seflink'];
                // header('Location: '.$link);
                ?>
                <script>
                    window.location = "<?=$link;?>";
                </script>
                <?php
            }
        }
    }
    public function tr_aycek($veriler) {
        setlocale(LC_TIME, "turkish");
        $str = strftime("%B ");
        $str=iconv("ISO-8859-9","UTF-8",$str);
        return $str;
    }
    public function videoresim_getir($video_kod){
        $youtubevideo =$video_kod;
        $videokalite = "mqdefault"; //maxresdefault, sddefault, hqdefault, default, 3, 2, 1, 0
        if($youtubevideo){
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtubevideo, $match)) {
                $video_id = $match[1];
            }
        }
        return "http://img.youtube.com/vi/".$video_id."/".$videokalite.".jpg";
    }
    public function video_getir($video_kod,$width,$height){
        $youtubevideo =$video_kod;
        $videokalite = "mqdefault"; //maxresdefault, sddefault, hqdefault, default, 3, 2, 1, 0
        if($youtubevideo){
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtubevideo, $match)) {
                $video_id = $match[1];
            }
        }
        return '<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allowfullscreen></iframe>';
    }
    public function linkSor($value){
        if($value["link_selected"] == "ic"){
            if($value["inlink_type"]=="headlines"){
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$value["link"]));
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$linkSorgu[0]["top_head_id"]));
                if(count($linkUstSorgu) > 0){
                    $link = SITE_URL.$linkUstSorgu[0]["seflink"]."/".$linkSorgu[0]["seflink"];
                }else{
                    $link = SITE_URL.$linkSorgu[0]["seflink"];
                }
            }else if($value["inlink_type"]=="headlines"){
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$value["link"]));
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."headlines a JOIN ".PREFIX."headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$linkSorgu[0]["top_head_id"]));
                if(count($linkUstSorgu) > 0){
                    $link = SITE_URL.$linkUstSorgu[0]["seflink"]."/".$linkSorgu[0]["seflink"];
                }else{
                    $link = SITE_URL.$linkSorgu[0]["seflink"];
                }
            }else if($value["inlink_type"]=="proje_headlines"){
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_headlines a JOIN ".PREFIX."proje_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$value["link"]));
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_headlines a JOIN ".PREFIX."proje_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$linkSorgu[0]["top_head_id"]));
                if(count($linkUstSorgu) > 0){
                    $link = SITE_URL.$linkUstSorgu[0]["seflink"]."/".$linkSorgu[0]["seflink"];
                }else{
                    $link = SITE_URL.$linkSorgu[0]["seflink"];
                }
            }else if($value["inlink_type"]=="hizmet_headlines"){
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_headlines a JOIN ".PREFIX."hizmet_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$value["link"]));
                $linkUstSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_headlines a JOIN ".PREFIX."hizmet_headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id",array(":lang"=>$_SESSION["lang"],":head_id"=>$linkSorgu[0]["top_head_id"]));
                if(count($linkUstSorgu) > 0){
                    $link = SITE_URL.$linkUstSorgu[0]["seflink"]."/".$linkSorgu[0]["seflink"];
                }else{
                    $link = SITE_URL.$linkSorgu[0]["seflink"];
                }
            }else if($value["inlink_type"]=="urun"){
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."urun a JOIN ".PREFIX."urun_dil b ON a.id=b.urun_id WHERE b.lang= :lang and b.urun_id= :urun_id",array(":lang"=>$_SESSION["lang"],":urun_id"=>$value["link"]));
                $link = SITE_URL.$linkSorgu[0]["seflink"];
            }else if($value["inlink_type"]=="proje"){
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje a JOIN ".PREFIX."proje_dil b ON a.id=b.proje_id WHERE b.lang= :lang and b.proje_id= :proje_id",array(":lang"=>$_SESSION["lang"],":proje_id"=>$value["link"]));
                $link = SITE_URL.$linkSorgu[0]["seflink"];
            }else if($value["inlink_type"]=="hizmet"){
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet a JOIN ".PREFIX."hizmet_dil b ON a.id=b.hizmet_id WHERE b.lang= :lang and b.hizmet_id= :hizmet_id",array(":lang"=>$_SESSION["lang"],":hizmet_id"=>$value["link"]));
                $link = SITE_URL.$linkSorgu[0]["seflink"];
            }else if($value["inlink_type"]=="haber"){
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."makale a JOIN ".PREFIX."makale_dil b ON a.id=b.makale_id WHERE b.lang= :lang and b.makale_id= :makale_id",array(":lang"=>$_SESSION["lang"],":makale_id"=>$value["link"]));
                $link = SITE_URL.$linkSorgu[0]["seflink"];
            }else if($value["inlink_type"]=="etkinlik"){
                $linkSorgu = $this->sqlSorgu("SELECT * FROM ".PREFIX."etkinlik a JOIN ".PREFIX."etkinlik_dil b ON a.id=b.etkinlik_id WHERE b.lang= :lang and b.etkinlik_id= :etkinlik_id",array(":lang"=>$_SESSION["lang"],":urun_id"=>$value["link"]));
                $link = SITE_URL.$linkSorgu[0]["seflink"];
            }
        }else{
            $link = $value["link"];
        }
        return $link;
    }
    public function enust_headlines($tablo,$id){
        if($tablo=="hizmet_headlines" || $tablo=="proje_headlines"){$tablo2 = "headlines";}else{$tablo2 = $tablo;}
        $ustheadlinesler = $this->sqlSorgu("SELECT * FROM ".PREFIX.$tablo." WHERE id = :id and status= :status limit 1",array(":id"=>$id,":status"=>1));
        if($ustheadlinesler[0]["top_head_id"]!="" and $ustheadlinesler[0]["top_head_id"]!="0"){
            $array = $this->enust_headlines($tablo,$ustheadlinesler[0]["top_head_id"]);
        }else{
            $array = $ustheadlinesler[0]["id"];
        }
        return $array;
    }
    public function get_sidebar_menu($data){
        $model = $this->load->model("index_model");
        $form = $this->load->otherClasses("Form");
        if($this->urlcek(1)!=""){
            $gelensef =$this->urlcek(1);
        }else if($this->urlcek(0)!=""){
            $gelensef =$this->urlcek(0);
        }
        $tablo = $data["tablo"];
        $urun_kat_id = str_replace(",","",@$data["active_page_details"]["head_ids"]);
        $solbosluk = "0";
         $sonuc = $this->sqlSorgu("SELECT * FROM ".PREFIX.$tablo." a JOIN ".PREFIX.$tablo."_langs b ON a.id = b.head_id WHERE b.lang= :lang and a.top_head_id = :top_head_id and a.status= :status order by a.rank ASC",array(":top_head_id"=>$data['top_head_id'],":lang"=>$_SESSION["lang"],":status"=>1));
        if($sonuc > 0) {
            ?>
            <ul>
                <?php foreach ($sonuc as $key => $value) {
                    $link2 = $this->linkSor($value);
                    $data2                    = $data;
                    $data2['top_head_id'] = $value["head_id"];
                    $data2['solbosluk']       = $solbosluk  + 10;
                    $altheadlinesler = $this->sqlSorgu("SELECT * FROM ".PREFIX.$tablo." a JOIN ".PREFIX.$tablo."_langs b ON a.id = b.head_id WHERE b.lang= :lang and a.top_head_id = :top_head_id order by a.rank ASC",array(":top_head_id"=>$value["head_id"],":lang"=>$_SESSION["lang"]));
                    $alt_headlines_varmi          = count($altheadlinesler);

                    if($value["link"]!=""){
                        if ($alt_headlines_varmi == 0) {
                            $link = $link2;
                        }else{ $link = 'javascript:void(0);'; }
                    }else{
                        if ($alt_headlines_varmi == 0) {
                            $link = SITE_URL.$value['seflink'];
                        }else{ $link = 'javascript:void(0);'; }
                    }
                    ?>
                    <li class="<?php if($gelensef==$value['seflink'] || $value["head_id"]==$urun_kat_id){echo'active';} ?>" style="padding-left: <?=$data['solbosluk']?>px;">
                        <a href="<?=$link;?>">
                            <?php if ($alt_headlines_varmi > 0) { ?><i class="fa fa-angle-right" ></i><?php } ?>
                            <?= $value["title"] ?>
                        </a>
                        <?php if ($alt_headlines_varmi > 0) $this->solmenu_headlinescek($data2); ?>
                    </li>
                <?php } ?>
            </ul>
            <?php
        }
    }
    public function degisencek($seflink){
        $degisencek = $this->sqlSorgu("Select * from ".PREFIX."degisen a JOIN ".PREFIX."degisen_dil b ON a.id=b.degisen_id WHERE b.seflink= :seflink and b.lang= :lang ",array(":seflink"=>$seflink,":lang"=>$_SESSION["lang"]));
        return $degisencek[0]['title'];
    }
    public function sosyalMedya(){
        $model = $this->load->model("index_model");
        $ayar = $model->ayarList();
        ?>
        <?php if(!empty($ayar[0]["facebook"])){?>
            <li><a href="<?php echo $ayar[0]["facebook"];?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
        <?php }?>
        <?php if(!empty($ayar[0]["twitter"])){?>
            <li><a href="<?php echo $ayar[0]["twitter"];?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
        <?php }?>
        <?php if(!empty($ayar[0]["whatsapp"])){?>
            <li><a href="<?php echo $ayar[0]["whatsapp"];?>" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
        <?php }?>
        <?php if(!empty($ayar[0]["instagram"])){?>
            <li><a href="<?php echo $ayar[0]["instagram"];?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
        <?php }?>
        <?php if(!empty($ayar[0]["youtube"])){?>
            <li><a href="<?php echo $ayar[0]["youtube"];?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
        <?php }?>
        <?php if(!empty($ayar[0]["pinterest"])){?>
            <li><a href="<?php echo $ayar[0]["pinterest"];?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
        <?php }?>
        <?php if(!empty($ayar[0]["skype"])){?>
            <li><a href="<?php echo $ayar[0]["skype"];?>" target="_blank"><i class="fa fa-skype"></i></a></li>
        <?php }?>
        <?php if(!empty($ayar[0]["linkedin"])){?>
            <li><a href="<?php echo $ayar[0]["linkedin"];?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
        <?php }?>
        <?php if(!empty($ayar[0]["googleplus"])){?>
            <li><a href="<?php echo $ayar[0]["googleplus"];?>" target="_blank"><i class="fa fa-google-plus"></i></a>  </li>
        <?php }?>
        <?php
    }
    public function sosyalmedya_butonlar(){
        $active_link = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        ?>
        <style>
            .haber-sosyal{margin-bottom:30px}
            .haber-sosyal a.facebook{width:68px;height:20px;float:right;margin:0 0 0 5px;background:url(<?php echo SITE_URL.ANA_ASSETS;?>img/paylas_icon.png) -68px 0 no-repeat;cursor:pointer;text-indent:-99999px}
            .haber-sosyal a.twitter{width:68px;height:20px;float:right;background:url(<?php echo SITE_URL.ANA_ASSETS;?>img/paylas_icon.png) 0 0 no-repeat;cursor:pointer;text-indent:-99999px}
            .haber-sosyal div.googleplus{width:auto;height:20px;float:left}
            .haber-sosyal div.twitter{width:auto;height:20px;float:left;margin-right:10px}
            .haber-sosyal div.facebook{width:auto;height:20px;float:left}
        </style>
        <div class="row">
            <div class="haber-sosyal col-md-12">
                <script type="text/javascript">
                    function fbs_click(){
                        u = "<?=$active_link;?>";
                        t = $('html').filter('title').text();
                        window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t), 'facebook', 'toolbar=0,status=0,width=626,height=436');
                        return false;
                    }
                    function twt_click(){
                        s = "<?=$active_link;?>";
                        t = $('html').filter('title').text();
                        window.open('http://www.twitter.com/?status=' + encodeURIComponent(t) + ' - ' + encodeURIComponent(s), 'twitter', 'toolbar=0,status=0,width=626,height=436');
                        return false;
                    }
                </script>
                <a onclick="fbs_click()" class="facebook">Facebook</a>
                <a onclick="twt_click()" class="twitter">Twitter</a>
            </div>
        </div>
        <?php
    }
    /*form yapisi*/
    public function mobilKontrol(){
        $detect = $this->load->otherClasses("Mobile_Detect");
        if ( $detect->isMobile() ) {
            $mobilKontrol = "1";
        }else{
            $mobilKontrol = "0";
        }
        return $mobilKontrol;
    }
    public function formCek($id){
        $Guvenlikkodu = $this->load->otherClasses("Guvenlikkodu");
        $formCek = $this->sqlSorgu("SELECT * FROM ".PREFIX."form_alani WHERE form_id = :form_id order by alan_no ASC",array(":form_id"=>$id));
        $formlarDil = $this->sqlSorgu("SELECT * FROM ".PREFIX."formlar a JOIN ".PREFIX."formlar_dil b ON a.id=b.form_id WHERE b.form_id = :form_id and b.lang = :lang",array(":form_id"=>$id,":lang"=>@$_SESSION["lang"]));
        $formalanrengi = $this->sqlSorgu("SELECT * FROM ".PREFIX."form_alani WHERE alan_yapi = :alan_yapi and form_id= :form_id",array(":alan_yapi"=>"submit",":form_id"=>$id));?>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <style type="text/css"><?=@$formlarDil[0]['css'];?></style>
            <form action="javascript:void(0)" method="POST" class="form<?=@$formlarDil[0]['stil'];?> formClass-<?=@$formlarDil[0]['form_id'];?>" id="formId_<?=@$formlarDil[0]['form_id'] ?>"  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xs-12 col-md-12"><div class="alert formAlert_<?=@$formlarDil[0]['form_id'];?>" role="alert" style="display: none;"></div></div>
                    <input type="hidden" name="form_id" value="<?=@$formlarDil[0]['form_id'];?>">
                    <?php foreach ($formCek as $key => $value) {
                        $alanDil = $this->sqlSorgu("SELECT * FROM ".PREFIX."form_dil WHERE form_id = :form_id and alan_no= :alan_no and lang = :lang order by alan_no ASC",array(":form_id"=>$value["form_id"],":alan_no"=>$value["alan_no"],":lang"=>$_SESSION["lang"]));
                        if($value['alan_zorunlu']=='1'){$zorunlu=' required ';$yildiz='<i class="fa fa-star"></i>';}else{$zorunlu='';$yildiz='';}
                        if($value['alan_readonly']=='1'){$readonly=' readonly ';}else{$readonly='';}?>
                            <?php if($value["alan_yapi"]=='submit' and ($formlarDil[0]["guvenlik_sekli"]=="normal" || $formlarDil[0]["guvenlik_sekli"]=="")){?>
                                <div class="col-xs-12 <?php if($value['alan_class']==""){?>col-md-12<?php }else{echo $value['alan_class'];}?>">
                                     <div class="">
                                         <div class="form-group">
                                             <div class="guvenlik_resim" id="guvenlikResim">
                                                 <img src="" class="guvenlikResim"/>
                                             </div>
                                             <div class="guvenlik_input">
                                                 <input type="hidden" name="alan_renk" value="<?php echo str_replace("#","",$value["alan_renk"]);?>">
                                                 <input type="hidden" name="alan_guvenlik_renk" value="<?php echo str_replace("#","",$value["alan_guvenlik_renk"]);?>">
                                                 <input type="text" class="form-control" <?=$zorunlu;?> name="guvenlik_kodu" placeholder="<?php echo $this->dilcek()["dil_guvenlikkodu"]?>">
                                             </div>
                                         </div>
                                     </div>
                                </div>
                            <?php }else if($value["alan_yapi"]=='submit' and $formlarDil[0]["guvenlik_sekli"]=="google"){?>
                                <script src='https://www.google.com/recaptcha/api.js?hl=tr'></script>
                                <div class="col-xs-12 <?php if($value['alan_class']==""){?>col-md-12<?php }else{echo $value['alan_class'];}?>" id="guvenlikResim"> <div class="g-recaptcha" data-sitekey="<?php echo $formlarDil[0]["google_key"];?>"></div>
                                </div>
                            <?php }?>
                            <div class="col-xs-12 <?php if($value['alan_class']==""){?>col-md-12<?php }else{echo $value['alan_class'];}?>">
                                <div class="form-group">
                                    <?php if($value["alan_yapi"]!='submit' and $value["alan_yapi"]!='label' and $value["alan_yapi"]!='sozlesme'){?>
                                        <label for="" id="labelid_<?php echo $value['alan_no']; ?>" class="headlineslabel"><?=$yildiz;?> <?=$alanDil[0]['adi'];?></label>
                                    <?php }?>
                                    <?php if($value["alan_yapi"]!='submit' and $value["alan_yapi"]=='label' and $value["alan_yapi"]!='sozlesme'){?>
                                        <h1 class="help-block form_description">
                                            <?=$alanDil[0]['description'];?>
                                        </h1>
                                    <?php }?>
                                    <div class="input-group">
                                        <?php if($value["alan_yapi"]!='submit' and $value["alan_yapi"]!='checkbox' and $value["alan_yapi"]!='radio' and $value["alan_yapi"]!='file' and $value["alan_yapi"]!='sozlesme'){?>
                                            <?php if($value["alan_ikon"]!=""){?>
                                                <span class="input-group-addon"><i class="fa <?php echo $value["alan_ikon"];?>" aria-hidden="true"></i></span>
                                            <?php }?>
                                        <?php }?>
                                        <?php if($value["alan_yapi"]=='selectbox'){
                                            $isleveski = explode(",", $value["alan_islevi"]);
                                             $islevyeni = json_decode($value["alan_islevi"]);
                                                 if(is_array($islevyeni->$_SESSION["lang_code"])){
                                                    $islev = $islevyeni->$_SESSION["lang_code"];
                                                 }else{$islev = $isleveski;}?>
                                            <select class="<?php if($this->mobilKontrol()=="0"){?>selectpicker<?php }?>" id="inputid_<?php echo $value['alan_no']; ?>" <?=$zorunlu;?> <?=$readonly;?> name="<?php echo $value["alan_name"];?>" data-live-search="true" title="<?php echo $this->dilcek()["dil_lutfenseciniz"];?>" <?php if($values["onchange"]!=""){echo 'onChange="'.$values["onchange"].'"';};?>>
                                                 <?php foreach ($islev as $key => $valueislev) { ?>
                                                    <option value="<?php echo $valueislev; ?>" style="text-transform: capitalize;"><?php echo $valueislev; ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php }else if($value["alan_yapi"]=='textarea'){?>
                                            <textarea name="<?php echo $value["alan_name"];?>" id="inputid_<?php echo $value['alan_no']; ?>" <?=$zorunlu;?> <?=$readonly;?> class="form-control" rows="5" placeholder="<?php if($alanDil[0]['placeholder']){echo $alanDil[0]['placeholder'];}?>" aria-required="true"></textarea>
                                        <?php }else if($value["alan_yapi"]=='radio'){
                                            $isleveski = explode(",", $value["alan_islevi"]);
                                            $islevyeni = json_decode($value["alan_islevi"]);
                                                 if(is_array($islevyeni->$_SESSION["lang_code"])){
                                                    $islev = $islevyeni->$_SESSION["lang_code"];
                                                 }else{$islev = $isleveski;}
                                            foreach ($islev as $key => $valueislev) { ?>
                                                <div class="checkbox_liste">
                                                    <input type="radio" <?=$zorunlu?> id="inputid_<?php echo $value['alan_no'].$key; ?>" value="<?php echo $valueislev; ?>" <?=$zorunlu;?> <?=$readonly;?> name="<?php echo $value["alan_name"];?>" />
                                                    <label for="inputid_<?php echo $value['alan_no'].$key; ?>"><span></span><?php echo $valueislev; ?></label>
                                                </div>
                                            <?php } ?>
                                        <?php }else if($value["alan_yapi"]=='checkbox'){
                                             $isleveski = explode(",", $value["alan_islevi"]);
                                             $islevyeni = json_decode($value["alan_islevi"]);
                                                 if(is_array($islevyeni->$_SESSION["lang_code"])){
                                                    $islev = $islevyeni->$_SESSION["lang_code"];
                                                 }else{$islev = $isleveski;}
                                            foreach ($islev as $key => $valueislev) { ?>
                                                     <div class="checkbox_liste">
                                                        <input type="checkbox" id="inputid_<?php echo $value['alan_no'].$key; ?>" value="<?php echo $valueislev; ?>" <?=$zorunlu;?> <?=$readonly;?> name="<?php echo $value["alan_name"];?>[]" />
                                                        <label for="inputid_<?php echo $value['alan_no'].$key; ?>"><span></span><?php echo $valueislev; ?></label>
                                                    </div>
                                            <?php } ?>
                                        <?php }else if($value["alan_yapi"]=='file'){?>
                                             <label class="input-group-btn">
                                                    <span class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> Dosya Seç  <input type="file" name="<?php echo $value["alan_name"];?>" style="display: none;" ></span>
                                            </label>
                                            <input type="text" class="form-control" readonly>
                                        <?php }else if($value["alan_yapi"]=='tarih'){?>
                                             <input type="text" name="<?php echo $value["alan_name"];?>" id="inputid_<?php echo $value['alan_no']; ?>" class="form-control bootstrap-datepicker" <?=$zorunlu;?> <?=$readonly;?> placeholder="<?php if($alanDil[0]['placeholder']){echo $alanDil[0]['placeholder'];}?>">
                                        <?php }else if($value["alan_yapi"]=='sozlesme'){?>
                                             <div class="checkbox_liste">
                                                <input type="checkbox" id="inputid_<?php echo $value['alan_no'].$key; ?>" value="1" <?=$zorunlu;?> <?=$readonly;?> name="sozlesme<?php echo $value['alan_no'].$key; ?>" />
                                                <label for="inputid_<?php echo $value['alan_no'].$key; ?>" class="sozlesmelabel"><span></span> <a data-toggle="modal" data-target="#sozlesmeModal-<?php echo $id;?>">Site Kullanım Şartları</a> 'nı Okudum Anladım!</label>
                                            </div>
                                        <?php }else if($value["alan_yapi"]=='label'){?>
                                        <?php }else if($value["alan_yapi"]=='submit'){?>
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-12">
                                                        <button type="button" id="submit_<?php echo $value['form_id']; ?>" onclick="formGonder(<?=$value['form_id'];?>)" style="<?php if($value['alan_renk']!=""){echo "background:".$value['alan_renk'].";";} if($value['alan_yazi_renk']!=""){echo "color:".$value['alan_yazi_renk'].";";}?>" class="btn btn-block"><?=$alanDil[0]['adi'];?></button>
                                                    </div>
                                                </div>
                                        <?php }else if($value["alan_yapi"]=='email'){?>
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-12">
                                                        <input type="text" name="<?php echo $value["alan_name"];?>" id="inputid_<?php echo $value['alan_no']; ?>" class="form-control emailkontrol" <?=$zorunlu;?> <?=$readonly;?> placeholder="<?php if($alanDil[0]['placeholder']){echo $alanDil[0]['placeholder'];}?>" data-inputmask="'alias': 'email'">
                                                    </div>
                                                </div>
                                        <?php }else if($value["alan_yapi"]=='telefon'){?>
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-12">
                                                        <input type="text" name="<?php echo $value["alan_name"];?>" id="inputid_<?php echo $value['alan_no']; ?>" class="form-control telefonkontrol" <?=$zorunlu;?> <?=$readonly;?> placeholder="<?php if($alanDil[0]['placeholder']){echo $alanDil[0]['placeholder'];}?>" data-inputmask="'mask': '09999999999'">
                                                    </div>
                                                </div>
                                        <?php }else{ ?>
                                                <input type="<?=$value["alan_yapi"];?>" name="<?php echo $value["alan_name"];?>" id="inputid_<?php echo $value['alan_no']; ?>" class="form-control" <?=$zorunlu;?> <?=$readonly;?> placeholder="<?php if($alanDil[0]['placeholder']){echo $alanDil[0]['placeholder'];}?>">
                                        <?php }?>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="row">
                                            <span class="help-block form_description">
                                                <?php if($alanDil[0]['description']){echo "<span class='fa fa-info'></span> ".$alanDil[0]['description'];}?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="row">
                                            <span class="help-block" id="uyariid_<?php echo $value['alan_no']; ?>" style="position: relative;"></span>
                                        </div>
                                    </div>
                            </div>
                            </div>
                    <?php }?>
                </div>
                <div class="col-xs-12 col-md-12"><div class="row"><div class="alert formAlert_<?=@$formlarDil[0]['form_id'];?>" role="alert" style="display: none;"></div></div></div>
            </form>
            <!-- Modal -->
            <div id="sozlesmeModal-<?php echo $id;?>" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo @$formlarDil[0]["title"];?></h4>
                  </div>
                  <div class="modal-body">
                    <p><?php echo @$formlarDil[0]["modal"];?></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                  </div>
                </div>
              </div>
            </div>
            <script>
                $(document).ready(function(){
                    $(":input").inputmask();
                    guvenlikkoducek();
                });

                function sayfayenile(){
                    location.reload();
                }
                function guvenlikkoducek(){
                    var res ='<img src="<?php echo SITE_URL;?>genel/guvenlikGuncelle/<?php echo str_replace("#","",@$formalanrengi[0]["alan_renk"]);?>/<?php echo str_replace("#","",@$formalanrengi[0]["alan_guvenlik_renk"]);?>"  class="guvenlikResim"/>  ';
                    $("#guvenlikResim").html(res);
                }
                function formGonder(id){
                    var form = document.getElementById("formId_"+id);
                    var mecburiAlanlar = [];
                    var mecburiAlanlarid = [];
                    var tumalanlar = [];
                    var deger;
                    for(var i=0; i < form.elements.length; i++){
                        if((form.elements[i].value === '' || form.elements[i].checked == false ) && form.elements[i].hasAttribute('required')){
                            mecburiAlanlar.push(form.elements[i].name);
                        }
                        if((form.elements[i].value === '' || form.elements[i].checked == false ) && form.elements[i].hasAttribute('required')){
                            mecburiAlanlarid.push(form.elements[i].id);
                        }
                        tumalanlar.push(form.elements[i].id);
                    }

                        var formData = new FormData();
                        var submitData = $('#formId_'+id).serializeArray();
                        var fileData = $('input[type="file"]');
                        $.each(submitData,function(key,input){
                            formData.append(input.name,input.value);
                        });
                        formData.append("mecburiAlanlarid",mecburiAlanlarid);
                        formData.append("mecburiAlanlar",mecburiAlanlar);
                        formData.append("chapta","1");
                        $.each(fileData,function(key,input){
                            formData.append([0].files[0].input.name,[0].files[0].input.value);
                        });
                        var formserialize = $("#formId-"+id).serialize();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo SITE_URL;?>genel/ajaxFormGonder",
                            contentType: false,
                            processData: false,
                            data: formData,
                            beforeSend: function( xhr ) {
                                $(".formAlert_"+id).css("display","block");
                                $(".formAlert_"+id).html('<?php echo $this->dilcek()["dil_gonderiliyor"];?>');
                                $(".formAlert_"+id).addClass("alert-danger");
                                $('.gonderilmedi').each(function(i, obj) {
                                    obj.classList.remove("gonderilmedi");
                                });
                                document.getElementById("submit_"+id).disabled = true;
                            },
                            success: function(data)
                            {
                                try
                                {
                                   jsonData = JSON.parse(data);
                                   console.log(jsonData);
                                   if(jsonData["status"]=="false"){
                                       document.getElementById("submit_"+id).disabled = false;
                                        $.each(jsonData["mecburiAlanlar"], function( index, value ) {
                                            $("#inputid_"+value.id).addClass("gonderilmedi");
                                            $("#labelid_"+value.id).addClass("gonderilmedi");
                                            $("#uyariid_"+value.id).addClass("gonderilmedi");
                                            $("#uyariid_"+value.id).html(jsonData["alanMesajı"]);
                                        });
                                        $(".formAlert_"+id).addClass("alert-danger");
                                        $(".formAlert_"+id).removeClass("alert-success");
                                        $(".formAlert_"+id).html(jsonData["genelMesaj"]);
                                        if(typeof jsonData["yeniResim"]!="undefined" || jsonData["yeniResim"]!=null){
                                            $("#guvenlikResim").html(jsonData["yeniResim"]);
                                        }
                                        document.getElementById("submit_"+id).disabled = false;
                                    }else{
                                        $.each(tumalanlar, function( index, value ) {
                                            deger = value.replace("inputid_","");
                                            $("#inputid_"+deger).removeClass("gonderilmedi");
                                            $("#labelid_"+deger).removeClass("gonderilmedi");
                                            $("#uyariid_"+deger).removeClass("gonderilmedi");
                                            $("#uyariid_"+deger).html("");
                                            $("#inputid_"+deger).addClass("gonderildi");
                                            $("#labelid_"+deger).addClass("gonderildi");
                                            $("#uyariid_"+deger).addClass("gonderildi");
                                            $("#uyariid_"+deger).html(jsonData["alanMesajı"]);
                                        });
                                        $(".formAlert_"+id).addClass("alert-success");
                                        $(".formAlert_"+id).removeClass("alert-danger");
                                        $(".formAlert_"+id).html(jsonData["genelMesaj"]);
                                        document.getElementById("submit_"+id).disabled = true;
                                        setTimeout(function(){
                                           window.location.reload(1);
                                        }, 3000);
                                    }
                                    if(typeof jsonData["yeniResim"]!="undefined" || jsonData["yeniResim"]!=null){
                                        if(jsonData["chapta"]=="1"){
                                            $("#guvenlikResim").html(jsonData["yeniResim"]);
                                        }
                                    }
                                }
                                catch(e)
                                {
                                  console.log(data);
                                }

                            }
                         });
                }
            </script>
        <?php
    }
    public function json_decode($data){
        return json_decode($data,true);
    }
    public function json_encode($data){
        return json_decode($data);
    }
}
