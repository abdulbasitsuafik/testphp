<?php
class Memberships extends Controller{
    public function __construct() {
        parent::__construct();
        $this->indexController = $this->load->controllers("index");
        $this->newmodel = $this->load->model("uyelik_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->system_tools = $this->load->otherClasses("SystemTools");

        $this->islemController = $this->load->controllers("islemler");
        $this->indexController = $this->load->controllers("index");
    }

    public function index(){
//        $this->login();
        $data["title"] = "Sınav Sistemi";
        $this->view->render("memberships/index", $data);
    }
    public function send_to_api($url,$jsonData=[]){
        $ch = curl_init();
        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }
    public function standart_get_api_function(){
        if($_POST){
            $form = $this->newform;
            $statusCode = 200;
            $response = [];
            if($form->submit()){
                $jsonData = [
                    "device_id"=> @$_SESSION["device_id"],
                    "access_token"=> @$_SESSION["userToken"],
                ];
                foreach ($_POST["new_data"] as $index => $new_datum) {
                    $jsonData[$index] = $_POST["new_data"][$index];
                }
                $result = $this->send_to_api($_POST["url"],$jsonData);
                if($result["status_code"]==200){
                    $response = $result;
//                    $response["link"] = SITE_URL."memberships/home";

                    if($result["user"]){
                        Session::set("user", $result["user"]);
                        $response["user"] = $result["user"];
                        $response["user_session"] = $_SESSION["user"];
                    }

                    $response["status"] = true;
                    $response["alert"] = false;
                    $response["title"] = @$result["title"];
                    $response["message"] = @$result["message"];
                    $response["post"] = $_POST;

                    if($result["random_code"]){
                        ob_start();
//                        $data["response"] = $result;
//                        $this->view->render("memberships/signup_modal",$data,"1");
//                        $renderView = ob_get_clean();
//
//                        $response["renderView"] = $renderView;
                        $response["array"] = $response;
                        $response["modal"] = true;
                        $response["alert"] = false;
                    }

                    if($_POST["theme_tpl"]){
                        ob_start();
                        $data["response"] = $response;
                        $this->view->render($_POST["theme_tpl"],$data,"1");
                        $renderView = ob_get_clean();

                        $response["renderView"] = $renderView;
                    }
                }else{
                    $response = $result;
                    $response["status"] = false;
                    $response["$result"] = $result;
                    $response["_POST"] = $_POST;
                }

//            return $this->system_tools->json_response($response,$statusCode);
                echo json_encode($response);
            }
        }else{
            $data["title"] = "Giriş";
            if(Session::get("uye_giris") == true){
                header("Location: ". SITE_URL."memberships/home");
            }
//            $data["browser_info"] = $this->newform->getBrowser();
//            $data["login"] = true;
//            $this->view->render("memberships/login", $data);
        }

    }
    public function home(){
        Session::checkSession();
        $data["title"] = "Anasayfa";
        $this->view->render("memberships/home", $data);
    }
    public function subjects(){
        Session::checkSession();
        $data["title"] = "Konular";
        $this->view->render("memberships/subjects", $data);
    }
    public function sections(){
        Session::checkSession();
        $data["title"] = "Bölümler";
        $this->view->render("memberships/sections", $data);
    }
    public function exams(){
        Session::checkSession();
        $data["title"] = "Sınavlar";
        $this->view->render("memberships/exams", $data);
    }
    public function award_exam(){
        Session::checkSession();
        $data["title"] = "Ödüllü Sınav";
        $this->view->render("memberships/award_exam", $data);
    }
    public function store(){
        Session::checkSession();
        $data["title"] = "Mağaza";
        $this->view->render("memberships/store", $data);
    }
    public function profile(){
        Session::checkSession();
        $data["title"] = "Profil";
        $this->view->render("memberships/profile", $data);
    }
    public function leaderboard(){
        Session::checkSession();
        $data["title"] = "Lider Tablosu";
        $this->view->render("memberships/leaderboard", $data);
    }
    public function bag(){
        Session::checkSession();
        $data["title"] = "Çanta";
        $this->view->render("memberships/bag", $data);
    }
    public function exam(){
        Session::checkSession();
        $data["title"] = "Sınav Başladı";
        $this->view->render("memberships/exam", $data);
    }
    public function myexams(){
        Session::checkSession();
        $data["title"] = "Çözdüğüm Testler";
        $this->view->render("memberships/myexams", $data);
    }
    public function notifications(){
        Session::checkSession();
        $data["title"] = "Bildirimler";
        $this->view->render("memberships/notifications", $data);
    }
    public function contact(){
        Session::checkSession();
        $data["title"] = "İletişim";
        $this->view->render("memberships/contact", $data);
    }
    public function myinfos(){
        Session::checkSession();
        $data["title"] = "Bilgilerim";
        $this->view->render("memberships/myinfos", $data);
    }
    public function signupModal(){
        $id = @$_POST["id"];
        $array = @$_POST["array"];
        $model = $this->load->model("index_model");
        $data["title"] = $array["message"];
        $data["random_code"] = $array["random_code"];

        ob_start();
        $this->view->render("memberships/signup_modal", $data,"1");
        $renderView = ob_get_clean();

        $response["renderView"] = $renderView;
        echo json_encode($response);
    }
    public function signup(){
        Session::init();
        if($_POST){
            $form = $this->newform;
            $form   ->post('username');
            $form   ->post('password');

            $statusCode = 200;
            $response = [];
            if($form->submit()){
                $jsonData = [
                    "device_id"=> @$form->values["device_id"] ? @$form->values["device_id"] : @$_SESSION["device_id"],
                    "access_token"=> "",

                    "name"=> $form->values["name"],
                    "surname"=> $form->values["surname"],
                    "username"=> $form->values["username"],
                    "password"=> $form->values["password"],
                    "password_repeat"=> $form->values["password_repeat"],
                    "phone_number"=> $form->values["phone_number"],
                    "email"=> $form->values["email"],
                    "email_repeat"=> $form->values["email_repeat"],
                    "city"=> $form->values["city"],
                    "town"=> $form->values["town"],
                    "school"=> $form->values["school"],
                    "class"=> $form->values["class"],
                    "lesson"=> $form->values["lesson"],
                    "avatar"=> $form->values["avatar"],
                ];
                $result = $this->send_to_api($_POST["url"],$jsonData);
                if($result["status_code"]==200){
                    $user = $result["user"];
                    $access_token = $result["access_token"];

                    $response = $result;
                    $response["link"] = SITE_URL."memberships/home";
                    $response["status"] = true;
                    $response["title"] = $result["title"];
                    $response["message"] = $result["message"];

                }else{
                    $response = $result;
                    $response["status"] = false;
                    $response["post"] = $_POST;
                }

//            return $this->system_tools->json_response($response,$statusCode);
                echo json_encode($response);
            }
        }else{
            $data["title"] = "Kayıt Ol";
            if(Session::get("uye_giris") == true){
                header("Location: ". SITE_URL."memberships/home");
            }
            $data["browser_info"] = $this->newform->getBrowser();
            $data["login"] = true;
            $this->view->render("memberships/signup", $data);
        }
    }
    public function result(){
        Session::checkSession();
        $data["title"] = "Sonuç";
        $this->view->render("memberships/result", $data);
    }

    public function login(){
        if($_POST){
            $form = $this->newform;
            $form   ->post('username');
            $form   ->post('password');

            $statusCode = 200;
            $response = [];
            if($form->submit()){
                $jsonData = [
                    "device_id"=> @$form->values["device_id"] ? @$form->values["device_id"] : @$_SESSION["device_id"],
                    "access_token"=> "",

                    "username"=> $form->values["username"],
                    "password"=> $form->values["password"],
                ];
                $result = $this->send_to_api($_POST["url"],$jsonData);
                if($result["status_code"]==200){
                    $user = $result["user"];
                    $access_token = $result["access_token"];
                    Session::init();
                    Session::set("userToken", $access_token);
                    Session::set("user", $user);
                    Session::set("uye_giris", true);
                    Session::set("uye_adi", $result["user"]["full_name"]);
                    Session::set("uye_email", $result["user"]["username"]);
                    Session::set("uye_id", $result["user"]["id"]);
                    Session::set("avatar", $result["user"]["avatar"]);
                    Session::set("name", $result["user"]["name"]);
                    Session::set("surname", $result["user"]["surname"]);
                    Session::set("phone_number", $result["user"]["phone_number"]);
                    Session::set("username", $result["user"]["username"]);

                    $response = $result;
                    $response["link"] = SITE_URL."memberships/home";
                    $response["status"] = true;
                    $response["title"] = $result["title"];
                    $response["message"] = $result["message"];

                }else{
                    $response = $result;
                    $response["status"] = false;
                }

//            return $this->system_tools->json_response($response,$statusCode);
                echo json_encode($response);
            }
        }else{
            $data["title"] = "Giriş";
            if(Session::get("uye_giris") == true){
                header("Location: ". SITE_URL."memberships/home");
            }
            $data["browser_info"] = $this->newform->getBrowser();
            $data["login"] = true;
            $this->view->render("memberships/login", $data);
        }

    }
    public function logout(){
//        $_SESSION ="";
        Session::init();
//        Session::destroy();
        if($_POST){
            $jsonData = [
                "device_id"=> @$_SESSION["device_id"],
                "access_token"=> @$_SESSION["userToken"],
            ];
            $result = $this->send_to_api($_POST["url"],$jsonData);

            $response = $result;
            $response["link"] = SITE_URL."memberships";
            $response["status"] = true;
            $response["title"] = $result["title"];
            $response["message"] = $result["message"];

            Session::set("uye_giris", false);
            Session::set("uye_adi", "");
            Session::set("user", "");
            Session::set("userToken", "");
            Session::set("uye_email", "");
            Session::set("uye_id", "");
            Session::set("uye_yetki","");

            Session::set("avatar", "");
            Session::set("name", "");
            Session::set("surname", "");
            Session::set("phone_number", "");
            Session::set("username", "");
            echo json_encode($response);
//            header( "refresh:3;url=".SITE_URL."memberships" );
        }
    }
    public function forget(){
//        $_SESSION ="";
        Session::init();
//        Session::destroy();
        if($_POST){
            $jsonData = [
                "device_id"=> @$_SESSION["device_id"],
                "access_token"=> @$_SESSION["userToken"],
                "email"=>$_POST["email"],
                "phone_number"=> $_POST["phone_number"],
            ];
            $result = $this->send_to_api($_POST["url"],$jsonData);

            $response = $result;
            if($response["status_code"]!=200){
                $response["status"] = false;
            }else{
                $response["link"] = SITE_URL."memberships/forgetAccept";
                $response["status"] = true;
            }
            $response["title"] = $result["title"];
            $response["message"] = $result["message"];
            $response["post"] =$_POST;

            echo json_encode($response);
//            header( "refresh:3;url=".SITE_URL."memberships" );
        }else{
            $data["title"] = "Şifre Onay";
            if(Session::get("uye_giris") == true){
                header("Location: ". SITE_URL."memberships/home");
            }
            $data["browser_info"] = $this->newform->getBrowser();
            $data["login"] = true;
            $this->view->render("memberships/forget", $data);
        }
    }

    public function forgetAccept(){
//        $_SESSION ="";
        Session::init();
//        Session::destroy();
        if($_POST){
            $jsonData = [
                "device_id"=> @$_SESSION["device_id"],
                "access_token"=> @$_SESSION["userToken"],
                "email"=>$_POST["email"],
                "phone_number"=> $_POST["phone_number"],
                "type"=> $_POST["type"],
                "code"=> $_POST["code"],
                "password"=> $_POST["password"],
                "password_repeat"=> $_POST["password_repeat"],
            ];
            $result = $this->send_to_api($_POST["url"],$jsonData);

            $response = $result;
            if($response["status_code"]!=200){
                $response["status"] = false;
            }else{
                $response["link"] = SITE_URL."memberships/login";
                $response["status"] = true;
            }
            $response["title"] = $result["title"];
            $response["message"] = $result["message"];

            echo json_encode($response);
//            header( "refresh:3;url=".SITE_URL."memberships" );
        }else{
            $data["title"] = "Şifre Onay";
            if(Session::get("uye_giris") == true){
                header("Location: ". SITE_URL."memberships");
            }
            $data["browser_info"] = $this->newform->getBrowser();
            $data["login"] = true;
            $this->view->render("memberships/forgetAccept", $data);
        }
    }



    public function smsGonder($data){
        set_time_limit(0);
        date_default_timezone_set('Europe/Istanbul');
        function sendRequest($site_name,$send_xml,$header_type=array('Content-Type: text/xml'))
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$site_name);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$send_xml);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header_type);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
            $result = curl_exec($ch);
            return $result;
        }
        $xml = '<SMS>'.
            '<oturum>'.
            '<kullanici>000000000</kullanici>'.
            '<sifre>000000</sifre>'.
            '</oturum>'.
            '<headlines>headlines</headlines>'.
            '<mesaj>'.
            '<metin>Sayin '.$data["adi"].', giriş bilgileriniz; kullanıcı adı: '.$data["email"].', parola: '.$data["parola2"].' giriş adresi:http://www.yeniayhukuk.com.tr/takip</metin>'.
            '<alicilar>'.$data["telefon"].'</alicilar>'.
            '</mesaj>'.
            '<karaliste>kendi</karaliste>'.
            '<tarih></tarih>'.
            '<izin_link>false</izin_link>'.
            '<izin_telefon>false</izin_telefon>'.
            '</SMS>';
        $sonuc  = sendRequest('http://www.dakiksms.com/api/tr/xml_api_ileri.php', $xml);
        if (substr($sonuc, 0, 2) == 'OK')
        {
            list($ok, $mesaj_id) = explode('|', $sonuc);
            //echo 'Mesaj gönderildi. Rapor için ' . $mesaj_id . ' kodunu kullanabilirsiniz.';
            return "true";
        }elseif (substr($sonuc, 0, 3) == 'ERR'){
            list($err, $mesaj) = explode('|', $sonuc);
            //echo 'Hata (' . $err . ') oluştu. ' . $mesaj;
            return "false";
        }else{
            //echo 'Bilinmeyen bir hata oluştu. ' . $sonuc;
            return "false";
        }
    }
    public function rastgele($text) {
//        $mevcut = "1234567890";
//        $salla = "";
//        for($i=0;$i<$text;$i++) {
//            $salla .= $mevcut{rand(0,9)};
//        }
//        return $salla;
    }
    public function formMailGonder($kime,$konu,$mesaj){
        $model = $this->newmodel;
        $form = $this->newform;
        $sitebilgi = $model->site_ayarlari();
        $path = "public/eklentiler/";
        $sitegelenmail = explode(",", $kime);
        require_once($path."phpmailer/class.phpmailer.php");
        if(strpos($_SERVER["SERVER_NAME"], "localhost")){
            $secure = "tls";
            $host = "smtp.yandex.com";
            $port = "587";
            $username = "tolga@tolga.com.tr";
            $pass = "tolga1245";
        }else{
            $secure = $sitebilgi[0]['formmail_secure'];
            $host = $sitebilgi[0]['formmail_host'];
            $port = $sitebilgi[0]['formmail_port'];
            $username = $sitebilgi[0]['formmail_mail'];
            $pass = $sitebilgi[0]['formmail_sifre'];
        }
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Timeout = 20;
        $mail->SMTPDebug = 0; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = $secure; // Güvenli baglanti icin ssl normal baglanti icin tls
        $mail->Host = $host; // Mail sunucusuna ismi
        $mail->Port = $port; // Gucenli baglanti icin 465 Normal baglanti icin 587
        $mail->IsHTML(true);
        $mail->SetLanguage("tr", "phpmailer/language");
        $mail->CharSet  ="utf-8";
        $mail->Username = $username; // Mail adresimizin kullanicı adi
        $mail->Password = $pass; // Mail adresimizin sifresi
        $mail->SetFrom($username,$sitebilgi[0]['unvani'] ); // Mail attigimizda gorulecek ismimiz
        $mail->AddAddress($sitegelenmail['0']); // Maili gonderecegimiz kisi yani alici
        $sayi = count($sitegelenmail);
        for($i = 1; $i<=$sayi;$i++){
            if($sitegelenmail[$i]!=''){
                $mail->AddBCC($sitegelenmail[$i]);
            }
        }
        $mail->Subject = $konu; // Konu basligi
        $mail->Body = $mesaj; // Mailin icerigi
        if(!$mail->Send()){
            //echo "Mailer Error: ".$mail->ErrorInfo;
            return "false";
        } else {
            //echo "Mesaj gonderildi";
            return "true";
        }
    }
    public function facebookCikis(){

        // Remove access token from session
        unset($_SESSION['facebook_access_token']);

        // Remove user data from session
        unset($_SESSION['userData']);

        // Redirect to the homepage
        header("Location:".SITE_URL."memberships/facebook");
    }
    public function facebookConfig(){
        /*if(!session_id()){
            session_start();
        }*/
        //error_reporting(E_ALL);
        //ini_set('display_errors', 1);
        date_default_timezone_set('Europe/Istanbul');
        // Include the autoloader provided in the SDK
        require_once 'vendor/Facebook/autoload.php';

        /*
         * Configuration and setup Facebook SDK
         */
        $appId         = '226265081271105'; //Facebook App ID
        $appSecret     = 'b9e67d41372c12a96e1734d2f98101b7'; //Facebook App Secret
        $redirectURL   = SITE_URL.'memberships/facebook/'; //Callback URL
        $fbPermissions = array('email');  //Optional permissions

        $fb = new Facebook\Facebook(array(
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v2.2',
        ));
        return array("fb"=>$fb,"redirectURL"=>$redirectURL,"fbPermissions"=>$fbPermissions);
    }
    public function facebook(){
        $facebookConfig = $this->facebookConfig();
        $fb = $facebookConfig["fb"];
        $redirectURL=$facebookConfig["redirectURL"];
        $fbPermissions=$facebookConfig["fbPermissions"];
        // Get redirect login helper
        $helper = $fb->getRedirectLoginHelper();

        // Try to get access token
        try {
            if(isset($_SESSION['facebook_access_token'])){
                $accessToken = $_SESSION['facebook_access_token'];
            }else{
                  $accessToken = $helper->getAccessToken();
            }
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
             echo 'Graph returned an error: ' . $e->getMessage();
              exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
        }
        if(isset($accessToken)){
            if(isset($_SESSION['facebook_access_token'])){
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }else{
                // Put short-lived access token in session
                $_SESSION['facebook_access_token'] = (string) $accessToken;

                  // OAuth 2.0 client handler helps to manage access tokens
                $oAuth2Client = $fb->getOAuth2Client();

                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

                // Set default access token to be used in script
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }

            // Redirect the user back to the same page if url has "code" parameter in query string
            if(isset($_GET['code'])){
                //header('Location: ./');
            }

            // Getting user facebook profile info
            try {
                $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,cover,picture,birthday,education,location{location}');
                $fbUserProfile = $profileRequest->getGraphNode()->asArray();
            } catch(FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                session_destroy();
                // Redirect user back to app login page
                header("Location: ./");
                exit;
            } catch(FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            //$fbUserProfile = $user->checkUser($fbfbUserProfile);

            // Put user data into session
            //$_SESSION['fbUserProfile'] = $fbUserProfile;

            // Get logout url
            $logoutURL = $helper->getLogoutUrl($accessToken, SITE_URL.'memberships/facebookCikis');

            // Render facebook profile data
                $output  = '<h2 style="color:#999999;">Facebook Profil Detayları</h2>';
                $output .= '<div style="position: relative;">';
                $output .= '<img src="'.$fbUserProfile['cover']["source"].'" />';
                $output .= '<img style="position: absolute; top: 90%; left: 25%;" src="'.$fbUserProfile['picture']["url"].'"/>';
                $output .= '</div>';
                $output .= '<br/>Facebook ID : '.$fbUserProfile['id'];
                $output .= '<br/>Ad Soyad : '.$fbUserProfile['first_name'].' '.$fbUserProfile['last_name'];
                $output .= '<br/>Email : '.$fbUserProfile['email'];
                $output .= '<br/>Cinsiyet : '.$fbUserProfile['gender'];
                $output .= '<br/>Dil : '.$fbUserProfile['locale'];
                $output .= '<br/>Profile Linki : <a href="'.$fbUserProfile['link'].'" target="_blank">Facebook Profil Sayfası</a>';
                $output .= '<br/>Çıkış yap <a href="'.$logoutURL.'">Çıkış Yap</a>';
                echo "<pre>";
                print_r($fbUserProfile);
                echo "<pre>";


                //$friendsRequest = $fb->get('/me/taggable_friends');
                //print_r( $friendsRequest);

            $model = $this->newmodel;
            $form = $this->newform;
                $mailVarmi = $model->mailSor($fbUserProfile["email"]);
                if(count($mailVarmi) < 1){
                    $data = array(
                        "adi"=>$fbUserProfile["name"],
                        "email"=>$fbUserProfile["email"],
                        "telefon"=>"",
                        "il"=>$fbUserProfile["location"]["location"]["city"],
                        "parola"=>$accessToken,
                        "status"=>"1",
                        "yetki"=>"1",
                        "kod"=>"facebookkod-".strtotime("now")
                        );
                    $uye_id = $model->uyeol($data);

                    Session::init();
                    Session::set("uye_giris", true);
                    Session::set("uye_adi", $fbUserProfile["name"]);
                    Session::set("uye_email", $fbUserProfile["email"]);
                    Session::set("uye_id", $uye_id);
                    Session::set("uye_yetki", 1);
                }else{
                    Session::init();
                    Session::set("uye_giris", true);
                    Session::set("uye_adi", $fbUserProfile["name"]);
                    Session::set("uye_email", $fbUserProfile["email"]);
                    Session::set("uye_id", $mailVarmi[0]["id"]);
                    Session::set("uye_yetki", 1);
                }
                header("Location:".SITE_URL."memberships/profil");
        }else{
            // Get login url
            $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);

            // Render facebook login button
            $output = '<a href="'.htmlspecialchars($loginURL).'">Facebook ile giriş Yap!</a>';
            //header("Location:".SITE_URL."memberships/giris");
        }
        ?>

        <html>
        <head>
        <title>Facebook ile Giriş</title>
        </head>
        <body>
            <div><?php echo $output; ?></div>
        </body>
        </html>
        <?php
    }
    public function google(){
        $model = $this->newmodel;
        $form = $this->newform;
        //error_reporting(E_ALL);
        //ini_set('display_errors', 1);
        require_once 'vendor/autoload.php';
        //include_once 'src/Google_Client.php';
        //include_once 'src/contrib/Google_Oauth2Service.php';

        /*
         * Configuration and setup Google API
         */
        $clientId = '945391129195-i4752kejm4g3maif96pjuc82r9bvne0s.apps.googleusercontent.com';
        $clientSecret = 'OoTHOceSRRoc5_SYM3atjJkw';
        $redirectURL = SITE_URL.'memberships/google';

        //Call Google API
        $client = new Google_Client();
        $client->setApplicationName('İntercheckup');
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectURL);
        $client->setScopes(array("email","profile"));
        $plus = new Google_Service_Plus($client);
        if (isset($_REQUEST['logout'])) {
                unset($_SESSION['access_token']);
        }

        if (isset($_GET['code'])) {
                if (strval($_SESSION['state']) !== strval($_GET['state'])) {
                        error_log('The session state did not match.');
                        exit(1);
                }

                $client->authenticate($_GET['code']);
                $_SESSION['access_token'] = $client->getAccessToken();
                header('Location: ' . SITE_URL."memberships/giris");
        }

        if (isset($_SESSION['access_token'])) {
                $client->setAccessToken($_SESSION['access_token']);
        }

        if ($client->getAccessToken() && !$client->isAccessTokenExpired()) {
                try {
                        $googlePlus = $plus->people->get('me');
                        $email = $googlePlus["modelData"]["emails"][0]["value"];
                        if($email){
                            $mailVarmi = $model->mailSor($email);
                            if(count($mailVarmi) < 1){
                                $data = array(
                                    "adi"=>$googlePlus["displayName"],
                                    "email"=>$email,
                                    "telefon"=>"",
                                    "il"=>"20",
                                    "parola"=>$_SESSION['access_token'],
                                    "durum"=>"1",
                                    "yetki"=>"1",
                                    "kod"=>"googlekod-".strtotime("now")
                                    );
                                $uye_id = $model->uyeol($data);

                                Session::init();
                                Session::set("uye_giris", true);
                                Session::set("uye_adi", $googlePlus["name"]);
                                Session::set("uye_email", $email);
                                Session::set("uye_id", $uye_id);
                                Session::set("uye_yetki", 1);
                            }else{
                                Session::init();
                                Session::set("uye_giris", true);
                                Session::set("uye_adi", $googlePlus["displayName"]);
                                Session::set("uye_email", $email);
                                Session::set("uye_id", $mailVarmi[0]["id"]);
                                Session::set("uye_yetki", 1);
                            }
                            header('Location: ' . SITE_URL."memberships/profil");
                        }else{
                            return array("loginUrl"=>$client->createAuthUrl(),"googleplus"=>$googlePlus);
                        }
                } catch (Google_Exception $e) {
                        error_log($e);
                        //$body = htmlspecialchars($e->getMessage());
                        header('Location: ' . SITE_URL."memberships/profil");
                }
                # the access token may have been updated lazily
                $_SESSION['access_token'] = $client->getAccessToken();
        } else {
                $state = mt_rand();
                $client->setState($state);
                $_SESSION['state'] = $state;
                return array("loginUrl"=>$client->createAuthUrl());
        }
    }
}
