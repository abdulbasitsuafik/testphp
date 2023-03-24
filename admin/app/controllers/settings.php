<?php
class Settings extends Controller{
    public function __construct() {
        parent::__construct();
        $this->newmodel = $this->load->model("settings_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->actions = $this->load->controllers("actions");
    }
    public function sqlSorgu($sql,$array){
        return $this->actions->sqlSorgu($sql,$array);
    }
    public function index(){
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST){
            $response = $this->form_control($_POST);
            echo json_encode($response);
        }else{
            $data["title"] = "Ayarlar";
            $data["dashboard"] = true;

            $this->view->render("settings/index",$data);
        }
    }
    public function edit() {
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST["modal_getir"]){
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }
            $data["title"] = "Ayarlar";
            $data["page_type"] = "edit";
            $data["id"] =@$form->values["id"];
            $data["data"] = $model->get_single()[0];
            $data["languages"] = $model->active_languages();
            $data["fontlar"] = $model->fontlar();

            ob_start();
            $this->view->render("settings/modal",$data,"1");
            $renderView = ob_get_clean();

            $newData["renderView"] = $renderView;
            echo json_encode($newData);
        }else{
            if($_POST) {
                $response = $this->form_control($_POST,"edit");
                echo json_encode($response);
            }
        }

    }
    public function form_control($POST,$posttype=""){
        $form = $this->newform;
        $model = $this->newmodel;
        foreach ($POST as $key => $value) {
            $form->post($key);
        }
        if(@$form->values['mecburiAlanlar']==""){
            $dilsayisi = $model->active_languages();
            $data = [];
            if (@$_FILES){
                $output_dir = "uploads/headlines/";
                if(is_dir(USTDIZIN."uploads")){ }else{
                    mkdir(USTDIZIN."uploads");
                }
                if(is_dir(USTDIZIN.$output_dir)){ }else{
                    mkdir(USTDIZIN.$output_dir);
                }

                /*foreach ($_FILES as $index => $FILE) {
                    $nowdate =  strtotime("now"). substr((string)microtime(), 1, 6);
                    $fileName = @$_FILES[$index]["name"];
                    $type = @$_FILES[$index]["type"];
                    $uzanti=str_replace("image/","",$type);
                    $uzanti = strtolower(".".$uzanti);

                    $yeni_ad=$output_dir.$form->seo($fileName).$nowdate.$uzanti;
                    @copy(@$_FILES[$index]["tmp_name"],USTDIZIN.$yeni_ad);
                }*/
                $logo_adi = @$_FILES["logo"]["name"];
                if($logo_adi){
                    $type = @$_FILES["logo"]["type"];
                    $logouzanti=substr($logo_adi,-4,4);
                    $logouzanti=str_replace("image/","",$type);
                    $logouzanti = strtolower(".".$logouzanti);
                    $logo_yeni_ad="uploads/"."logo".$logouzanti;
                    @copy($_FILES['logo']['tmp_name'],USTDIZIN.$logo_yeni_ad);

                    $data['logo'] = $logo_yeni_ad;
                }

                $font_adi=@$_FILES["font"]["name"];
                if($font_adi){
                    if(is_dir(USTDIZIN."public/eklentiler/font")){ }else{
                        mkdir(USTDIZIN."public/eklentiler/font");
                    }
                    $logouzanti=substr($font_adi,-4,4);
                    $font_yeni_ad="public/eklentiler/font/".$font_adi;
                    @copy($_FILES['font']['tmp_name'],USTDIZIN.$font_yeni_ad);

                    $data['font_adi'] = $font_adi;
                    $data['font_yolu'] = $font_yeni_ad;
                }

                $footer_logo_adi=@$_FILES["footer_logo"]["name"];
                if($footer_logo_adi){
                    $logouzanti=substr($footer_logo_adi,-4,4);
                    $logo_yeni_ad="uploads/"."footer_logo".$logouzanti;
                    @copy($_FILES['footer_logo']['tmp_name'],USTDIZIN.$logo_yeni_ad);

                    $data['footer_logo'] = $logo_yeni_ad;
                }

                $telif_resmi_adi=@$_FILES["telif_resmi"]["name"];
                if($telif_resmi_adi) {
                    $logouzanti = substr($telif_resmi_adi, -4, 4);
                    $logo_yeni_ad = "uploads/" . "telif_resmi" . $logouzanti;
                    @copy($_FILES['telif_resmi']['tmp_name'], USTDIZIN . $logo_yeni_ad);

                    $data['telif_resmi'] = $logo_yeni_ad;
                }

                $favicon_adi=@$_FILES["favicon"]["name"];
                if($favicon_adi){
                    $logo_yeni_ad="uploads/"."favicon."."ico";
                    @copy($_FILES['favicon']['tmp_name'],USTDIZIN.$logo_yeni_ad);

                    $data['favicon'] = $logo_yeni_ad;
                }



            }
            if($form->values['payment_method']=="1"){
                $payment_method = "1";
            }else{
                $payment_method = "0";
            }
            $data['payment_method'] = $payment_method;
            $data['active_android_version'] = $form->values['active_android_version'];
            $data['active_ios_version'] = $form->values['active_ios_version'];
            if($form->values['yayin_durumu']=="1"){
                $yayin = "1";
            }else{
                $yayin = "0";
            }
//            genel
            $data['analytics'] = $form->values['analytics'];
            $data['yayin_durumu'] = $yayin;
            //mail
            $data['formmail_alicilar'] = $form->values['formmail_alicilar'];
            $data['formmail_host'] = $form->values['formmail_host'];
            $data['formmail_mail'] = $form->values['formmail_mail'];
            $data['formmail_sifre'] = $form->values['formmail_sifre'];
            $data['formmail_secure'] = $form->values['formmail_secure'];
            $data['formmail_port'] = $form->values['formmail_port'];



//            sosyal
            $data['facebook'] = $form->values['facebook'];
            $data['twitter'] = $form->values['twitter'];
            $data['whatsapp'] = $form->values['whatsapp'];
            $data['googleplus'] = $form->values['googleplus'];
            $data['instagram'] = $form->values['instagram'];
            $data['linkedin'] = $form->values['linkedin'];
            $data['pinterest'] = $form->values['pinterest'];
            $data['youtube'] = $form->values['youtube'];
            $data['skype'] = $form->values['skype'];

//            telif resmi
            $data["telif_resmi_konum"] = $form->values['telif_resmi_konum'];
            $data["telif_resmi_yazi"] = $form->values['telif_resmi_yazi'];
            $data["telif_resmi_yazi_bg"] = $form->values['telif_resmi_yazi_bg'];
            $data["telif_resmi_yazi_renk"] = $form->values['telif_resmi_yazi_renk'];
            $data["telif_resmi_yazi_width"] = $form->values['telif_resmi_yazi_width'];
            $data["telif_resmi_yazi_height"] = $form->values['telif_resmi_yazi_height'];
            $data["telif_resmi_yazi_font"] = $form->values['telif_resmi_yazi_font'];
            $data["telif_resmi_yazi_font_size"] = $form->values['telif_resmi_yazi_font_size'];
            $data["telif_resmi_secim"] = $form->values['telif_resmi_secim'];


//            iletişim
            $data['unvani'] = $form->values['unvani'];
            $data['telif'] = $form->values['telif'];
            $data['telefon'] = $form->values['telefon'];
            $data['telefon1'] = $form->values['telefon1'];
            $data['telefon2'] = $form->values['telefon2'];
            $data['telefon3'] = $form->values['telefon3'];
            $data['telefon4'] = $form->values['telefon4'];
            $data['telefon5'] = $form->values['telefon5'];
            $data['fax'] = $form->values['fax'];
            $data['gsm'] = $form->values['gsm'];
            $data['email'] = $form->values['email'];
            $data['adres1'] = $form->values['adres1'];
            $data['adres2'] = $form->values['adres2'];
            $data['adres3'] = $form->values['adres3'];
            $data['langitude'] = @$form->values['langitude'];
            $data['latitude'] = @$form->values['latitude'];
            $data['harita'] = $form->values['harita'];
            $data['mobil_telefon'] = $form->values['mobil_telefon'];
            $data['mobil_email'] = $form->values['mobil_email'];
            $data['mobil_harita'] = $form->values['mobil_harita'];


//            if(@$form->values["status"]){
//                $data["status"] = $form->values["status"];
//            }elseif(@$form->values["status"]==0) {
//                $data["status"] = 0;
//            }else{
//                $data["status"] = 1;
//            }

            if($posttype=="edit"){
                $data["head_id"] = @$form->values["b_id"];
                $data_lang["head_id"] = @$form->values["b_id"];
                $model->edit($data);
                $response["post_type"] = "edit";
            }

            $response["message"] = "Kayıt Başarılı";
            $response["status"] = true;
            $response["post_type"] = "edit";
            $response["content"] = $POST;
            $response["files"] = $_FILES;
            $response["data"] = $data;
        }else{
            $response["status"] = false;
            $response["message"] = "Fill in the blanks...";
            $response["post"] = $_POST;
            $response["files"] = $_FILES;
        }
        return $response;
    }

    public function sitemapRun(){
        //Set this to be your site map URL
        $sitemapUrl = SITE_ADRESI."sitemap";

        // cUrl handler to ping the Sitemap submission URLs for Search Engines…
        function myCurl($url){
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return $httpCode;
        }

        //Google
        $url = "http://www.google.com/webmasters/sitemaps/ping?sitemap=".$sitemapUrl;
        $returnCode = myCurl($url);
        echo "<p>Google 'a Sitemap Gönderildi (return code: $returnCode).</p>";

        //Bing / MSN
        $url = "http://www.bing.com/ping?siteMap=".$sitemapUrl;
        $returnCode = myCurl($url);
        echo "<p>Bing / MSN 'a Sitemap Gönderildi (return code: $returnCode).</p>";
        echo SITE_ADRESI;
        //ASK
        $url = "http://submissions.ask.com/ping?sitemap=".$sitemapUrl;
        $returnCode = myCurl($url);
        echo "<p>ASK.com'a Sitemap Gönderildi (return code: $returnCode).</p>";

        // yandex
        $url = "https://webmaster.yandex.com.tr/site/map.xml?url=".$sitemapUrl."&sk=u1a72aa3326ddd7bca7997abf823fbf8e&host=23443358&event=add";
        $returnCode = myCurl($url);
        echo "<p>Yandex.com'a Sitemap Gönderildi (return code: $returnCode).</p>";
    }
    public function rssRun(){
        $model = $this->newmodel;
        $ayar = $model->get_single();
        $siteAdi = $ayar[0]["unvani"];
        $siteURL = SITE_ADRESI;
        $siteRssURL = SITE_ADRESI."rss";

        if (!function_exists('xmlrpc_encode_request'))
        {
            function xmlrpc_encode_request($method, $dizi)
            {
                $output .= '<?xml version="1.0"?>';
                $output .= '<methodCall>';
                $output .= '<methodName>'.$method.'</methodName>';
                $output .= '<params>';
                $output .= '<param><value><string>'.$dizi[0].'</string></value></param>';
                $output .= '<param><value><string>'.$dizi[1].'</string></value></param>';
                $output .= '</params></methodCall>';
                return $output;
            }
        }
        function xmlrpc_ping ($weblogUpdates, $host, $pingurl) {

            $request = xmlrpc_encode_request($weblogUpdates, array($siteAdi, $siteURL) );

            $header[] = "Host: $host";
            $header[] = "Content-type: text/xml";
            $header[] = "Content-length: ".strlen($request) . "rn";
            $header[] = $request;

            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $pingurl);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
            curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
            $result = curl_exec( $ch );
            curl_close($ch);

            if (preg_match('|0|', $result)) {
                echo "<span style='color:green'>başarılı</span>";
            } else {
                echo "<span style='color:red'>başarısız</span>";
            }
        }
        // google.com
        echo "Google.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com","http://blogsearch.google.com/ping/RPC2");
        echo "<br />";
        echo "Google.com.tr pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.tr","http://blogsearch.google.com.tr/ping/RPC2");
        echo "<br />";
        echo "Google.ae pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.ae","http://blogsearch.google.ae/ping/RPC2");
        echo "<br />";
        echo "Google.at pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.at","http://blogsearch.google.at/ping/RPC2");
        echo "<br />";
        echo "Google.be pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.be","http://blogsearch.google.be/ping/RPC2");
        echo "<br />";
        echo "Google.bg pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.bg","http://blogsearch.google.bg/ping/RPC2");
        echo "<br />";
        echo "Google.ca pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.ca","http://blogsearch.google.ca/ping/RPC2");
        echo "<br />";
        echo "Google.ch pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.ch","http://blogsearch.google.ch/ping/RPC2");
        echo "<br />";
        echo "Google.cl pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.cl","http://blogsearch.google.cl/ping/RPC2");
        echo "<br />";
        echo "Google.de pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.de","http://blogsearch.google.de/ping/RPC2");
        echo "<br />";
        echo "Google.es pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.es","http://blogsearch.google.es/ping/RPC2");
        echo "<br />";
        echo "Google.fi pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.fi","http://blogsearch.google.fi/ping/RPC2");
        echo "<br />";
        echo "Google.fr pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.fr","http://blogsearch.google.fr/ping/RPC2");
        echo "<br />";
        echo "Google.gr pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.gr","http://blogsearch.google.gr/ping/RPC2");
        echo "<br />";
        echo "Google.hr pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.hr","http://blogsearch.google.hr/ping/RPC2");
        echo "<br />";
        echo "Google.ie pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.ie","http://blogsearch.google.ie/ping/RPC2");
        echo "<br />";
        echo "Google.it pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.it","http://blogsearch.google.it/ping/RPC2");
        echo "<br />";
        echo "Google.jp pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.jp","http://blogsearch.google.jp/ping/RPC2");
        echo "<br />";
        echo "Google.lt pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.lt","http://blogsearch.google.lt/ping/RPC2");
        echo "<br />";
        echo "Google.nl pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.nl","http://blogsearch.google.nl/ping/RPC2");
        echo "<br />";
        echo "Google.pl pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.pl","http://blogsearch.google.pl/ping/RPC2");
        echo "<br />";
        echo "Google.pt pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.pt","http://blogsearch.google.pt/ping/RPC2");
        echo "<br />";
        echo "Google.ro pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.ro","http://blogsearch.google.ro/ping/RPC2");
        echo "<br />";
        echo "Google.ru pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.ru","http://blogsearch.google.ru/ping/RPC2");
        echo "<br />";
        echo "Google.se pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.se","http://blogsearch.google.se/ping/RPC2");
        echo "<br />";
        echo "Google.sk pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.sk","http://blogsearch.google.sk/ping/RPC2");
        echo "<br />";
        echo "Google.us pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.us","http://blogsearch.google.us/ping/RPC2");
        echo "<br />";
        echo "Google.com.ar pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.ar","http://blogsearch.google.com.ar/ping/RPC2");
        echo "<br />";
        echo "Google.com.au pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.au","http://blogsearch.google.com.au/ping/RPC2");
        echo "<br />";
        echo "Google.com.br pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.br","http://blogsearch.google.com.br/ping/RPC2");
        echo "<br />";
        echo "Google.com.co pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.co","http://blogsearch.google.com.co/ping/RPC2");
        echo "<br />";
        echo "Google.com.do pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.do","http://blogsearch.google.com.do/ping/RPC2");
        echo "<br />";
        echo "Google.com.mx pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.mx","http://blogsearch.google.com.mx/ping/RPC2");
        echo "<br />";
        echo "Google.com.my pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.my","http://blogsearch.google.com.my/ping/RPC2");
        echo "<br />";
        echo "Google.com.pe pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.pe","http://blogsearch.google.com.pe/ping/RPC2");
        echo "<br />";
        echo "Google.com.sa pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.sa","http://blogsearch.google.com.sa/ping/RPC2");
        echo "<br />";
        echo "Google.com.sg pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.sg","http://blogsearch.google.com.sg/ping/RPC2");
        echo "<br />";
        echo "Google.com.tw pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.tw","http://blogsearch.google.com.tw/ping/RPC2");
        echo "<br />";
        echo "Google.com.ua pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.ua","http://blogsearch.google.com.ua/ping/RPC2");
        echo "<br />";
        echo "Google.com.uy pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.uy","http://blogsearch.google.com.uy/ping/RPC2");
        echo "<br />";
        echo "Google.com.vn pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.com.vn","http://blogsearch.google.com.vn/ping/RPC2");
        echo "<br />";
        echo "Google.co.cr pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.cr","http://blogsearch.google.co.cr/ping/RPC2");
        echo "<br />";
        echo "Google.co.hu pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.hu","http://blogsearch.google.co.hu/ping/RPC2");
        echo "<br />";
        echo "Google.co.id pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.id","http://blogsearch.google.co.id/ping/RPC2");
        echo "<br />";
        echo "Google.co.il pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.il","http://blogsearch.google.co.il/ping/RPC2");
        echo "<br />";
        echo "Google.co.in pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.in","http://blogsearch.google.co.in/ping/RPC2");
        echo "<br />";
        echo "Google.co.jp pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.jp","http://blogsearch.google.co.jp/ping/RPC2");
        echo "<br />";
        echo "Google.co.ma pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.ma","http://blogsearch.google.co.ma/ping/RPC2");
        echo "<br />";
        echo "Google.co.nz pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.nz","http://blogsearch.google.co.nz/ping/RPC2");
        echo "<br />";
        echo "Google.co.th pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.th","http://blogsearch.google.co.th/ping/RPC2");
        echo "<br />";
        echo "Google.co.uk pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.uk","http://blogsearch.google.co.uk/ping/RPC2");
        echo "<br />";
        echo "Google.co.ve pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.ve","http://blogsearch.google.co.ve/ping/RPC2");
        echo "<br />";
        echo "Google.co.za pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.extendedPing","blogsearch.google.co.za","http://blogsearch.google.co.za/ping/RPC2");
        echo "<br />";

        // feedburner.com
        echo "Feedburner.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","rpc.feedburner.com","http://ping.feedburner.com");
        echo "<br />";
        // newsgator.com
        echo "Newsgator.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","services.newsgator.com","http://services.newsgator.com/ngws/xmlrpcping.aspx");
        echo "<br />";
        // rpc.newsgator.com
        echo "rpc.newsgator.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","rpc.newsgator.com","rpc.newsgator.com");
        echo "<br />";
        // blogrolling.com
        echo "Blogrolling.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","rpc.blogrolling.com","http://rpc.blogrolling.com/pinger/");
        echo "<br />";
        // feedster.com
        echo "feedster.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","api.feedster.com","http://api.feedster.com/ping");
        echo "<br />";
        // twingly.com
        echo "twingly.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","rpc.twingly.com","http://rpc.twingly.com");
        echo "<br />";
        // ping.blo.gs
        echo "ping.blo.gs pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.blo.gs","http://ping.blo.gs");
        echo "<br />";
        // blo.gs/ping.php
        echo "blo.gs/ping.php pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","blo.gs","http://blo.gs/ping.php");
        echo "<br />";
        // www.blogpeople.net/servlet/weblogUpdates
        echo "www.blogpeople.net/servlet/weblogUpdates pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.blogpeople.net","http://www.blogpeople.net/servlet/weblogUpdates");
        echo "<br />";
        // xping.pubsub.com/ping
        echo "xping.pubsub.com/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","xping.pubsub.com","http://xping.pubsub.com/ping");
        echo "<br />";
        // mod-pubsub.org/kn_apps/blogchatt
        echo "mod-pubsub.org/kn_apps/blogchatt pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","mod-pubsub.org","mod-pubsub.org/kn_apps/blogchatt");
        echo "<br />";
        // blogs.yandex.ru
        echo "blogs.yandex.ru pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","blogs.yandex.ru","blogs.yandex.ru");
        echo "<br />";
        // ping.blogs.yandex.ru
        echo "blogs.yandex.ru pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.blogs.yandex.ru","ping.blogs.yandex.ru/RPC2");
        echo "<br />";
        // ping.fc2.com
        echo "ping.fc2.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.fc2.com","ping.fc2.com");
        echo "<br />";
        // ping.rss.drecom.jp
        echo "blogs.yandex.ru pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.rss.drecom.jp","ping.rss.drecom.jp");
        echo "<br />";
        // rpc.aitellu.com
        echo "rpc.aitellu.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","rpc.aitellu.com","rpc.aitellu.com");
        echo "<br />";
        // rpc.bloggerei.de
        echo "rpc.bloggerei.de pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","rpc.bloggerei.de","rpc.bloggerei.de");
        echo "<br />";
        // www.blogshares.com
        echo "rpc.bloggerei.de pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.blogshares.com","www.blogshares.com/rpc.php");
        echo "<br />";
        // www.blogsnow.com
        echo "www.blogsnow.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.blogsnow.com","www.blogsnow.com/ping");
        echo "<br />";
        // www.blogstreet.com
        echo "www.blogstreet.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.blogstreet.com","www.blogstreet.com/xrbin/xmlrpc.cgi");
        echo "<br />";
        // bulkfeeds.net
        echo "bulkfeeds.net/rpc pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","bulkfeeds.net","bulkfeeds.net/rpc");
        echo "<br />";
        // www.newsisfree.com/xmlrpctest.php
        echo "www.newsisfree.com/xmlrpctest.php pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.newsisfree.com","www.newsisfree.com/xmlrpctest.php");
        echo "<br />";
        // www.newsisfree.com/RPCCloud
        echo "www.newsisfree.com/RPCCloud pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.newsisfree.com","www.newsisfree.com/RPCCloud");
        echo "<br />";
        // ping.syndic8.com/xmlrpc.php
        echo "ping.syndic8.com/xmlrpc.php pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.syndic8.com","ping.syndic8.com/xmlrpc.php");
        echo "<br />";
        //ping.weblogalot.com/rpc.php
        echo "ping.weblogalot.com/rpc.php pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.weblogalot.com","ping.weblogalot.com/rpc.php");
        echo "<br />";
        //www.weblogalot.com/ping
        echo "www.weblogalot.com/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.weblogalot.com","www.weblogalot.com/ping");
        echo "<br />";
        //rpc.technorati.com/rpc/ping
        echo "rpc.technorati.com/rpc/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","rpc.technorati.com","rpc.technorati.com/rpc/ping");
        echo "<br />";
        //www.feedsubmitter.com
        echo "www.feedsubmitter.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.feedsubmitter.com","www.feedsubmitter.com");
        echo "<br />";
        //www.pingerati.net
        echo "www.pingerati.net pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.pingerati.net","www.pingerati.net");
        echo "<br />";
        //www.pingmyblog.com
        echo "www.pingmyblog.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.pingmyblog.com","www.pingmyblog.com");
        echo "<br />";
        //geourl.org/ping
        echo "geourl.org/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","geourl.org","geourl.org/ping");
        echo "<br />";
        //ipings.com
        echo "ipings.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ipings.com","ipings.com");
        echo "<br />";
        //twitter.cross-poster.com
        echo "twitter.cross-poster.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","twitter.cross-poster.com","twitter.cross-poster.com");
        echo "<br />";
        //sitemapr.us/tools/ping
        echo "sitemapr.us/tools/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","sitemapr.us","sitemapr.us/tools/ping");
        echo "<br />";
        //redalt.com/Tools/Pingomation
        echo "redalt.com/Tools/Pingomation  pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","redalt.com","redalt.com/Tools/Pingomation");
        echo "<br />";
        //pings.ws
        echo "pings.ws  pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","pings.ws","pings.ws");
        echo "<br />";
        //pingsalot.com
        echo "pingsalot.com  pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","pingsalot.com","pingsalot.com");
        echo "<br />";
        //pingomatic.com
        echo "pingomatic.com  pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","pingomatic.com","pingomatic.com");
        echo "<br />";
        //www.pingoblog.com
        echo "www.pingoblog.com  pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.pingoblog.com","www.pingoblog.com");
        echo "<br />";
        //www.pingoat.com
        echo "www.pingoat.com  pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.pingoat.com","www.pingoat.com");
        echo "<br />";
        //pingoat.com/goat/RPC2
        echo "pingoat.com/goat/RPC2  pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","pingoat.com","pingoat.com/goat/RPC2");
        echo "<br />";
        //www.alles-over.com/ping-service/?lang=en
        echo "www.alles-over.com/ping-service/?lang=en pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.alles-over.com","www.alles-over.com/ping-service/?lang=en");
        echo "<br />";
        //www.allpodcasts.com/PingAll/Default.aspx
        echo "www.allpodcasts.com/PingAll/Default.aspx pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.allpodcasts.com","www.allpodcasts.com/PingAll/Default.aspx");
        echo "<br />";
        //www.autopinger.com
        echo "www.autopinger.com  pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.autopinger.com","www.autopinger.com");
        echo "<br />";
        //pingoat.com/goat/RPC2
        echo "blip.lco.net/SubmitForm.aspx pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","blip.lco.net","blip.lco.net/SubmitForm.aspx");
        echo "<br />";
        //pinger.blogflux.com
        echo "pinger.blogflux.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","pinger.blogflux.com","pinger.blogflux.com");
        echo "<br />";
        //feedshark.brainbliss.com
        echo "feedshark.brainbliss.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","feedshark.brainbliss.com","feedshark.brainbliss.com");
        echo "<br />";
        //www.kping.com
        echo "www.kping.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.kping.com","www.kping.com");
        echo "<br />";
        //www.mypagerank.net/service_pingservice_index
        echo "www.mypagerank.net/service_pingservice_index pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.mypagerank.net","www.mypagerank.net/service_pingservice_index");
        echo "<br />";
        //pingates.com
        echo "pingates.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","pingates.com","pingates.com");
        echo "<br />";
        //ping.in/index.php
        echo "ping.in/index.php pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.in","ping.in/index.php");
        echo "<br />";
        //ping.bitacoras.com
        echo "ping.bitacoras.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.bitacoras.com","ping.bitacoras.com");
        echo "<br />";
        //bitacoras.net/ping
        echo "bitacoras.net/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","bitacoras.net","bitacoras.net/ping");
        echo "<br />";
        //topicexchange.com/RPC2
        echo "topicexchange.com/RPC2 pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","topicexchange.com","topicexchange.com/RPC2");
        echo "<br />";
        //www.blogoole.com/ping
        echo "www.blogoole.com/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.blogoole.com","www.blogoole.com/ping");
        echo "<br />";
        //www.popdex.com/addsite.php
        echo "www.popdex.com/addsite.php pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.popdex.com","www.popdex.com/addsite.php");
        echo "<br />";
        //www.wasalive.com/ping
        echo "www.wasalive.com/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.wasalive.com","www.wasalive.com/ping");
        echo "<br />";
        //www.weblogues.com/RPC
        echo "www.weblogues.com/RPC pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.weblogues.com","www.weblogues.com/RPC");
        echo "<br />";
        //ping.amagle.com
        echo "ping.amagle.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.amagle.com","ping.amagle.com");
        echo "<br />";
        //ping.rootblog.com/rpc.php
        echo "ping.rootblog.com/rpc.php pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.rootblog.com","ping.rootblog.com/rpc.php");
        echo "<br />";
        //rcs.datashed.net/RPC2
        echo "rcs.datashed.net/RPC2 pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","rcs.datashed.net","rcs.datashed.net/RPC2");
        echo "<br />";
        //rpc.blogbuzzmachine.com/RPC2
        echo "rpc.blogbuzzmachine.com/RPC2 pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","rpc.blogbuzzmachine.com","rpc.blogbuzzmachine.com/RPC2");
        echo "<br />";
        //www.blogoon.net/ping
        echo "www.blogoon.net/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.blogoon.net","www.blogoon.net/ping");
        echo "<br />";
        //www.lasermemory.com/lsrpc
        echo "www.lasermemory.com/lsrpc pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.lasermemory.com","www.lasermemory.com/lsrpc");
        echo "<br />";
        //www.snipsnap.org/RPC2
        echo "www.snipsnap.org/RPC2 pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.snipsnap.org","www.snipsnap.org/RPC2");
        echo "<br />";
        //1470.net/api/ping
        echo "1470.net/api/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","1470.net","1470.net/api/ping");
        echo "<br />";
        //bblog.com/ping.php
        echo "bblog.com/ping.php işlemi ";
        xmlrpc_ping("weblogUpdates.ping","bblog.com","bblog.com/ping.php");
        echo "<br />";
        //blog.goo.ne.jp/XMLRPC
        echo "blog.goo.ne.jp/XMLRPC pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","blog.goo.ne.jp","blog.goo.ne.jp/XMLRPC");
        echo "<br />";
        //blogdb.jp/xmlrpc
        echo "blogdb.jp/xmlrpc pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","blogdb.jp","blogdb.jp/xmlrpc");
        echo "<br />";
        //blogmatcher.com/u.php
        echo "blogmatcher.com/u.php pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","blogmatcher.com","blogmatcher.com/u.php");
        echo "<br />";
        //coreblog.org/ping
        echo "coreblog.org/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","coreblog.org","coreblog.org/ping");
        echo "<br />";
        //ping.bloggers.jp/rpc
        echo "ping.bloggers.jp/rpc pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.bloggers.jp","ping.bloggers.jp/rpc");
        echo "<br />";
        //ping.cocolog-nifty.com/xmlrpc
        echo "ping.cocolog-nifty.com/xmlrpc pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.cocolog-nifty.com","ping.cocolog-nifty.com/xmlrpc");
        echo "<br />";
        //ping.blogmura.jp/rpc
        echo "ping.blogmura.jp/rpc pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.blogmura.jp/rpc","ping.blogmura.jp/rpc");
        echo "<br />";
        //ping.exblog.jp/xmlrpc
        echo "ping.exblog.jp/xmlrpc pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.exblog.jp","ping.exblog.jp/xmlrpc");
        echo "<br />";
        //ping.myblog.jp
        echo "ping.myblog.jp pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.myblog.jp","ping.myblog.jp");
        echo "<br />";

        // weblogs.com
        echo "Weblogs.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","rpc.weblogs.com","http://rpc.weblogs.com/RPC2");
        echo "<br />";
        // weblogs.se
        echo "Weblogs.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","ping.weblogs.se","http://ping.weblogs.se");
        echo "<br />";
        // audiorpc.weblogs.com
        echo "Weblogs.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","audiorpc.weblogs.com","http://audiorpc.weblogs.com/RPC2");
        echo "<br />";
        // icerocket.com
        echo "Icerocket.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","rpc.icerocket.com","http://rpc.icerocket.com:10080/");
        echo "<br />";
        // blogdigger.com
        echo "Blogdigger.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","www.blogdigger.com","http://www.blogdigger.com/RPC2");
        echo "<br />";
        // yahoo.com
        echo "Yahoo.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","api.my.yahoo.com","http://api.my.yahoo.com/RPC2");
        echo "<br />";
        // api.my.yahoo.com/rss/ping
        echo "api.my.yahoo.com/rss/ping pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","api.my.yahoo.com","api.my.yahoo.com/rss/ping");
        echo "<br />";
        // yahoo.co.jp
        echo "api.my.yahoo.co.jp/RPC2 pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","api.my.yahoo.co.jp","http://api.my.yahoo.co.jp/RPC2");
        echo "<br />";
        // moreover.com
        echo "Moreover.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","api.moreover.com","http://api.moreover.com/RPC2");
        echo "<br />";
        echo "Moreover.com pingleme işlemi ";
        xmlrpc_ping("weblogUpdates.ping","api.moreover.com","http://api.moreover.com/ping");
        echo "<br />";
        // pingomatic.com
        echo "Pingomatic.com'daki sitelerine pingleme işlemi ";
        $veri = @file_get_contents("http://pingomatic.com/ping/?title=".urldecode($siteAdi)."&blogurl=".urldecode($siteURL)."&rssurl=".urldecode($siteRssURL)."&chk_blogs=on&chk_syndic8=on&chk_pubsubcom=on&chk_blogstreet=on&chk_weblogalot=on&chk_newsisfree=on&chk_topicexchange=on&chk_tailrank=on&chk_bloglines=on&chk_aiderss=on");

        if (preg_match('|Ping sent.|', $veri)) {
            echo "<span style='color:blue'>Başarılı</span>";
        } else {
            echo "<span style='color:red'>Başarısız</span>";
        }
    }
    public function tumuneTelifresmi(){
        $tikla = $_POST["tikla"];
        if($tikla > 10){
            $limit = $tikla.",10";
        }else{
            $limit = "10";
        }
        $model = $this->newmodel;
        $form = $this->load->otherClasses('Form');
        $image = $this->load->otherClasses("Resim");
        $ayarmodel = $model->get_single();
        $baslikList = $this->sqlSorgu("SELECT * FROM ".PREFIX."baslik");
        $kategoriList = $this->sqlSorgu("SELECT * FROM ".PREFIX."kategori");
        $urunList = $this->sqlSorgu("SELECT * FROM ".PREFIX."urun");
        $projekategoriList = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje_kategori");
        $projeList = $this->sqlSorgu("SELECT * FROM ".PREFIX."proje");
        $hizmetkategoriList = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet_kategori");
        $hizmetList = $this->sqlSorgu("SELECT * FROM ".PREFIX."hizmet");
        $haberList = $this->sqlSorgu("SELECT * FROM ".PREFIX."makale");
        $etkinlikList = $this->sqlSorgu("SELECT * FROM ".PREFIX."etkinlik");

        $array = array(
            "baslik"=>$baslikList,
            "urun"=>$urunList,
            "kategori"=>$kategoriList,
            "proje"=>$projeList,
            "proje_kategori"=>$projekategoriList,
            "hizmet"=>$hizmetList,
            "hizmet_kategori"=>$hizmetkategoriList,
            "makale"=>$haberList,
            "etkinlik"=>$etkinlikList
        );
        try {
            foreach ($array as $key2 => $value2) {
                $tablo = $key2;
                foreach ($value2 as $value) {
                    if($tablo=="proje_kategori" || $tablo=="hizmet_kategori"){
                        $resim = $value["kategori_resmi"];
                        $tablo2 = "kategori";
                    }else{
                        $resim = $value[$tablo."_resmi"];
                        $tablo2 = $tablo;
                    }
                    $uzanti=substr($resim,-4,4);
                    $search  = array($uzanti,"resimler",$tablo);
                    $replace = array("","","");
                    $yeniresimadi = str_replace($search,$replace,$fileName);
                    $yeni_ad2="resimler/".$tablo."/".$form->seo($yeniresimadi)."-".$nowdate."-yeni".$uzanti;
                    if (file_exists(USTDIZIN.$resim) and $resim!=""){
                        if($tikla < "10"){
                            $image  ->load(USTDIZIN.$resim);
                            $image  ->fit_to_width(900);
                            $image  ->save(USTDIZIN.$yeni_ad2);
                            $telifresim =array(
                                "jpg"=>USTDIZIN.$yeni_ad2,
                                "telif_resmi"=>USTDIZIN.$ayarmodel[0]["telif_resmi"],
                                "ayarlar"=>$ayarmodel[0],
                                "yeniResim"=>USTDIZIN.$yeni_ad2,
                            );
                            $image->resimHologram($telifresim);
                            $data8['id'] = $value["id"];
                            $data8[$tablo.'_resmi_yeni'] = $yeni_ad2;
                            $model->telifresimleriGuncelle($tablo,$data8);
                        }
                    }
                    $sayisine = $this->sqlSorgu("SELECT * FROM ".PREFIX.$tablo."_resim WHERE ".$tablo2."_id = :id", array(":id"=>$value["id"]));
                    if(count($sayisine) >0){
                        $resimler["toplamsayi"] += count($sayisine);
                    }
                    $resimler[$tablo][] = $this->sqlSorgu("SELECT * FROM ".PREFIX.$tablo."_resim WHERE ".$tablo2."_id = :id limit ".$limit, array(":id"=>$value["id"]));
                }
                foreach ($resimler[$tablo] as $value3) {
                    if($value3){
                        $tumresimler[] = $value3;
                        foreach ($value3 as $key => $value4) {
                            $resim = $value4["resim_link"];
                            $resim_link[] = $value4["resim_link"];
                            if (file_exists(USTDIZIN.$resim)){
                                $uzanti=substr($resim,-4,4);
                                $search  = array($uzanti,"resimler",$tablo);
                                $replace = array("","","");
                                $yeniresimadi = str_replace($search,$replace,$fileName);
                                $yeni_ad3="resimler/".$tablo."/".$form->seo($yeniresimadi)."-".$nowdate."-yeni".$uzanti;
                                $image  ->load(USTDIZIN.$resim);
                                $image  ->fit_to_width(900);
                                $image  ->save(USTDIZIN.$yeni_ad3);
                                $telifresim =array(
                                    "jpg"=>USTDIZIN.$yeni_ad3,
                                    "telif_resmi"=>USTDIZIN.$ayarmodel[0]["telif_resmi"],
                                    "ayarlar"=>$ayarmodel[0],
                                    "yeniResim"=>USTDIZIN.$yeni_ad3,
                                );
                                $image->resimHologram($telifresim);
                                $data9['id'] = $value4["id"];
                                $data9["resim_link_yeni"] = $yeni_ad3;
                                $model->telifekresimleriGuncelle($tablo,$data9);
                            }
                        }
                    }
                }
            }
            $sonuc["kalantık"] = $resimler["toplamsayi"] - $tikla;
            $sonuc["mesaj"] = "başarıyla uygulanıyor kalan resim = (".$sonuc["kalantık"].") , işlem devam ediyor lütfen kapatmayınız!...";
            $sonuc["tumresimler"] = $tumresimler;
            $sonuc["resim_link"] = $resim_link;
            $sonuc["toplamsayi"] = $resimler["toplamsayi"];
            $sonuc["tikla"] = $tikla;
            $sonuc["limit"] = $limit;
            echo json_encode($sonuc);
        }catch (Exception $e) {
            $sonuc["mesaj"] = "Başarısız";
            echo json_encode($sonuc);
        }
    }


}
