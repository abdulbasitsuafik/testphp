<?php
class Index extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
        Session::checkSession();
        $this->users_model = $this->load->model("users_model");
        $this->devices_model = $this->load->model("device_model");
        $this->settings_model = $this->load->model("settings_model");
    }
    public function index(){
//        if($_SESSION["authority"] == 0){
//            header("Location:". PANEL_URL."questions" );
//        }else{
//            header("Location:". PANEL_URL."exams" );
//        }
        $data["title"] = "Dashboard";
        $data["dashboard"] = true;

        $all_user = $this->users_model->get_list();
        $get_all_list = $this->users_model->get_list_of_active_user();

        $ayarlar = $this->settings_model->get_single();
        $devices_total_android = $this->devices_model->find_device(["os_type"=>"android"]);
        $devices_total_ios = $this->devices_model->find_device(["os_type"=>"ios"]);
        $devices_total_web = $this->devices_model->find_device(["os_type"=>"web"]);
        $devices_android = $this->devices_model->find_device(["app_version"=>$ayarlar[0]["active_android_version"],"os_type"=>"android"]);
        $devices_ios = $this->devices_model->find_device(["app_version"=>$ayarlar[0]["active_ios_version"],"os_type"=>"ios"]);
        $devices_web = $this->devices_model->find_device(["os_type"=>"web"]);


        $data["all_user_count"] = count($all_user);
        $data["active_user_count"] = count($get_all_list);
        $data["active_android_user_count"] = count($devices_android);
        $data["active_ios_user_count"] = count($devices_ios);
        $data["active_web_user_count"] = count($devices_web);
        $data["active_android_user_total_count"] = count($devices_total_android);
        $data["active_ios_user_total_count"] = count($devices_total_ios);
        $data["active_web_user_total_count"] = count($devices_total_web);
        $data["guncel_android"] = $ayarlar[0]["active_android_version"];
        $data["guncel_ios"] = $ayarlar[0]["active_ios_version"];
        $data["guncel_web"] = "1.0";
        $this->view->render("index/index", $data);
    }
}
