<?php
class Users extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
        $this->newmodel = $this->load->model("users_model");
        $this->store_model = $this->load->model("store_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->actions = $this->load->controllers("actions");
        $this->general = $this->load->controllers("general");
        $this->device_model = $this->load->model("device_model");
        $this->settings_model = $this->load->model("settings_model");
        $this->system_tools = $this->load->otherClasses("SystemTools");
        $this->admitad_model = $this->load->model("admitad_model");
    }

    public function index() {
        echo "Welcome to User api";
    }
    private function setDeviceInfo($device=null,$content)
    {
        $device_id = @$content["device_id"];
        $brand = @$content["brand"];
        $model = @$content["model"];
        $os_type = @$content["os_type"];
        $os_version = @$content["os_version"];
        $app_version = @$content["app_version"];
        $local_language = @$content["local_language"];
        $push_token = @$content["push_token"];
        $access_token = @$content["access_token"];
        $created_at = @$content["created_at"];
        $updated_at = @$content["updated_at"];
        $logout = @$content["logout"];
        $user = @$content["user"];

//        if(!$access_token || $access_token == "null" || $access_token == null){
//            $access_token = $this->system_tools->v4();
//        }
        $device = $this->device_model->find_device(["device_id" => $device_id]);

        if (!$device) {
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            $datas = [
                "device_id" =>$device_id,
                "brand" =>$brand,
                "model" =>$model,
                "os_type" =>$os_type,
                "os_version" =>$os_version,
                "app_version" =>$app_version,
                "local_language" =>$local_language,
                "created_at" =>$created_at,
                "updated_at" =>$updated_at
            ];
            if($user == 0 || $user == 1 || $user){
                $datas["user"] = $user;
            }
            if($push_token){
                $datas["push_token"] = $push_token;
            }
            if($logout == 0 || $logout == 1){
                $datas["logout"] = $logout;
            }
            $this->device_model->insert_device($datas);
            $device = $this->device_model->find_device(["device_id" => $device_id]);
        }else{
            $update_data = [
                "device_id" =>$device_id,
                "updated_at" =>$updated_at,
            ];
            if($push_token){
                $update_data["push_token"] = $push_token;
            }
            $update_data["access_token"] = $access_token ? $access_token : "null";
            if($logout == 0 || $logout == 1){
                $update_data["logout"] = $logout;
            }
            if($user == 0 || $user > 0){
                $update_data["user"] = $user;
            }
            $this->device_model->device_update($update_data);
        }
        return $device;
    }
    public function SignupAction()
    {
        /**
         * Content alındı
         */
        $statusCode = 200;
        try {

            $content = json_decode(file_get_contents('php://input'), TRUE);
            /**
             * recieving posted json data
             */
            $data = $content;

//            $push_token = @$data['push_token'];
            $device_id = $data['device_id'];
            $access_token = @$content['access_token'];

            $username = @$data['username'];
            $email = @$data['email'];
            $email_repeat = @$data['email_repeat'];
            $phone_number = @$data['phone_number'];
            $name = @$data['name'];
            $surname = @$data['surname'];

            $password = $data['password'];
            $password_repeat = $data['password_repeat'];
            $ip = $this->system_tools->get_ip_address();

            $new_password = password_hash($password, PASSWORD_DEFAULT);

            /**
             * Checking password and if password is not true returning error message
             */
            if (!$content) {
                $statusCode = 401;
                $response = [
                    "message" => "İçerik yok"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }

            if (!$name) {
                $statusCode = 401;
                $response = [
                    "message" => "Lütfen isminizi girin!",
                    "title" => "Eksik bilgi!",
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }
            if (!$surname) {
                $statusCode = 401;
                $response = [
                    "message" => "Lütfen soy isminizi girin!",
                    "title" => "Eksik bilgi!",
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }
            if (!$username) {
                $statusCode = 401;
                $response = [
                    "message" => "Lütfen bir kullanıcı adı seçin!",
                    "title" => "Eksik bilgi!",
                    "device_id"=>$device_id

                ];
                return $this->system_tools->json_response($response,$statusCode);
            }
            if (!$email) {
                $statusCode = 401;
                $response = [
                    "message" => "Lütfen bir e-posta adresi girin!",
                    "title" => "Eksik bilgi!",
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }else{
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $statusCode = 401;
                    $response = [
                        "message" => "Email adresinizi doğru formatta giriniz.",
                        "title" => "Düzeltiniz",
                    ];
                    return $this->system_tools->json_response($response,$statusCode);
                }
            }
//            if (!$email_repeat) {
//                $statusCode = 401;
//                $response = [
//                    "message" => "Lütfen bir e-posta adresi girin!",
//                    "title" => "Eksik bilgi!",
//                ];
//                return $this->system_tools->json_response($response,$statusCode);
//            }else{
//                if (!filter_var($email_repeat, FILTER_VALIDATE_EMAIL)) {
//                    $statusCode = 401;
//                    $response = [
//                        "message" => "Email adresinizi doğru formatta giriniz.",
//                        "title" => "Düzeltiniz",
//                    ];
//                    return $this->system_tools->json_response($response,$statusCode);
//                }
//            }
//            if ($email!=$email_repeat) {
//                $statusCode = 401;
//                $response = [
//                    "message" => "Emailler Eşleşmiyor",
//                    "title" => "Tekrar Deneyiniz",
//                ];
//                return $this->system_tools->json_response($response,$statusCode);
//            }
            if (!$password) {
                $statusCode = 401;
                $response = [
                    "message" => "Lütfen Şifre Giriniz!",
                    "title" => "Eksik bilgi!",
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }else{
                if (strlen($password) < 5) {
                    $statusCode = 401;
                    $response = [
                        "message" => "şifreniz 5 karakterden az olamaz",
                        "title" => "Düzeltiniz ",
                    ];
                    return $this->system_tools->json_response($response,$statusCode);
                }
            }
            if (!$password_repeat) {
                $statusCode = 401;
                $response = [
                    "message" => "Lütfen Şifrenizi Tekrar Giriniz!",
                    "title" => "Eksik bilgi!"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }

            if ($password!=$password_repeat) {
                $statusCode = 401;
                $response = [
                    "message" => "Şifreler Eşleşmiyor",
                    "title" => "Tekrar Deneyiniz",
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }

            /**
             * finding user's previous session from token's table
             */

//            $usernameOrEmail = [
//                "phone_number"=>str_replace("+9","9",$phone_number)
//            ];
//            $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
//            if ($user){
//                $statusCode = 401;
//                $response = [
//                    "message" => "Başka bir telefon numarası deneyiniz",
//                    "title" => "Bu telefon numarası mevcut"
//                ];
//                return $this->system_tools->json_response($response,$statusCode);
//            }

            $usernameOrEmail = [
                "username"=>$username,
            ];
            $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
            if ($user) {
                $statusCode = 401;
                $response = [
                    "message" => "Başka bir kullanıcı adı deneyiniz",
                    "title" => "Bu kullanıcı adı mevcut"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }
            $usernameOrEmail = [
                "email"=>$email,
            ];
            $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);

            if ($user){
                $statusCode = 401;
                $response = [
                    "message" => "Başka bir email deneyiniz",
                    "title" => "Bu email adresi mevcut",
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }
            if (!$user) {
                $datas = [
                    "username"=>$username,
                    "email"=> $email,
                    "phone_number"=> $phone_number,
                    "password"=> $new_password,
                    "name"=> $name,
                    "surname"=> $surname,
                    "full_name"=> $name." ".$surname,
                    "confirmed"=> 0,
                ];
            }

            $new_user = null;
            $devices = $this->device_model->find_device(["device_id"=>$device_id]);
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            /**
             * Bir cihaz birden fazla olabilir. Eğer hiç cihaz yoksa yeni bir kayıt açıp kullanıcı ilişkilendiriyoruz
             */
            if(!$devices){
                $statusCode = 401;
                $response = [
                    "message" => "Telefon Kaydı Mevcut Değil",
                    "device_id" => $device_id,

                ];
                return $this->system_tools->json_response($response,$statusCode);
            }else {
                if (!$user) {
                    $userId = $this->newmodel->add_user($datas);
                    $new_user = $this->newmodel->get_single_user(@$userId);
                    $datas = [
                        "device_id" => $device_id,
//                                "access_token" =>$access_token,
                        "updated_at" => $created_at,
                        "logout" => 0,
                        "user" => @$userId
                    ];
                    $device = $this->setDeviceInfo($devices, $datas);

                }
                if ($new_user) {
                    $response = array(
                        "message" => "Kayıt başarılı!",
                        "access_token" => $access_token,
                        "phone_verification" => true
                    );
                } else {
                    $statusCode = 401;
                    $response = array(
                        "message" => "Kayıt başarısız!",
                    );
                }
                return $this->system_tools->json_response($response, $statusCode);
            }
        } catch (Exception $e) {
            $statusCode = "404";
            $response = [
                "message"=>$e->getMessage()
            ];
        }
        return $this->system_tools->json_response($response,$statusCode);
    }
    public function LoginAction()
    {
        /**
         * Content alındı
         */
        $statusCode = 200;
        try {

            $content = json_decode(file_get_contents('php://input'), TRUE);
            /**
             * recieving posted json data
             */
            $data = $content;

            $device_id = @$data['device_id'];
            $access_token = @$content['access_token'];

            $usernameOrEmail = ["email"=>@$data['username']];
            $password = @$data['password'];


//            $ip = $this->system_tools->get_ip_address();

            if ( !$data['username']) {
                $statusCode = 401;
                $response = [
                    "title" => "Lütfen Bir Kullanıcı adı giriniz.",
                    "message" => "Email giriniz"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }
            if ( !$data['password']) {
                $statusCode = 401;
                $response = [
                    "title" => "Lütfen Bir Şifre giriniz.",
                    "message" => "Şifre giriniz"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }

            /**
             * finding user's previous session from token's table
             */
            $usernameOrEmail = ["email"=>@$data['username']];
            $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
            if(!$user){
                $usernameOrEmail = ["username"=>$data['username']];
                $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
//                    if(!$user){
//                        $usernameOrEmail = [
//                            "phone_number"=>str_replace("+9","9",$phone_number)
//                        ];
//                        $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
//                    }
            }
            if (!$user) {
                $statusCode = 401;
                $response = [
                    "title" => "Kullanıcı Kaydı mevcut değil",
                    "message" => "Kullanıcı Kaydı mevcut değil",
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }else{
                if ($user){
                    $user = $user[0];
                }
            }

            /**
             * Checking password and if password is not true returning error message
             */
            if ( !password_verify($password, $user["password"])) {
                $statusCode = 401;
                $response = [
                    "title" => "Yanlış Şifre denemesi",
                    "message" => "Yanlış Şifre denemesi"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }

            $devices = $this->device_model->find_device(["device_id"=>$device_id]);
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            /**
             * Bir cihaz birden fazla olabilir. Eğer hiç cihaz yoksa yeni bir kayıt açıp kullanıcı ile ilişkilendiriyoruz
             */

            if(!$devices){
                $datas = [
                    "device_id" =>$device_id,
                    "access_token" =>"null",
                    "created_at" =>$created_at,
                    "updated_at" =>$created_at,
                    "logout"=>0,
                ];
                $device = $this->setDeviceInfo(null,$datas);
                $statusCode = 401;
                $response = array(
                    "title" => "Device yok ",
                    "message" => "Device yok"
                );

                return $this->system_tools->json_response($response,$statusCode);
            }else{

                /**
                 * Eğer daha önceden bu cihazla giriş yapmış bir kullanıcı var ise o kullanıcının bilgilerini güncelliyoruz.
                 */
                $UserDevice = $this->device_model->find_device(["device_id" => $device_id]);
                $settings = $this->settings_model->get_single();

                $this->device_model->device_update_from_user(["id"=>$user["id"],"user"=>"0","logout"=>"1","access_token" =>"null",]);
                if($UserDevice){
                    $access_token = $this->system_tools->v4();
                    $datas = [
                        "device_id" =>$device_id,
                        "access_token" =>$access_token,
                        "updated_at" =>$created_at,
                        "logout"=>0,
                        "user"=>$user["id"]
                    ];
                    $device = $this->setDeviceInfo($devices,$datas);
                    $response = array(
                        "title" => "Giriş başarılı",
                        "message" => "Anasayfaya yönlendiriliyorsunuz.",
                        "access_token" => $access_token,
                        "user"=>$user,
                        "logout"=>0
                    );
                    return $this->system_tools->json_response($response,$statusCode);
                }
                /***
                 * Hem kullanıcıya ait bir kayıt yoksa ama sistemde cihaz varsa başka kullanıcıya ait bir kayıt var demektir. Giriş yapan kullanıcıya yeni bir kayıt açıyoruz.
                 */
                else{
                    $statusCode = 401;
                    $response = array(
                        "title" => "Giriş başarısız",
                        "message" => "Giriş başarısız, Farklı Telefondan Giriş sağlanamaz"
                    );

                    return $this->system_tools->json_response($response,$statusCode);
                }

            }


        } catch (Exception $e) {
            $statusCode = 404;
            $response = [
                "message"=>$e->getMessage()
            ];
            return $this->system_tools->json_response($response,$statusCode);
        }
        return $this->system_tools->json_response($response,$statusCode);
    }
    public function SignupOrLoginForSocialAction()
    {
        /**
         * Content alındı
         */
        $statusCode = 200;
        try {

            $content = json_decode(file_get_contents('php://input'), TRUE);
            /**
             * recieving posted json data
             */
            $data = $content;

            $device_id = @$data['device_id'];
            $access_token = @$content['access_token'];

            $usernameOrEmail = ["email"=>@$content['email']];

            $username = @$content['username'];
            $email = @$content['email'];
            $email_repeat = @$content['email_repeat'];
            $phone_number = @$content['phone_number'];
            $name = @$content['name'];
            $surname = @$content['surname'];

            $password = $content['password'];
            $password_repeat = $content['password_repeat'];
            $ip = $this->system_tools->get_ip_address();

            $new_password = password_hash($password, PASSWORD_DEFAULT);


//            $ip = $this->system_tools->get_ip_address();

            /**
             * finding user's previous session from token's table
             */
            $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
            if(!$user){
                $devices = $this->device_model->find_device(["device_id"=>$device_id]);
                $d = new DateTime();
                $created_at = $d->format('Y-m-d H:i:s');
                $datas = [
                    "username"=>$username,
                    "email"=> $email,
                    "phone_number"=> $phone_number,
                    "password"=> $new_password,
                    "name"=> $name,
                    "surname"=> $surname,
                    "full_name"=> "{$name} {$surname}",
                    "confirmed"=> 0,
                ];
                $userId = $this->newmodel->add_user($datas);
                $new_user = $this->newmodel->get_single_user(@$userId);
                $user = $new_user;
            }

            if (!$user) {
                $statusCode = 401;
                $response = [
                    "title" => "Kullanıcı Kaydı mevcut değil",
                    "message" => "Kullanıcı Kaydı mevcut değil",
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }else{
                if ($user){
                    $user = $user[0];
                }
            }

            /**
             * Checking password and if password is not true returning error message
             */
            if ( !password_verify($password, $user["password"])) {
                $statusCode = 401;
                $response = [
                    "title" => "Yanlış Şifre denemesi",
                    "message" => "Yanlış Şifre denemesi"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }

            $devices = $this->device_model->find_device(["device_id"=>$device_id]);
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            /**
             * Bir cihaz birden fazla olabilir. Eğer hiç cihaz yoksa yeni bir kayıt açıp kullanıcı ile ilişkilendiriyoruz
             */

            if(!$devices){
                $datas = [
                    "device_id" =>$device_id,
                    "access_token" =>"null",
                    "created_at" =>$created_at,
                    "updated_at" =>$created_at,
                    "logout"=>0,
                ];
                $device = $this->setDeviceInfo(null,$datas);
                $statusCode = 401;
                $response = array(
                    "title" => "Device yok ",
                    "message" => "Device yok"
                );

                return $this->system_tools->json_response($response,$statusCode);
            }else{

                /**
                 * Eğer daha önceden bu cihazla giriş yapmış bir kullanıcı var ise o kullanıcının bilgilerini güncelliyoruz.
                 */
                $UserDevice = $this->device_model->find_device(["device_id" => $device_id]);
                $settings = $this->settings_model->get_single();

                $this->device_model->device_update_from_user(["id"=>$user["id"],"user"=>"0","logout"=>"1","access_token" =>"null",]);
                if($UserDevice){
                    $access_token = $this->system_tools->v4();
                    $datas = [
                        "device_id" =>$device_id,
                        "access_token" =>$access_token,
                        "updated_at" =>$created_at,
                        "logout"=>0,
                        "user"=>$user["id"]
                    ];
                    $device = $this->setDeviceInfo($devices,$datas);
                    $response = array(
                        "title" => "Giriş başarılı",
                        "message" => "Anasayfaya yönlendiriliyorsunuz.",
                        "access_token" => $access_token,
                        "user"=>$user,
                        "logout"=>0
                    );
                    return $this->system_tools->json_response($response,$statusCode);
                }
                /***
                 * Hem kullanıcıya ait bir kayıt yoksa ama sistemde cihaz varsa başka kullanıcıya ait bir kayıt var demektir. Giriş yapan kullanıcıya yeni bir kayıt açıyoruz.
                 */
                else{
                    $statusCode = 401;
                    $response = array(
                        "title" => "Giriş başarısız",
                        "message" => "Giriş başarısız, Farklı Telefondan Giriş sağlanamaz"
                    );

                    return $this->system_tools->json_response($response,$statusCode);
                }

            }


        } catch (Exception $e) {
            $statusCode = 404;
            $response = [
                "message"=>$e->getMessage()
            ];
            return $this->system_tools->json_response($response,$statusCode);
        }
        return $this->system_tools->json_response($response,$statusCode);
    }
    public function logoutAction()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];

            $device = $this->device_model->find_device(["device_id" => $device_id, "access_token" => $access_token]);
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            $datas = [
                "device_id" =>$device_id,
//                "access_token" =>$access_token,
                "access_token" =>"null",
                "updated_at" =>$created_at,
                "logout"=>1,
                "user"=> 0
            ];
            $this->setDeviceInfo($device,$datas);
            $response = [
                "title"=>"Successful",
                "message"=>"Successful",
//                "access_token"=>$access_token
            ];
            return $this->system_tools->json_response($response,$statusCode);
        } catch (Exception $e) {
            $statusCode = 403;
            $response = [
                "message"=>$e->getMessage()
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }
    public function setSettings()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $dark_mode = $content['dark_mode'];
            $notification = $content['notification'];

            $device = $this->device_model->find_device(["device_id" => $device_id, "access_token" => $access_token]);
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            if($device){
                $datas["device_id"] = $device_id;
                if($dark_mode == 1 || $dark_mode == 0){
                    $datas["dark_mode"] = $dark_mode;
                }
                if($notification == 1 || $notification == 0){
                    $datas["notification"] = $notification;
                }
                $this->device_model->device_update_from_for_noti_and_dark($datas);
                $device2 = $this->device_model->find_device(["device_id" => $device_id, "access_token" => $access_token]);
                $response = [
                    "title"=>"Successful",
                    "message"=>"Successful",
                    "data"=>$device2,
                    "content"=>$content,
                ];
            }else{
                $statusCode = 401;
                $response = [
                    "title"=>"Error",
                    "message"=>"Error",
//                "access_token"=>$access_token
                ];
            }
            return $this->system_tools->json_response($response,$statusCode);
        } catch (Exception $e) {
            $statusCode = 403;
            $response = [
                "message"=>$e->getMessage()
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }
    public function forgetAction()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];

            $username = @$content['username'];
            $email = @$content['email'];
            $phone_number = @$content['phone_number'];

            if (!$email and !$username) {
                $statusCode = 401;
                $response = [
                    "message" => "Lütfen bir e-posta veya Kullanıcı adı girin!",
                    "title" => "Eksik bilgi!",
                    "content" => $content,
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }else if($email){
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $statusCode = 401;
                    $response = [
                        "message" => "Email adresinizi doğru formatta giriniz.",
                        "title" => "Düzeltiniz",
                    ];
                    return $this->system_tools->json_response($response,$statusCode);
                }
            }
//            else if($phone_number){
//                if (strlen($phone_number) != 13) {
//                    $statusCode = 401;
//                    $response = [
//                        "message" => "Telefonunuzu doğru formatta giriniz.",
//                        "title" => "Düzeltiniz ",
//                    ];
//                    return $this->system_tools->json_response($response,$statusCode);
//                }
//            }
            $device = $this->device_model->find_device(["device_id" => $device_id]);
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');

            if($device){
                $usernameOrEmail = [
                    "email"=>$email
                ];
                $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
                if(!$user){
                    $usernameOrEmail = ["username"=>$username];
                    $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
//                    if(!$user){
//                        $usernameOrEmail = [
//                            "phone_number"=>str_replace("+9","9",$phone_number)
//                        ];
//                        $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
//                    }
                }

                if($user){
                    $randomCode = $this->system_tools->randomNumber(6);
                    if ($phone_number){
//                        $this->newmodel->edit_user(["phone_verification"=>$randomCode,"id"=>$user[0]["id"]]);


//                        $number=$phone_number;
//                        $message="Hesabınızı kurtarmanız icin : $randomCode";
//
//                        $sended_sms = $this->SmsSendApi($number,$message);
//
//                        $response = [
//                            "message"=>"Telefonunuza gönderilen şifreyi giriniz",
//                            "sended_sms"=>$sended_sms,
//                            "type"=>"phone_number",
//                            "phone_number"=>$phone_number
//                        ];
                    }
                    else if ($username){
                        $usernameOrEmail = [
                            "username"=>$username
                        ];
                        $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
                        $this->newmodel->edit_user(["resetPasswordToken"=>$randomCode,"id"=>$user[0]["id"] ]);

                        $konu = "Password Recovery Code";
                        $message = "Enter this code in the password reset field created on your phone.".$randomCode;
                        $cevap = $this->general->mail_design_and_send([$user[0]["email"]],$konu,$message);

                        $response = [
                            "message"=>"Enter the Code sent to your email address.",
                            "cevap"=>$cevap,
                            "type"=>"email",
                            "email"=>$email,
                        ];
                    }
                    else if($email){
                        $this->newmodel->edit_user(["resetPasswordToken"=>$randomCode,"id"=>$user[0]["id"] ]);

                        $konu = "Password Recovery Code";
                        $message = "Enter this code in the password reset field created on your phone.".$randomCode;
                        $cevap = $this->general->mail_design_and_send([$email],$konu,$message);

                        $response = [
                            "message"=>"Enter the Code sent to your email address.",
                            "cevap"=>$cevap,
                            "type"=>"email",
                            "email"=>$email,
                        ];
                    }
                    else{
                        $statusCode = 401;
                        $response = [
                            "message"=>"Fill in the blanks."
                        ];
                    }
                }else{
                    $statusCode = 401;
                    $response = [
                        "message"=>"Böyle bir kullanıcı mevcut değil",
                        "user"=>$user
                    ];
                }
            }else{
                $statusCode = 401;
                $response = [
                    "message"=>"Kayıtlı Telefondan deneyiniz."
                ];
            }
            return $this->system_tools->json_response($response,$statusCode);
        } catch (Exception $e) {
            $statusCode = 403;
            $response = [
                "message"=>$e->getMessage()
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }
    public function forgetAcceptAction()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];

            $username = @$content['username'];
            $email = @$content['email'];
            $phone_number = @$content['phone_number'];
            $code = @$content['code'];
            $type = @$content['type'];
            $password = @$content['password'];
            $password_repeat = @$content['password_repeat'];

            $device = $this->device_model->find_device(["device_id" => $device_id]);
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');

            if($device){
                $usernameOrEmail = [
                    "email"=>$email
                ];
                $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
                if(!$user){
                    $usernameOrEmail = ["username"=>$username];
                    $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
//                    if(!$user){
//                        $usernameOrEmail = [
//                            "phone_number"=>str_replace("+9","9",$phone_number)
//                        ];
//                        $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
//                    }
                }

                if($user){
                    $randomCode = $this->system_tools->randomNumber(6);
                    if($password==$password_repeat){
//                        if ($type=="phone_number"){
//                            if ($user[0]["phone_verification"]==$code){
//                                $new_password = password_hash($password, PASSWORD_DEFAULT);
//
//                                $this->newmodel->edit_user(["password"=>$new_password,"id"=>$user[0]["id"] ]);
//
//                                $number=$phone_number;
//                                $message="Şifreniz Güncellendi , Yeni şifreniz : ".$password;
//
//                                $sended_sms = $this->SmsSendApi($number,$message);
//
//                                $response = [
//                                    "message"=>$message,
//                                    "sended_sms"=>$sended_sms,
//                                ];
//                                $statusCode = 200;
//                                return $this->system_tools->json_response($response,$statusCode);
//                            }else{
//                                $statusCode = 401;
//                                $response = [
//                                    "message"=>"Kodu Yanlış Girdiniz (phone)",
//                                    "phone_verification"=>$user[0]["phone_verification"],
//                                    "code"=>$code,
//                                ];
//                            }
//                        }else{
//                            $statusCode = 401;
//                            $response = [
//                                "message"=>"Fill in the blanks. 1"
//                            ];
//                        }
                        if($type=="email"){
                            if ($user[0]["resetPasswordToken"]==$code){
                                $new_password = password_hash($password, PASSWORD_DEFAULT);
                                $this->newmodel->edit_user(["password"=>$new_password,"id"=>$user[0]["id"] ]);

                                $konu = "Your Password Has Been Updated";
                                $message="Your Password Has Been Updated, Your New Password: ".$password;
                                $this->general->mail_design_and_send([$email],$konu,$message);

                                $response = [
                                    "message"=>$message
                                ];
                                $statusCode = 200;
                                return $this->system_tools->json_response($response,$statusCode);
                            }else{
                                $statusCode = 401;
                                $response = [
                                    "message"=>"You entered the code incorrectly (email)",
//                                    "user"=>$user,
                                ];
                            }
                        }else{
                            $statusCode = 401;
                            $response = [
                                "message"=>"Fill in the blanks.2",
                                "content"=>$content
                            ];
                        }
                        if($type=="username"){
                            if ($user[0]["resetPasswordToken"]==$code){
                                $new_password = password_hash($password, PASSWORD_DEFAULT);
                                $this->newmodel->edit_user(["password"=>$new_password,"id"=>$user[0]["id"] ]);

                                $konu = "Your Password Has Been Updated";
                                $message="Your Password Has Been Updated, Your New Password: ".$password;
                                $this->general->mail_design_and_send([$user[0]["email"]],$konu,$message);

                                $response = [
                                    "message"=>$message
                                ];
                                $statusCode = 200;
                                return $this->system_tools->json_response($response,$statusCode);
                            }else{
                                $statusCode = 401;
                                $response = [
                                    "message"=>"You entered the code incorrectly (username)",
//                                    "user"=>$user,
                                ];
                            }
                        }else{
                            $statusCode = 401;
                            $response = [
                                "message"=>"Fill in the blanks.2",
                                "content"=>$content
                            ];
                        }
                    }else{
                        $statusCode = 401;
                        $response = [
                            "message"=>"Passwords Do Not Match"
                        ];
                    }

                }else{
                    $statusCode = 401;
                    $response = [
                        "message"=>"No such user exists",
                        "user"=>$user,
                        "usernameOrEmail"=>$usernameOrEmail
                    ];
                }
            }else{
                $statusCode = 401;
                $response = [
                    "message"=>"Try it from the registered phone."
                ];
            }
            return $this->system_tools->json_response($response,$statusCode);
        } catch (Exception $e) {
            $statusCode = 403;
            $response = [
                "message"=>$e->getMessage()
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }

    public function checkUserAction()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];

            $device = $this->device_model->find_device(["device_id" => $device_id]);
            if($device){
                $d = new DateTime();
                $created_at = $d->format('Y-m-d H:i:s');
                $new_user = $this->newmodel->get_single_user(@$device[0]["user"]);
//                $new_user_cards = $this->newmodel->get_single_user_cards(@$device[0]["user"]);
                $new_cards = [];
//                foreach ($new_user_cards as $index => $item) {
//                    $card_info_base = base64_decode($item["card_info"]);
//                    $card_info = explode(";",$card_info_base);
//                    $new_cards[] = [
//                        "card_id" => @$item["id"],
//                        "card_name" => @$item["card_name"],
//                        "card_number" => @$card_info[1],
//                        "card_month" => @$card_info[2],
//                        "card_year" => @$card_info[3],
//                        "card_cvc" => @$card_info[4],
//                        "card_info_base" => $item["card_info"],
//                    ];
//                }
                $get_all_regions = $this->admitad_model->get_all_regions();
                $get_all_regions_new = [];
                foreach ($get_all_regions as $index => $get_all_region) {
                    $get_all_regions_new[] = $get_all_region["name"];
                }
                if($new_user){
                    $response = [
                        "title"=>"Successful",
                        "message"=>"Successful",
                        "user"=>$new_user[0],
                        "access_token"=>@$device[0]["access_token"],
                        "user_id"=>@$new_user[0]["user"],
                        "login"=>true,
                        "device"=>$device[0],
                        "regions"=>$get_all_regions_new,
                    ];
                }else{
                    $response = [
                        "title"=>"Empty",
                        "message"=>"Empty",
                        "user"=>$new_user,
                        "login"=>false,
                        "device"=>$device[0],
                        "regions"=>[],
                    ];
                }
            }else{
                $statusCode = 401;
                $response = [
                    "title"=>"Empty",
                    "message"=>"Empty",
                    "login"=>false
                ];
            }
            return $this->system_tools->json_response($response,$statusCode);
        } catch (Exception $e) {
            $statusCode = 401;
            $response = [
                "message"=>$e->getMessage()
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }
    public function saveUserInfoAction()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $name = $content['name'];
            $surname = $content['surname'];
            $email = $content['email'];
            $tc = $content['tc'];
            $born_date = $content['born_date'];
            $ref_code = $content['ref_code'];
            $save_type = $content['save_type'];
            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);
            $new_user = $this->newmodel->get_single_user(@$device[0]["user"]);
            if ( !$name) {
                $statusCode = 401;
                $response = [
                    "title" => "Eksik bilgi!",
                    "message" => "İsim giriniz"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }
            if ( !$surname) {
                $statusCode = 401;
                $response = [
                    "title" => "Eksik bilgi!",
                    "message" => "Soysim giriniz"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }
            if ( !$email) {
                $statusCode = 401;
                $response = [
                    "title" => "Eksik bilgi!",
                    "message" => "E-posta giriniz"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }

            if ( !$tc) {
                $statusCode = 401;
                $response = [
                    "title" => "Eksik bilgi!",
                    "message" => "TC giriniz"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }
            if ( !$born_date) {
                $statusCode = 401;
                $response = [
                    "title" => "Eksik bilgi!",
                    "message" => "Doğum tarihi giriniz"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }
            if($email){
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $statusCode = 401;
                    $response = [
                        "message" => "Email adresinizi doğru formatta giriniz.",
                        "title" => "Düzeltiniz",
                    ];
                    return $this->system_tools->json_response($response,$statusCode);
                }
                if($save_type =="new"){
                    $new_user = $this->newmodel->get_single_user_from_email($email);
                    if($new_user){
                        $statusCode = 401;
                        $response = [
                            "title" => "Mevcut!",
                            "message" => "Farklı bir email giriniz"
                        ];
                        return $this->system_tools->json_response($response,$statusCode);
                    }
                }else if($save_type =="update"){
                    if($new_user and $email == $new_user[0]["email"]){

                    }else{
                        $statusCode = 401;
                        $response = [
                            "title" => "Mevcut!",
                            "message" => "Farklı bir email giriniz"
                        ];
                        return $this->system_tools->json_response($response,$statusCode);
                    }
                }
            }
            if ( $tc) {
                if($save_type =="new") {
                    $new_user2 = $this->newmodel->get_single_user_from_tc($tc);
                    if ($new_user2) {
                        $statusCode = 401;
                        $response = [
                            "title" => "Mevcut!",
                            "message" => "Farklı bir TC giriniz"
                        ];
                        return $this->system_tools->json_response($response, $statusCode);
                    }
                }else if($save_type =="update"){
                    if($new_user and $tc == $new_user[0]["tc"]){

                    }else{
                        $statusCode = 401;
                        $response = [
                            "title" => "Mevcut!",
                            "message" => "Farklı bir TC giriniz"
                        ];
                        return $this->system_tools->json_response($response,$statusCode);
                    }
                }
            }
            $datetime = new DateTime();
            $born_d = explode("/",$born_date);
            $Year = $born_d[2];
            $Day = $born_d[1];
            $Month = $born_d[0];
            $datetime->setDate($Year, $Month, $Day);
            if($tc){
                $client = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");
                try {
                    $result = $client->TCKimlikNoDogrula([
                        'TCKimlikNo' => $tc,
                        'Ad' => $this->newform->tr_strtoupper($name),
                        'Soyad' => $this->newform->tr_strtoupper($surname),
                        'DogumYili' => $Year
                    ]);
                    if ($result->TCKimlikNoDogrulaResult) {
//                        echo 'T.C. Kimlik No Doğru';
                    } else {
                        $response = [
                            "title" => "Eksik bilgi!",
                            "message" => "T.C. Kimlik No Hatalı veya Ad soyad doğum günü ile eşleşmiyor"
                        ];
                        return $this->system_tools->json_response($response,$statusCode);
                    }
                } catch (Exception $e) {
                    echo $e->faultstring;
                }
            }

            if($device and $access_token){
                $d = new DateTime();

                $created_at = $d->format('Y-m-d H:i:s');

                if($new_user){
                    $edit_user_data = [
                        'name'=>$name,
                        'surname'=>$surname,
                        'full_name'=>$name." ".$surname,
                        'email'=>$email,
                        'tc'=>$tc,
                        'born_date'=>$datetime->format("Y/m/d"),
                        'ref_code'=>$ref_code,
                        'id'=>@$device[0]["user"],
                    ];
                    $edit_user = $this->newmodel->edit_user($edit_user_data);
                    $response = [
                        "title"=>"Successful",
                        "message"=>"Successful",
                        "user"=>$new_user[0],
                        "login"=>true,
                        "donen"=>$born_date
                    ];
                }else{
                    $response = [
                        "title"=>"Empty",
                        "message"=>"Empty",
                    ];
                }
            }else{
                $response = [
                    "title"=>"Empty",
                    "message"=>"Empty",
                ];
            }
            return $this->system_tools->json_response($response,$statusCode);
        } catch (Exception $e) {
            $statusCode = 403;
            $response = [
                "message"=>$e->getMessage()
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }
    public function smsAction()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = @$content['access_token'];

            $phone_number = @$content['phone_number'];

            if (!$phone_number) {
                $statusCode = 401;
                $response = [
                    "message" => "Lütfen bir telefon numarası girin!",
                    "title" => "Eksik bilgi!",
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }else if($phone_number){
                if (strlen($phone_number) != 13) {
                    $statusCode = 401;
                    $response = [
                        "message" => "Telefonunuzu doğru formatta giriniz.",
                        "title" => "Düzeltiniz ",
                    ];
                    return $this->system_tools->json_response($response,$statusCode);
                }
            }
            $device = $this->device_model->find_device(["device_id" => $device_id]);
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');

            if($device){
                $usernameOrEmail = [
                    "phone_number"=>str_replace("+","",$phone_number)
                ];
                $user = $this->newmodel->get_single_user_from_username_or_email($usernameOrEmail);
//                $randomCode = $this->system_tools->randomNumber(4);
                $randomCode = "1111";
                $message="Coupons uygulamasına giriş yapmak için kulanacağınız kod : $randomCode";
                if(!$user){

                    if ($phone_number){
//                        $this->newmodel->edit_user(["phone_verification"=>$randomCode,"id"=>$user[0]["id"]]);

                        $number=$phone_number;
                        $sended_sms = $this->SmsSendApi($number,$message);

                        $response = [
                            "title"=>"Telefonunuza gönderilen şifreyi giriniz",
                            "message"=>"Telefonunuza gönderilen şifreyi giriniz",
//                            "sended_sms"=>$sended_sms,
                            "type"=>"phone_number",
                            "true_code"=>$randomCode,
                            "next_page"=>"registerPage",
                        ];
                    }else{
                        $statusCode = 401;
                        $response = [
                            "message"=>"Fill in the blanks."
                        ];
                    }
                }else{
                    $statusCode = 200;
                    $number=$phone_number;
                    $sended_sms = $this->SmsSendApi($number,$message);
                    $response = [
                        "title"=>"Telefonunuza gönderilen şifreyi giriniz",
                        "message"=>"Telefonunuza gönderilen şifreyi giriniz",
//                            "sended_sms"=>$sended_sms,
                        "type"=>"phone_number",
                        "true_code"=>$randomCode,
                        "next_page"=>"homePage",
                    ];
                }
            }else{
                $statusCode = 401;
                $response = [
                    "message"=>"Kayıtlı Telefondan deneyiniz."
                ];
            }
            return $this->system_tools->json_response($response,$statusCode);
        } catch (Exception $e) {
            $statusCode = 403;
            $response = [
                "message"=>$e->getMessage()
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }
    public function SmsSendApi($number,$message){
        try {
            $number = substr($number, 1);
//            $number = "05398147260";
            $message = str_replace(" ","%20",$message);
            $url = "https://api.netgsm.com.tr/sms/send/get/?usercode=8503034144&password=463513ATLAGIT&gsmno=".$number."&message=".$message."&msgheader=8503034144";
            $ch = curl_init();

            $cURLConnection = curl_init();

            curl_setopt($cURLConnection, CURLOPT_URL, $url);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

            $phoneList = curl_exec($cURLConnection);
            curl_close($cURLConnection);

            $jsonArrayResponse = $phoneList;
            return $jsonArrayResponse;
        }catch (Exception $e){
            return $e->getMessage();
        }

    }
    public function save_user_infos()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $language= $content['language'];

            $device = $this->device_model->find_device(["device_id" => $device_id, "access_token" => $access_token]);
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            if($device){
                $userId = $device[0]["user"];
                $user = $this->newmodel->get_single_user(@$userId);

                $new_data = [
                    "id"=>$userId,
                ];
                if($language!=null){
                    $new_data["language"]=$language;
                }

                $user = $this->newmodel->edit_user($new_data);

                $response = [
                    "title"=>"Successful",
                ];
                $response["message"] = "Successful";
            }else{

                $response = [
                    "title"=>"Empty",
                    "message"=>"Empty",
                ];
            }
            return $this->system_tools->json_response($response,$statusCode);
        } catch (Exception $e) {
            $statusCode = 403;
            $response = [
                "message"=>$e->getMessage()
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }
}
