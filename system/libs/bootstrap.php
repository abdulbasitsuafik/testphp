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
    private $_errorFile = 'error.php';

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
     * Ya da
     * Url boş ise $_url özelliğini unset() yapar.
     */
    public function getUrl(){
        $this->_url = isset($_GET["url"]) ? $_GET["url"] : null;
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
            if(@$this->_url[0]=="robots.txt"){
                $this->_controllerName = "robots";
            }else if(@$this->_url[0]=="sitemap.xml"){
                $this->_controllerName = "sitemap";
            }else if(@$this->_url[0]=="rss.xml"){
                $this->_controllerName = "rss";
            }else{
                $this->_controllerName = @$this->_url[0];
            }

            $fileName = $this->_controllerPath . $this->_controllerName . ".php";
            if(file_exists($fileName)){
                include $fileName;
                if(class_exists($this->_controllerName)){
                    $this->_controller = new $this->_controllerName();
                }else{
                    $this->_index();
                }
            }
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
    public function callMethod(){
        if(isset($this->_url[0])){
            if(isset($this->_url[2])){
                $this->_methodName = $this->_url[1];
                if(method_exists($this->_controller, $this->_methodName)){
                    $this->_controller->{$this->_methodName}($this->_url[2]);
                }else{
//                 echo "Controller icinde method bulunamadi.";
                    $this->_error();
                }
            }else if(isset($this->_url[1])){
                $this->_methodName = $this->_url[1];
                if(method_exists($this->_controller, $this->_methodName)){
                    $this->_controller->{$this->_methodName}();
                }else{
//                    echo "Controller icinde method bulunamadi.";
                    $this->_error();
                }
            }else if(isset($this->_url[0])){
                if(method_exists($this->_controller, $this->_methodName)){
                    $this->_controller->{$this->_methodName}();
                }else{
//                    echo "Controller icinde index methodu bulunamadi.";
                    $this->_content();
                }
            }
        }else{
            $this->_index();
        }
    }

    /**
     * Display an error page if nothing exists
     *
     * @return boolean
     */
    private function _error() {
        require $this->_controllerPath . "index.php";
        $this->_controller = new index();
        $this->_controller->sayfa_bulunamadi();
        exit;
    }
    /**
     * Display an error page if nothing exists
     *
     * @return boolean
     */
    private function _index() {
        require $this->_controllerPath . "index.php";
        $this->_controller = new index();
        $this->_controller->index();
        exit;
    }

    /**
     * Display an error page if nothing exists
     *
     * @return boolean
     */
    private function _content() {
        require $this->_controllerPath . "index.php";
        $this->_controller = new index();
        $this->_controller->content();
        exit;
    }

}
