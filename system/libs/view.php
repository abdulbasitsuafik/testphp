<?php
class View{
    function __construct() {
        require_once 'vendor/autoload.php';
        $this->loader = new Twig_Loader_Filesystem(FRONTEND_TEMPLATES);
        // set up environment
        $params = array(
//            'cache' => "app/cache/twig",
            'debug'	=> true,
            'auto_reload' => true, // disable cache
            'strict_variables'	=> false,
            'autoescape' => false
        );
        $this->twig = new Twig_Environment($this->loader, $params);
        $this->twig->addExtension(new Twig_Extension_Debug());

        require_once 'app/controllers/islemler.php';
        $islem = new islemler();
        $this->twig->addGlobal('islem', $islem);

    }

    public function render($twig, $arg = false,$filter = '') {
        $arg["THEME_PATH"] = SITE_URL.ANA_TEMA;
        $arg["PANEL_URL"] = PANEL_URL;
        $arg["PANEL_TEMA"] = PANEL_TEMA;
        $arg["MEMBER_THEME_PATH"] = SITE_URL.MEMBER_TEMA;
        $arg["SITE_URL"] = SITE_URL;
        $arg["LANG_CODE"] = @$_SESSION["lang_code"];
        $arg["LANG"] = @$_SESSION["lang"];
        $arg["SESSION"] = @$_SESSION;
        $arg["PREFIX"] = PREFIX;

        // languagesi dahil et
        $dilkod  = strtolower(@$_SESSION["lang_code"]);
        $dil_dosyasi = "system/language/".$dilkod."/dil.php";
        if(file_exists($dil_dosyasi)){
            require ($dil_dosyasi);
            $arg['lang'] = $_;
        }else{
//            $DEFAULT_LANG = strtolower(@$_SESSION['route']['default']['dil']);
            $dil_dosyasi = "system/language/tr/dil.php";
            require ($dil_dosyasi);
            $arg['lang'] = $_;
        }
        /**/
        $this->twig->display($twig . '.tpl',$arg);
    }
}
