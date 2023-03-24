<?php
class Notifications extends Controller{
    public function __construct() {
        parent::__construct();
        $this->device_model = $this->load->model("device_model");
        $this->newmodel = $this->load->model("notification_model");
        $this->stores_model = $this->load->model("stores_model");
        $this->system_tools = $this->load->otherClasses("SystemTools");
    }
    public function index(){
        echo "Welcome to Notifications";
    }
    public function get_all_notification()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $favorite = $content['favorite'];
            $store_id = $content['store_id'];


            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);

            if ($device){
                $user_id = $device[0]["user"];
                $get_all_notifications = $this->newmodel->get_all_notifications($favorite,$user_id);
                $get_all_notifications_new = [];
                foreach ($get_all_notifications as $index => $item) {
                    $get_all_stores = $this->stores_model->get_all_stores($item["store_id"]);
                    if($get_all_stores){
                        $item["company"] = $get_all_stores[0]["name"];
                        $item["companyLogo"] = $get_all_stores[0]["image"];
                    }
                    $d = new DateTime($item["created_at"]);
                    $created_at = $d->format('F d h:i A');
                    $item["created_at"] = $created_at;
                    $get_all_notifications_new[] = $item;
                }
                $response = [
                    "data"=> $get_all_notifications_new,
                    "message"=>"Successful",
                    "user_id"=>$user_id,
                ];
            }else{
                $statusCode = 401;
                $response = [
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
    public function favoriteAction()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $id = $content['id'];

            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);

            if ($device){
                $get_single = $this->newmodel->get_single($id)[0]["favorite"];
                if ($get_single == 1){
                    $new_favorite = 0;
                }else{
                    $new_favorite = 1;
                }
                $data = [
                    "id"=>$id,
                    "favorite"=>$new_favorite,
                ];
                $delete = $this->newmodel->update($data);
                $response = [
                    "message"=>"Successful"
                ];
            }else{
                $statusCode = 401;
                $response = [
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
    public function deleteAction()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $id = $content['id'];


            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);

            if ($device){
                $delete = $this->newmodel->delete($id);
                $response = [
                    "message"=>"Successful"
                ];
            }else{
                $statusCode = 401;
                $response = [
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
