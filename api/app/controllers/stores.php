<?php
class stores extends Controller{
    public function __construct() {
        parent::__construct();
        $this->device_model = $this->load->model("device_model");
        $this->newmodel = $this->load->model("stores_model");
        $this->coupons_model = $this->load->model("coupons_model");
        $this->categories_model = $this->load->model("categories_model");
//        $this->coupons = $this->load->controllers("coupons");
        $this->system_tools = $this->load->otherClasses("SystemTools");
    }
    public function index(){
        echo "Welcome to stores";
    }
    public function get_all_stores()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $favorite = $content['favorite'];
            $store_id = $content['store_id'];
            $text = $content['text'];


            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);
            $coupons = [];
            $categories = [];
            $get_all_stores = [];
            $get_all_coupons = [];
            if ($device){
                $user_id = $device[0]["user"];
                $get_all_stores = $this->newmodel->get_all_stores($store_id,$text);
                $get_all_stores = $get_all_stores;
                $get_all_stores[0]["description"] = "";
                if($store_id){
                    $get_single = $this->newmodel->get_single_users_store_from_store_id($store_id,$device[0]["user"]);
                    if($get_single){
                        $get_all_stores[0]["favorite"] = $get_single[0]["favorite"];
                    }
                    $categories_string = explode(",",$get_all_stores[0]["categories"]);
                    if($categories_string){
                        foreach ($categories_string as $category) {
                            if($category){
                                $category_detail = $this->categories_model->get_single_from_category_id($category);
                                if($category_detail){
                                    $categories[] = $category_detail[0];
                                }
                            }
                        }
                    }

//                error_reporting(true);
//                error_reporting(E_ALL);
//                ini_set('display_errors', 1);
                    $get_all_coupons = $this->newmodel->get_all_coupons_from_store_id($store_id,$text);
                    $users_favorite_coupons = $this->get_users_coupons_with_script("1",$device[0]["user"]);
                    $coupons = $this->get_coupons_with_script($get_all_coupons,$users_favorite_coupons);
                }

                $response = [
                    "data"=> $get_all_stores,
                    "categories"=> $categories,
                    "coupons"=> $coupons,
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
    public function get_all_stores_from_category_id()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $category_id = $content['id'];
            $sortingType = $content['sortingType'] !=null ? $content['sortingType'] : "";
            $couponType = $content['couponType']!=null ? $content['couponType'] : "";
            $popularity = $content['popularity']!=null ? $content['popularity'] : "";
            $discount = $content['discount']!=null ? $content['discount'] : "";
            $cachback = $content['cachback']!=null ? $content['cachback'] : "";

            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);
            $coupons = [];
            $stores = [];
            $get_all_stores = [];
            $get_all_coupons = [];
            if ($device){
                $user_id = $device[0]["user"];
                if($category_id){
                    $new_stores = $this->newmodel->get_all_stores_from_category_id($category_id);
                    foreach ($new_stores as $index => $item) {
                        $stores[] = [
                            "store_id"=>$item["store_id"],
                            "name"=>$item["name"],
                            "logo"=>$item["logo"],
                            "couponsCount"=>$item["couponsCount"],
                        ];
                    }

                    $get_all_coupons = $this->newmodel->get_all_coupons_for_category_page($category_id,$sortingType,$couponType,$popularity,$discount,$cachback);
                    $users_favorite_coupons = $this->get_users_coupons_with_script("1",$device[0]["user"]);
                    $coupons = $this->get_coupons_with_script($get_all_coupons,$users_favorite_coupons);
                }

                $response = [
                    "data"=> $stores,
                    "coupons"=> $coupons,
                    "message"=>"Successful",
                    "user_id"=>$user_id,
                ];
            }else{
                $statusCode = 401;
                $response = [
                    "message"=>"Empty",
                    "content"=>$content
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
        $get_all_users_coupons = $this->coupons_model->get_all_users_coupons($favorite,$user);
        foreach ($get_all_users_coupons as $index2 => $get_all_users_coupon) {
            $users_favorite_coupons[] = $get_all_users_coupon["coupon_id"];
        }
        return $users_favorite_coupons;
    }
    public function get_coupons_with_script($get_all_coupons=[],$users_favorite_coupons=[],$new_favorite=null){
        $get_all_coupons_new = [];
        foreach ($get_all_coupons as $index => $item) {
            $company = $this->newmodel->get_single_from_store_id($item["store_id"]);
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
                $in_array = $new_favorite ? $new_favorite : "0";
            }

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
            ];
        }
        return $get_all_coupons_new;
    }
    public function get_all_users_stores()
    {
        $statusCode = 200;
        $content = json_decode(file_get_contents('php://input'), TRUE);
        try {
            $device_id = $content['device_id'];
            $access_token = $content['access_token'];
            $favorite = $content['favorite'];


            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);

            if ($device){
                $user_id = $device[0]["user"];
                $get_all_stores = $this->newmodel->get_all_users_stores($favorite,$user_id);
                $response = [
                    "data"=> $get_all_stores,
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
            $id = $content['store_id'];

            $device = $this->device_model->find_device(["device_id" => $device_id,"access_token"=>$access_token]);

            if ($device){
                $get_single = $this->newmodel->get_single_users_store_from_store_id($id,$device[0]["user"]);
                if($get_single){
                    $get_single_favorite = $get_single[0]["favorite"];
                    if ($get_single_favorite == "1"){
                        $new_favorite = "0";
                    }else{
                        $new_favorite = "1";
                    }
                    $data = [
                        "store_id"=>$id,
                        "user_id"=>$device[0]["user"],
                    ];
                    $data["favorite"] = $new_favorite;
                    $update = $this->newmodel->update($data);

                    $response = [
                        "message"=>"Successful",
                        "update"=>$update,
                        "content"=>$data,
                        "get_single_favorite"=>$get_single_favorite,
                    ];
                }else{
                    $add_single = $this->newmodel->addToFavorite([
                        "user_id" => $device[0]["user"],
                        "store_id" => $id,
                        "favorite" => "1"
                    ]);
                    $data["favorite"] = "1";
                    $response = [
                        "message"=>"Successful",
                        "content"=>$data,
                    ];
                }
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
