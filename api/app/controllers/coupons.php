<?php
class coupons extends Controller{
    public function __construct() {
        parent::__construct();
        $this->device_model = $this->load->model("device_model");
        $this->newmodel = $this->load->model("coupons_model");
        $this->stores_model = $this->load->model("stores_model");
        $this->system_tools = $this->load->otherClasses("SystemTools");
    }
    public function index(){
        echo "Welcome to coupons";
    }
    public function get_all_coupons()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $favorite = $content['favorite'];
            $order = $content['order'];


            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);

            if ($device){
                $user_id = $device[0]["user"];
                $get_all_coupons = $this->newmodel->get_all_coupons($order);
                $get_all_coupons_new = [];

//                $users_favorite_coupons = [];
                $users_favorite_coupons = $this->get_users_coupons_with_script(1,$device[0]["user"]);
                $get_all_coupons_new = $this->get_coupons_with_script($get_all_coupons,$users_favorite_coupons);

                $response = [
                    "data"=> $get_all_coupons_new,
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
    public function searchCoupons()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $text = $content['text'];
            $sortingType = $content['sortingType'] !=null ? $content['sortingType'] : "";
            $couponType = $content['couponType']!=null ? $content['couponType'] : "";
            $popularity = $content['popularity']!=null ? $content['popularity'] : "";
            $discount = $content['discount']!=null ? $content['discount'] : "";
            $cachback = $content['cachback']!=null ? $content['cachback'] : "";
            $region = $content['region']!=null ? $content['region'] : "";

            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);

            if ($device){
                $user_id = $device[0]["user"];
                $get_all_coupons = $this->newmodel->get_searched_coupons($text,$sortingType,$couponType,$popularity,$discount,$cachback,$region);
                $get_all_stores = $this->newmodel->get_all_stores_from_text($text);
                $get_all_coupons_new = [];

//                $users_favorite_coupons = [];
                $users_favorite_coupons = $this->get_users_coupons_with_script("1",$device[0]["user"]);
                $get_all_coupons_new = $this->get_coupons_with_script($get_all_coupons,$users_favorite_coupons);

                $response = [
                    "data"=> $get_all_coupons_new,
                    "coupons"=> $get_all_coupons_new,
                    "stores"=> $get_all_stores,
                    "message"=>"Successful",
                    "user_id"=>$user_id,
                    "sql"=>$get_all_coupons,
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
    public function get_users_coupons_with_script($favorite,$user=null){
        $users_favorite_coupons = [];
        $get_all_users_coupons = $this->newmodel->get_all_users_coupons($favorite,$user);
        foreach ($get_all_users_coupons as $index2 => $get_all_users_coupon) {
            $users_favorite_coupons[] = $get_all_users_coupon["coupon_id"];
        }
        return $users_favorite_coupons;
    }
    public function get_coupons_with_script($get_all_coupons,$users_favorite_coupons=[],$new_favorite=null){
        $get_all_coupons_new = [];
        foreach ($get_all_coupons as $index => $item) {
            $company = $this->stores_model->get_single_from_store_id($item["store_id"]);
            $tarih1 = new DateTime($item["used_last"]);
            $tarih2 = new DateTime();
            $interval = $tarih1->diff($tarih2);
            $saat_farki_tum1 = $interval->format('%d-%h:%i:%s');
            $gun_farki = $interval->format('%d');
            $saat_farki = $interval->format('%h');
            $dakika_farki = $interval->format('%i');
            $saniye_farki = $interval->format('%s');

            if ($gun_farki > 0) {
                $saat_farki_tum = $gun_farki . " day.";
            } else if ($saat_farki > 0) {
                $saat_farki_tum = $saat_farki . " hour.";
            } else if ($dakika_farki > 0) {
                $saat_farki_tum = $dakika_farki . " min.";
            } else {
                $saat_farki_tum = $gun_farki . " sec.";
            }
            $randomCode = $this->system_tools->randomNumber(8);
            $randomCode2 = $this->system_tools->randomNumber(5);

            if($users_favorite_coupons){
                $in_array = in_array($item["coupon_id"], $users_favorite_coupons) == true ? "1" : "0";
            }else{
                $in_array = $new_favorite =="1" ? "1" : "0";
            }
            $date = new DateTime($item["created_at"]);
            $get_all_coupons_new[] = [
                "id" => $item["id"],
                "coupon_id" => $item["coupon_id"],
                "store_id" => $item["store_id"],
                "discountText" => $item["discount"],
                "discountInt" => str_replace(["$","%"," "],["","",""],$item["discount"]),
                "title" => $item["name"],
                "company" => $company[0]["name"] !=null ? $company[0]["name"] : "",
                "companyLogo" => $item["image"],
                "usesText" => $item["used_total"] > 0 ? $item["used_total"] : "0",
                "lastuseText" => $item["used_last"] != null ? $saat_farki_tum : "0 min",
                "promocode" => $item["promocode"],
                "promolink" => $item["promolink"],
                "code" => $item["promocode"],
                "species" => $item["species"],
                "favorite" => $in_array,
                "created_at" => $item["created_at"],
                "created_at_for_sort" => strval($date->getTimestamp()),
            ];
        }
        return $get_all_coupons_new;
    }
    public function get_all_users_coupons()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $favorite = $content['favorite'];
            $text = $content['text'];
            $sortingType = $content['sortingType'] !=null ? $content['sortingType'] : "";
            $couponType = $content['couponType']!=null ? $content['couponType'] : "";
            $popularity = $content['popularity']!=null ? $content['popularity'] : "";
            $discount = $content['discount']!=null ? $content['discount'] : "";
            $cachback = $content['cachback']!=null ? $content['cachback'] : "";


            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);

            if ($device){
                $user_id = $device[0]["user"];
                if($text || $couponType || $popularity || $discount || $cachback){
                    $get_all_coupons = $this->newmodel->get_all_users_searched_coupons($favorite,$user_id,$text,$sortingType,$couponType,$popularity,$discount,$cachback);
                }else{
                    $get_all_coupons = $this->newmodel->get_all_users_coupons($favorite,$user_id);
                }
                $get_all_coupons_new = $this->get_coupons_with_script($get_all_coupons,null,1);
                $response = [
                    "data"=> $get_all_coupons_new,
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
            $id = $content['coupon_id'];
            $favorite = $content['favorite'];
            $used = $content['used'];

            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);

            if ($device){
                $get_single = $this->newmodel->get_single_from_coupon_id($id,$device[0]["user"]);
                $get_single_coupon = $this->newmodel->get_single_coupon($id);
                if($get_single){
                    $get_single_used = $get_single[0]["used"];
                    if($used=="used" && $get_single_used =="0"){
                        $data = [
                            "coupon_id"=>$id,
                        ];
                        if($used=="used" && $get_single_used =="0"){
                            $data["used"] = "1";
                        }
                        $update = $this->newmodel->update($data);
                        $updateCoupons = $this->newmodel->updateCoupons([
                            "coupon_id"=>$id,
                            "used_last"=>1,
                            "used_total"=>$get_single_coupon[0]["used_total"]+1,
                        ]);
                    }else{
                        if($used!="used"){
                            $useddegil = "burda";
                            $get_single_favorite = $get_single[0]["favorite"];
                            if ($get_single_favorite == "1"){
                                $new_favorite = "0";
                            }else{
                                $new_favorite = "1";
                            }
                            $data = [
                                "coupon_id"=>$id,
                                "user_id"=>$device[0]["user"],
                            ];
                            $data["favorite"] = $new_favorite;
                            $update = $this->newmodel->update($data);
                        }else{
                            $updateCoupons = $this->newmodel->updateCoupons([
                                "coupon_id"=>$id,
                                "used_last"=>1,
                            ]);
                        }
                    }
                }else{
                    if($used=="used") {
                        $updateCoupons = $this->newmodel->updateCoupons([
                            "coupon_id"=>$id,
                            "used_total"=>$get_single_coupon[0]["used_total"]+1,
                            "used_last"=>1,
                        ]);
                    }else{
                        $add_single = $this->newmodel->addToFavorite([
                            "user_id" => $device[0]["user"],
                            "coupon_id" => $id,
                            "used" => 0,
                            "favorite" => 1
                        ]);
                    }
                }
                $users_favorite_coupons = $this->get_users_coupons_with_script($favorite,$device[0]["user"]);
                $response = [
                    "message"=>"Successful",
                    "users_favorite_coupons"=>$users_favorite_coupons,
                    "useddegil"=>$useddegil,
//                    "updateCoupons"=>$updateCoupons,
//                    "get_single_favorite"=>$get_single,
//                    "get_all_user_coupons"=>$this->newmodel->get_all_user_coupons(),
                ];
            }else{
                $statusCode = 401;
                $response = [
                    "message"=>"Error",
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
