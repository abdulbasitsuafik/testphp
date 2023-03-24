<?php
class Forms extends Controller{
    public function __construct() {
        parent::__construct();
        $this->newmodel = $this->load->model("forms_model");
        $this->device_model = $this->load->model("device_model");
        $this->user_model = $this->load->model("users_model");
        $this->actions = $this->load->controllers("actions");
        $this->system_tools = $this->load->otherClasses("SystemTools");
        $this->newform = $this->load->otherClasses("Form");
        $this->general = $this->load->controllers("general");
    }
    public function index(){
        echo "Welcome to Device";
    }
    public function contactFormAction()
    {
        $statusCode = 200;
//        $content = $_POST;
        $content = json_decode(file_get_contents('php://input'), TRUE);

        /**
         * Gelen parametreler
         */

        $device_id = @$content["device_id"];
        $access_token = @$content["access_token"];

        $type = @$content["type"];
        $subject = @$content["subject"];
        $options = @$content["options"];
        $message = @$content["message"];
        $image = @$content["image"];
        $send_to_email = "info@atlagit.tech";

        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');

//        if ( !$type) {
//            $statusCode = 401;
//            $response = [
//                "title" => "Eksik Bilgi!",
//                "message" => "Mesaj tipi seçiniz",
//                "message_status"=>0,
//            ];
//            return $this->system_tools->json_response($response,$statusCode);
//        }
        if ( !$message) {
            $statusCode = 401;
            $response = [
                "title" => "Eksik Bilgi!",
                "message" => "Sorunun detayını giriniz",
                "message_status"=>0,
            ];
            return $this->system_tools->json_response($response,$statusCode);
        }
        if ( !$subject) {
            $statusCode = 401;
            $response = [
                "title" => "Eksik Bilgi!",
                "message" => "Sorunun Konusunu giriniz",
                "message_status"=>0,
            ];
            return $this->system_tools->json_response($response,$statusCode);
        }
//        if($type != "Diğer"){
//            if (strlen($subject) < 13) {
//                $statusCode = 401;
//                $response = [
//                    "title" => "Eksik Bilgi!",
//                    "message" => "Scooter Barcodu Okutunuz",
//                    "message_status"=>0,
//                ];
//                return $this->system_tools->json_response($response,$statusCode);
//            }
//        }

//        $device = $this->device_model->find_device(["device_id"=>$device_id,"access_token"=>$access_token]);
        $device = $this->device_model->find_device(["device_id"=>$device_id]);

        //TODO device varsa ne yapıalcak
        if ($device) {
            $user = $this->newmodel->find_user(["id"=>$device[0]["user"]]);
            if($image){
                $output_dir = "uploads/contacts/";
                if(is_dir(USTDIZIN."uploads")){ }else{
                    mkdir(USTDIZIN."uploads");
                }
                if(is_dir(USTDIZIN.$output_dir)){ }else{
                    mkdir(USTDIZIN.$output_dir);
                }

                $realImage = base64_decode($image);
                $nowdate =  strtotime("now"). substr((string)microtime(), 1, 6);
                $yeni_ad=$output_dir.$nowdate."."."png";
                file_put_contents(USTDIZIN.$yeni_ad, $realImage);
            }

            $datas = [
                "type" =>$type,
                "subject" =>$subject,
                "options" =>$options,
                "message" =>$message,
                "created_at" =>$created_at,
                "updated_at" =>$created_at,
                "device_id" =>$device_id,
                "user" =>$device[0]["user"],
                "user_name" =>$user[0]["full_name"],
                "image" =>@$yeni_ad,
            ];


            $this->newmodel->insert($datas);
            $new_message = [];
            $new_message["type"] = $type;
            $new_message["message"] = $message;
            $new_message["subject"] = $subject;
            $new_message["options"] = $options;
            $new_message["user"] = $device[0]["user"];
            $new_message["user_name"] = $user[0]["full_name"];
            $new_message["user_phone"] = $user[0]["phone_number"];
            $new_message["user_email"] = $user[0]["email"];
            $new_message["image"] = $yeni_ad;

            $konu = $type;
            $this->general->mail_design_and_send([$send_to_email],$konu,$new_message,"contact");

            $gidecek_olan = $user[0]["email"] ? $user[0]["email"] : $send_to_email;

            $konu2 = "Bilgilendirme";
            $message2 = "Göndermiş olduğunuz <b>".$subject."</b> Konulu mesajınız en kısa sürede cevaplanacaktır.";
            $this->general->mail_design_and_send([$gidecek_olan],$konu2,$message2);

            $response = [
                "title"=>"Mesajınız iletilmiştir",
                "message"=>"Mesajınız iletilmiştir",
                "messages"=>$new_message,
//                "device"=>$device,
//                "user"=>$user,
                "message_status"=>1,
            ];
        }else{
            $statusCode = 401;
            $response = [
                "title"=>"Mesajınız Gönderilemedi",
                "message"=>"Mesajınız Gönderilemedi",
                "content"=>$content,
//                "device"=>$device,
                "message_status"=>0,
            ];
        }
        return $this->system_tools->json_response($response,$statusCode);
    }
    public function saveCardData()
    {
        $statusCode = 200;
//        $content = $_POST;
        $content = json_decode(file_get_contents('php://input'), TRUE);

        /**
         * Gelen parametreler
         */

        $device_id = @$content["device_id"];
        $access_token = @$content["access_token"];

        $card_name = @$content["card_name"];
        $card_number = @$content["card_number"];
//        $card_month = @$content["card_month"];
//        $card_year = @$content["card_year"];
//        $card_cvc = @$content["card_cvc"];
        $card_info = @$content["card_info"];
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');

        if ( !$card_name) {
            $statusCode = 401;
            $response = [
                "title" => "Eksik Bilgi!",
                "message" => "Kart Sahibi giriniz"
            ];
            return $this->system_tools->json_response($response,$statusCode);
        }
        if ( !$card_number) {
            $statusCode = 401;
            $response = [
                "title" => "Eksik Bilgi!",
                "message" => "Kart Numarası giriniz"
            ];
            return $this->system_tools->json_response($response,$statusCode);
        }else{
            if (strlen($card_number) != 16) {
                $statusCode = 401;
                $response = [
                    "title" => "Eksik Bilgi!",
                    "message" => "16 hane kart Numarası giriniz"
                ];
                return $this->system_tools->json_response($response,$statusCode);
            }
        }
        if ( !$card_info) {
            $statusCode = 401;
            $response = [
                "title" => "Eksik Bilgi!",
                "message" => "Kart bilgisi giriniz"
            ];
            return $this->system_tools->json_response($response,$statusCode);
        }

        $device = $this->device_model->find_device(["device_id"=>$device_id,"access_token"=>$access_token]);
//        $device = $this->device_model->find_device(["device_id"=>$device_id]);

        //TODO device varsa ne yapıalcak
        if ($device) {
            $user = $this->newmodel->find_user(["id"=>$device[0]["user"]]);
            $card_number = @$content["card_number"];
//            $card_info = base64_encode($card_name.";".$card_number.";".$card_month.";".$card_year.";".$card_cvc);

            $new_card = $this->newform->ccMasking($card_number,"*");
            $user_card = $this->user_model->get_single_user_cards_from_card($device[0]["user"],$new_card);
            if(!$user_card){
                $datas = [
                    "card_number" => $new_card,
                    "card_name" =>$card_name,
                    "card_info" =>$card_info,
                    "user" =>$device[0]["user"],
                    "created_at" =>$created_at,
                    "updated_at" =>$created_at,
                ];

                $inserted = $this->newmodel->insert_card($datas);
                $response = [
                    "title"=>"Kayıt Başarılı",
                    "message"=>"Kayıt Başarılı",
                    "id"=>$inserted,
                ];
            }else{
                $statusCode = 401;
                $response = [
                    "title"=>"Kayıt başarısız",
                    "message"=>"Kart Mevcut",
                ];
            }
        }else{
            $statusCode = 401;
            $response = [
                "title"=>"Kayıt başarısız",
                "message"=>"Böyle bir cihaz yok",
            ];
        }
        return $this->system_tools->json_response($response,$statusCode);
    }
    public function deleteCardData()
    {
        $statusCode = 200;
//        $content = $_POST;
        $content = json_decode(file_get_contents('php://input'), TRUE);

        /**
         * Gelen parametreler
         */

        $device_id = @$content["device_id"];
        $access_token = @$content["access_token"];
        $card_id = @$content["card_id"];
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');

        if ( !$card_id) {
            $statusCode = 401;
            $response = [
                "title" => "Eksik Bilgi!",
                "message" => "Kart Sahibi giriniz"
            ];
            return $this->system_tools->json_response($response,$statusCode);
        }

        $device = $this->device_model->find_device(["device_id"=>$device_id,"access_token"=>$access_token]);
        //TODO device varsa ne yapıalcak
        if ($device) {
            $user = $this->newmodel->find_user(["id"=>$device[0]["user"]]);

            $this->newmodel->delete_card($card_id);
            $response = [
                "title"=>"Silme işlemi Başarılı",
                "message"=>"Silme işlemi Başarılı",
            ];
        }else{
            $statusCode = 401;
            $response = [
                "title"=>"Kayıt başarısız",
                "message"=>"Böyle bir cihaz yok",
            ];
        }
        return $this->system_tools->json_response($response,$statusCode);
    }
}
