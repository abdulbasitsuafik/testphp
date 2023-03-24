<?php
//class index extends Controller{
//    public function __construct() {
//        parent::__construct();
//        Session::init();
////        $this->actions = $this->load->controllers("islemler");
////        $this->newmodel = $this->load->model("index_model");
////        $this->newform = $this->load->otherClasses("Form");
//    }
//    public function index(){
//        echo '<p style="width:100%;text-align: center;"><img src="uploads/logo.png"></p>';
//        echo '<p style="width:100%;text-align: center;"><img src="uploads/yapimasamasinda.png"></p>';
//    }
//    public function sayfa_bulunamadi(){
////        print_r("sayfa_bulunamadi");
//        $this->view->render("other/error");
//    }
//}

class Index extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Session::init();
        $this->actions = $this->load->controllers("islemler");
        $this->newmodel = $this->load->model("index_model");
        $this->newform = $this->load->otherClasses("Form");
    }

    public function sqlSorgu($sql, $array)
    {
        $model = $this->newmodel;
        return $model->sqlSorgu($sql, $array);
    }

    public function index()
    {
        echo "<p style='text-align: center;'>Welcome</p>";
        $model = $this->newmodel;
        $form = $this->newform;
        $form->html_press();

        $language_finder = $this->language_finder("anasayfa");
        $coming_head = $language_finder["coming_head"];
        $data = $language_finder["data"];

        $ayar = $model->ayarList();
        $data["sitebilgi"] = @$ayar[0];

        $gelen_modul = $model->modulTek(@$coming_head["head_id"]);
        if ($gelen_modul == true) {
            foreach ($gelen_modul as $key => $value) {
                $tpl_path = str_replace(".tpl", "", $value["tpl_path"]);
                if ($tpl_path != '') {
                    $this->view->render($value["folder"] . "/" . $tpl_path, $data);
                }
            }
        } else {
            $this->view->render("other/content", $data);
        }
    }

    public function content()
    {
        $model = $this->newmodel;
        $form = $this->newform;
        $form->html_press();

        $language_finder = $this->language_finder();
        $coming_head = $language_finder["coming_head"];
        $data = $language_finder["data"];

        $ayar = $model->ayarList();
        $data["sitebilgi"] = $ayar[0];

        if ($coming_head) {
            if ($coming_head["rank"] == "0" and $_SESSION["url_system"] == "headlines") {
                header('location: ' . SITE_URL);
            } else if ($coming_head["rank"] != 0 and $_SESSION["url_system"] == "headlines") {
                if ($coming_head["main_head"] == 0) {
                    $gelen_modul = @$model->modulTek($coming_head["head_id"]);
                } else {
                    $gelen_modul = @$model->modulTek($coming_head["main_head"]);

                }
                if (@$gelen_modul and @$_SESSION["url_system"] == "headlines") {
                    foreach ($gelen_modul as $key => $value) {
                        $tpl_path = str_replace(".tpl", "", $value["tpl_path"]);
                        if ($tpl_path != '') {
                            $this->view->render($value["folder"] . "/" . $tpl_path, $data);
                        }
                    }
                } else {
                    $this->view->render("other/content", $data);
                }
            } else if (@$_SESSION["url_system"] == "posts") {
                $this->view->render("sayfalar/posts_detail", $data);
            } else if (@$_SESSION["url_system"] == "products") {
                $this->view->render("sayfalar/products_detail", $data);
            } else {
                $this->view->render("other/content", $data);
            }
        } else {
            $this->view->render("other/error", $data);
        }

    }

    public function language_finder($home = null)
    {
        $model = $this->newmodel;
        $form = $this->newform;
        if ($home) {
            $coming_head = $model->find_first_head();
            $_SESSION["url_system"] = "headlines";
            $_SESSION["lang"] = @$coming_head[0]["lang"];
            $title = @$coming_head[0]['title'];
            $description = @$coming_head[0]['description'];
            $keywords = @$coming_head[0]['keywords'];
            $aktifsayfa = @$coming_head[0]['head_id'];
            $main_head = @$coming_head[0]['main_head'];
            $meta_image = @$coming_head[0]['image'];
            $form_id = @$coming_head[0]['form_id'];
            if (@$coming_head[0]["slide_id"]) {
                $slayt = $model->slaytListAll(@$coming_head[0]["slide_id"]);
            }
        } else {
            $active_page = $form->get_url(0);
            if ($form->get_url(1) != '' && $form->get_url(2) == '') $active_page = $form->get_url(1);
            if ($form->get_url(2) != '') $active_page = $form->get_url(2);

            if (!empty($coming_head = $model->find_headlines("headlines", $active_page))) {
                $_SESSION["url_system"] = "headlines";
                $_SESSION["lang"] = @$coming_head[0]["lang"];
                $title = @$coming_head[0]['title'];
                $description = @$coming_head[0]['description'];
                $keywords = @$coming_head[0]['keywords'];
                $aktifsayfa = @$coming_head[0]['head_id'];
                $main_head = @$coming_head[0]['main_head'];
                $meta_image = @$coming_head[0]['image'];
                $form_id = @$coming_head[0]['form_id'];
                $page_detail = @$coming_head[0];
                if (@$coming_head[0]["slide_id"]) {
                    $slayt = $model->slaytListAll(@$coming_head[0]["slide_id"]);
                }
            } else if (!empty($coming_head = $model->find_headlines("products", $active_page))) {
                $_SESSION["url_system"] = "products";
                $_SESSION["lang"] = @$coming_head[0]["lang"];
                $title = @$coming_head[0]['title'];
                $description = @$coming_head[0]['description'];
                $keywords = @$coming_head[0]['keywords'];
                $aktifsayfa = @$coming_head[0]['head_id'];
                $meta_image = @$coming_head[0]['image'];
                $page_detail = @$coming_head[0];
            } else if (!empty($coming_head = $model->find_headlines("posts", $active_page))) {
                $_SESSION["url_system"] = "posts";
                $_SESSION["lang"] = $coming_head[0]["lang"];
                $title = @$coming_head[0]['title'];
                $description = @$coming_head[0]['description'];
                $keywords = @$coming_head[0]['keywords'];
                $aktifsayfa = @$coming_head[0]['head_id'];
                $meta_image = @$coming_head[0]['image'];
                $page_detail = @$coming_head[0];
            }
        }
        if (@$_SESSION["lang"] == "") {
            $_SESSION["lang"] = DEFAULT_LANG;
        }
//        if(@$title){$title .= ' - ';}
        $data = array(
            "title" => stripslashes(@$title),
            "description" => stripslashes(@$description),
            "keywords" => stripslashes(@$keywords),
            "meta_image" => @SITE_URL . @$meta_image,
            "active_page_head_id" => @$aktifsayfa,
            "active_main_id" => @$main_head,
            "url_system" => @$_SESSION["url_system"]
        );
        $data['active_link'] = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $data['form_id'] = @$form_id ? $form_id : 0;
        $data['active_slide'] = @$slayt ? $slayt : [];
        $data['active_page_details'] = @$page_detail ? $page_detail : [];
        return array("coming_head" => @$coming_head[0], "data" => @$data);
    }

    public function sayfa_bulunamadi()
    {
//        print_r("sayfa_bulunamadi");
        $this->view->render("other/error");
    }
}
