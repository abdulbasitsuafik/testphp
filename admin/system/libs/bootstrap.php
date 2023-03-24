<?php
/**
 * Bootstrap Class'ı
 *
 * Bu class url'e göre yönlendirme yapmaktadır.
 */
class Bootstrap{
    /**
     *
     * @var Array URL verilerini tutar.
     */
    public $_url;

    /**
     *
     * @var String Çalıştırılacak controller adını tutar.
     */
    public $_controllerName = 'index';

    /**
     *
     * @var String Çalıştırılacak method adını tutar.
     */
    public $_methodName = 'index';

    /**
     *
     * @var String Controller dosyalarının yolunu tutar.
     */
    public $_controllerPath = 'app/controllers/';

    /**
     *
     * @var Object Çalıştırılan controller nesnesini/sınıfını tutar.
     */
    public $_controller;

    /**
     *
     * @var Error Dosyası
     */
    private $_errorFile = 'errors.php';

    /**
     *
     * @var standart index Dosyası
     */
    private $_defaultFile = 'index.php';

    /**
     *
     * @var action
     */
    private $_action;

    /**
     *
     * @var method prefix
     */
    private $_method_prefix;

    /**
     *
     * @var route
     */
    private $_route;

    /**
     *
     * @var language
     */
    private $_language;



    /**
     * İlk burası çalışır.
     */
    public function __construct() {
        $this->getUrl();
        $this->loadController();
        $this->callMethod();
    }

    /**
     * Url'i alır, dizi haline getirir. $_url özelliğine atar.
     * $_url[0] -> Controller ismi
     * $_url[1] -> Method ismi
     * $_url[2] -> Parametre
     *
     * Ya da
     *
     * Url boş ise $_url özelliğini unset() yapar.
     */
    public function getUrl(){
        $this->_url = strtolower(isset($_GET["url"]) ? $_GET["url"] : null);
        if($this->_url != null){
            $this->_url = rtrim($this->_url, "/");
            $this->_url = explode("/", $this->_url);
        }else{
           unset($this->_url);
        }
    }

    /**
     * Controller dosyasını ve Controller'ı yükler.
     * $_url[0] set edilmişse $_controllerName'e atar ve $_controllerName'i
     * yükler.
     * $_url[0] set edilmemişse $_controllerName'in default değerini yükler.
     */
    public function loadController(){
        if(!isset($this->_url[0])){
            include  $this->_controllerPath . $this->_controllerName . '.php';
            $this->_controller = new $this->_controllerName();
        }else{
            $this->_controllerName = $this->_url[0];
            $fileName = $this->_controllerPath . $this->_controllerName . ".php";
            if(file_exists($fileName)){
                include $fileName;
                if(class_exists($this->_controllerName)){
                    $this->_controller = new $this->_controllerName();
                }else{}
            }else{}
        }
    }

    /**
     * If a method is passed in the GET url paremter
     *
     *  http://localhost/controller/method/(param)/(param)/(param)
     *  url[0] = Controller
     *  url[1] = Method
     *  url[2] = Param
     *  url[3] = Param
     *  url[4] = Param
     */
    public function callMethod(){
        @$izin_kontrol = $this->kullanici_izin_kontrol();
        if($izin_kontrol==true){

            if(isset($this->_url[2])){
                $this->_methodName = $this->_url[1];
                if(method_exists($this->_controller, $this->_methodName)){
                    $this->_controller->{$this->_methodName}($this->_url[2]);
                }else{
                    // echo "Controller icinde method bulunamadi.";
                    $this->_error();
                }
            }else{
                if(isset($this->_url[1])){
                    $this->_methodName = $this->_url[1];
                    if(method_exists($this->_controller, $this->_methodName)){
                        $this->_controller->{$this->_methodName}();
                    }else{
                        //echo "Controller icinde method bulunamadi.";
                        $this->_error();
                    }
                }else{
                    if(method_exists($this->_controller, $this->_methodName)){
                        $this->_controller->{$this->_methodName}();
                    }else{
                        //echo "Controller icinde index methodu bulunamadi.";
                        $this->_error();
                    }
                }
            }

        }

    }

    /**
     * Display an error page if nothing exists
     *
     * @return boolean
     */
    private function _error() {
        require $this->_controllerPath . $this->_errorFile;
        $this->_controller = new Errors();
        $this->_controller->sayfabulunamadi();
        exit;
    }

    private function kullanici_izin_kontrol(){
        $direk_izinliler = array("admin/logout","admin/login","makale/dataliste");
//        $ana_kullaniciya_ait_sayfalar = array("reklamlar/grupekle","reklamlar/grupduzenle","reklamlar/alanekle","reklamlar/alanduzenle","boyut/liste","dil/liste");
        $ana_kullaniciya_ait_sayfalar = array(
            "languages",
            "users",
            "version",
            "exams",
            "headlines",
            "notifications",
            "reports"
        );

        @$kullanici_yetki = $_SESSION['user_yetki'];
        if(@$_SESSION["izin_tipi"]=="user"){
            $kullanici_izinler = json_decode($_SESSION['user_izinler']);
        }else{
            $kullanici_izinler = json_decode(@$_SESSION['grup_izinler']);
        }
        $kullanici_izinler = @$kullanici_izinler->izinler;
        $suanki_sayfa = $this->_url[0].'/'.$this->_url[1];
        /**/
        if($suanki_sayfa!="urun"){
            $suanki_sayfa = $suanki_sayfa;
        }else{
            $suanki_sayfa = str_replace("run","",$suanki_sayfa);
        }
        /**/
        if($suanki_sayfa=='/')$suanki_sayfa='';
        if(!in_array($suanki_sayfa,$direk_izinliler ) && $suanki_sayfa!='') {
            $yetkilerde_varmi = $this->yetkilerden_kontrolet($this->_url[0], $this->_url[1]);

        }else{@$yetkilerde_varmi = true;}
        if(@$kullanici_yetki!='1' && @$suanki_sayfa!='' &&  !in_array(@$suanki_sayfa,@$kullanici_izinler) && !in_array(@$suanki_sayfa,@$direk_izinliler ) && @$yetkilerde_varmi   ){

            require_once $this->_controllerPath . $this->_errorFile;
            $this->_controller = new Errors();
            $this->_controller->izinsiz_giris();
            return false;

        }else if(@$_SESSION['top_user']!='1' && @$_SESSION['authority']!='2' && ( (in_array($suanki_sayfa,$ana_kullaniciya_ait_sayfalar) or (in_array($this->_url[0],$ana_kullaniciya_ait_sayfalar)) ) ) ) {

            require_once $this->_controllerPath . $this->_errorFile;
            $this->_controller = new Errors();
            $this->_controller->izinsiz_giris();
            return false;

        }else if(@$_SESSION['top_user']!='1' && in_array($suanki_sayfa,$ana_kullaniciya_ait_sayfalar)) {

            require_once $this->_controllerPath . $this->_errorFile;
            $this->_controller = new Errors();
            $this->_controller->izinsiz_giris();
            return false;

        }else{
            return true;
        }


    }
    private function yetkilerden_kontrolet($conroller_ismi,$method_ismi){


        //Array_column
        if (! function_exists('array_column')) {
            function array_column(array $input, $columnKey, $indexKey = null) {
                $array = array();
                foreach ($input as $value) {
                    if ( !array_key_exists($columnKey, $value)) {
                        trigger_error("Key \"$columnKey\" does not exist in array");
                        return false;
                    }
                    if (is_null($indexKey)) {
                        $array[] = $value[$columnKey];
                    }
                    else {
                        if ( !array_key_exists($indexKey, $value)) {
                            trigger_error("Key \"$indexKey\" does not exist in array");
                            return false;
                        }
                        if ( ! is_scalar($value[$indexKey])) {
                            trigger_error("Key \"$indexKey\" does not contain scalar value");
                            return false;
                        }
                        $array[$value[$indexKey]] = $value[$columnKey];
                    }
                }
                return $array;
            }
        }


        $yetki_listesi =  @$_SESSION['yetki_listesi'];
        $method_ismi  = "/".$method_ismi;

        $aadi=$yetki_listesi['controller_listesi'];
        $badi=array_search($conroller_ismi,array_column($aadi, 'c_isim'));
        if (is_int($badi)) {
            $methodlar = $aadi[$badi]['islemler'];
            $madi=array_search($method_ismi, array_column($methodlar, 'm_isim'));

            if (is_int($madi)) {
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }

    }
}
