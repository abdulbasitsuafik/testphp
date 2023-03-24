<?php
class View{
    function __construct() {
        require_once '../vendor/autoload.php';
        $this->loader = new Twig_Loader_Filesystem(PANEL_TEMPLATES);
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

        require_once 'app/controllers/actions.php';
        $islem = new actions();
        $this->twig->addGlobal('actions', $islem);
    }

    public function render($twig, $arg = false,$filter = '') {
        $arg["THEME_PATH"] = PANEL_THEME_PATH;
        $arg["SITE_URL"] = SITE_URL;
        $arg["PANEL_URL"] = PANEL_URL;
        $arg["SESSION"] =@$_SESSION;
        $arg["PREFIX"] = PREFIX;
        $arg["SERVER_ADDR"] = $_SERVER['SERVER_ADDR'];

        $arg["CONTROLLER"] = CONTROLLER;
        $arg["METHOD"] = METHOD;

        $this->twig->display($twig . '.tpl',$arg);
    }
}
