<?php
class Device extends Controller{
    public function __construct() {
        parent::__construct();
        $this->newmodel = $this->load->model("device_model");
        $this->users_model = $this->load->model("users_model");
        $this->actions = $this->load->controllers("actions");
        $this->system_tools = $this->load->otherClasses("SystemTools");
        $this->system_tools = $this->load->otherClasses("SystemTools");
    }
    public function index(){
        echo "Welcome to Device";
    }
    public function registerOrUpdateAction()
    {
        $statusCode = 200;
//        $content = $_POST;
        $content = json_decode(file_get_contents('php://input'), TRUE);

        /**
         * Gelen parametreler
         */

        $device_id = @$content["device_id"];
        $brand = @$content["brand"];
        $model = @$content["model"];
        $os_type = @$content["os_type"];
        $os_version = @$content["os_version"];
        $app_version = @$content["app_version"];
        $local_language = @$content["local_language"];
        $push_token = @$content["push_token"];

        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');

        $datas = [
            "device_id" =>@$device_id,
            "brand" =>@$brand,
            "model" =>@$model,
            "os_type" =>@$os_type ? $os_type : "web",
            "os_version" =>@$os_version,
            "app_version" =>@$app_version,
            "local_language" =>@$local_language,
            "push_token" =>@$push_token,
            "created_at" =>@$created_at,
            "updated_at" =>@$created_at,
            "user"=>0,
            "logout"=>1,
            "notification"=>1,
            "dark_mode"=>0,
        ];

        $access_token = $this->system_tools->v4();

//        $username = @$content["username"];
//        $password = @$content["password"];


        $device = $this->newmodel->find_device(["device_id"=>$device_id]);

        /**
         * Device yoksa yeni device açma
         */
        //TODO device varsa ne yapıalcak
        if (!$brand) {
            $response = [
                "message"=>"There is not any information",
                "datas" => $datas,
            ];
            $statusCode = "200";
            return $this->system_tools->json_response($response,$statusCode);
        }else if (!$device) {
//            $datas["access_token"] = $access_token;
            $this->newmodel->insert_device($datas);

            $response = [
                "message"=>"Device Added Successfuly",
//                "access_token" => $access_token,
            ];
        }else{
            $user = $this->users_model->get_single_user($device[0]["user"]);
            $new_language = "ar";
            if($user[0]["language"]!=null){
                $new_language = $user[0]["language"];
            }else{
//                $new_language = explode("_",$local_language)[0];
            }
            $update_data = [
                "push_token" =>$push_token,
                "device_id" =>$device_id,

                "brand" =>$brand,
                "model" =>$model,
                "os_type" =>$os_type,
                "os_version" =>$os_version,
                "app_version" =>$app_version,
                "local_language" =>$local_language,

                "updated_at" =>$created_at,
//                "access_token" =>"null"
            ];

            $this->newmodel->device_update($update_data);
            $response = [
                "message"=>"Device Update Successfuly",
                "access_token" => $device[0]["access_token"] ? $device[0]["access_token"]:"",
                "language" => $new_language,
                "logout"=>$device[0]["logout"],
                "dark_mode"=>$device[0]["dark_mode"],
                "notification"=>$device[0]["notification"],
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }
    public function get_general_settings()
    {
        $statusCode = 200;
//        $content = $_POST;
        $content = json_decode(file_get_contents('php://input'), TRUE);

        /**
         * Gelen parametreler
         */

        $device_id = @$content["device_id"];

        $device = $this->newmodel->find_device(["device_id"=>$device_id]);

        /**
         * Device yoksa yeni device açma
         */
        //TODO device varsa ne yapıalcak
        if ($device) {
            $general_settings = $this->newmodel->get_single_general_settings();
            $response = [
                "message"=>"Device Added Successfuly",
                "data"=> $general_settings[0] 
            ];
        }else{
            $response = [
                "message"=>"Empty",
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }

}
