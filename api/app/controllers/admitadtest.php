<?php
class Admitadtest extends Controller{
    public function __construct() {
        parent::__construct();
        $this->newmodel = $this->load->model("content_model");
        $this->device_model = $this->load->model("device_model");
        $this->admitad_model = $this->load->model("admitad_model");
        $this->actions = $this->load->controllers("actions");
        $this->system_tools = $this->load->otherClasses("SystemTools");

        $this->clientId='aAdSknPyn1Np2FN1YDeLUuMakx2pjJ';
        $this->clientSecret='NBILVqwBwvXzXeNf52cTrGiwN2V8Qi';
        $this->base64_header='YUFkU2tuUHluMU5wMkZOMVlEZUxVdU1ha3gycGpKOk5CSUxWcXdCd3ZYelhlTmY1MmNUckdpd04yVjhRaQ==';
    }
    public function index(){
        echo "Welcome to admintad";
    }
    public function send_to_api($url,$jsonData=[],$method="GET",$token_type="Basic",$header="YUFkU2tuUHluMU5wMkZOMVlEZUxVdU1ha3gycGpKOk5CSUxWcXdCd3ZYelhlTmY1MmNUckdpd04yVjhRaQ=="){
        $ch = curl_init();
        if($token_type=="1"){
            $token_type = "Bearer";
        }
        if($method=="POST"){
//            curl_setopt($ch, CURLOPT_POST, 1);
//            curl_setopt($ch, CURLOPT_HTTPGET, 0);
        }else{
//            curl_setopt($ch, CURLOPT_POST, 0);
//            curl_setopt($ch, CURLOPT_HTTPGET, 1);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        if($jsonData){
//            $jsonDataEncoded = json_encode($jsonData);
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
//        }
        if($method=="GET"){

        }
        if($jsonData) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
            "Authorization: {$token_type} {$header}"
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }
    public function cronjob_url(){
        $this->get_client();
        header("Refresh: 1; url=".SITE_URL."api/admitadtest/get_categories");
//        header("Refresh: 1; url=".SITE_URL."api/admitadtest/get_client");
    }
    public function get_client(){
        echo "client_credentials list";
        // login for coupons
        $scope = "public_data coupons_for_website coupons advcampaigns websites";
        $grant_type = "client_credentials";
        $jsonData = "grant_type={$grant_type}&client_id={$this->clientId}&scope={$scope}";
        $login = $this->send_to_api("https://api.admitad.com/token/",$jsonData);

        $access_token = $login["access_token"];
        $_SESSION["admitad_access_token"] = $access_token;
        echo $access_token;
    }
    public function get_categories(){
        echo "categories list";echo "<br/><br/>";
        // login for coupons
        $url = "https://api.admitad.com/coupons/categories/?language=en&limit=500";
        $result1 = $this->send_to_api($url,null,"GET","1",$_SESSION["admitad_access_token"]);
        foreach ($result1["results"] as $index => $item) {
            $is_there1 = $this->admitad_model->get_single_categories($item["id"]);
            if(!$is_there1){
                $data = [
                    "category_id"=>$item["id"],
                    "name"=>$item["name"],
                ];
                $this->admitad_model->insert($data,"categories");
            }
        }
//        echo "<pre>";
//        print_r($result1);
//        echo "</pre>";
        echo "Finished";
        header("Refresh: 1; url=".SITE_URL."api/admitadtest/get_regions");
    }
    public function get_regions(){
        echo "regions list";echo "<br/><br/>";
        $url = "https://api.admitad.com/websites/regions/?limit=500";
        $result2 = $this->send_to_api($url,null,"GET","1",$_SESSION["admitad_access_token"]);
        foreach ($result2["results"] as $index => $item) {
            $is_there2 = $this->admitad_model->get_single_regions($item);
            if(!$is_there2){
                $data = [
                    "name"=>$item,
                ];
                $this->admitad_model->insert($data,"regions");
            }
        }
//        echo "<pre>";
//        print_r($result2);
//        echo "</pre>";
        echo "Finished";
        header("Refresh: 1; url=".SITE_URL."api/admitadtest/get_stores");
    }
    public function get_stores(){
        echo "Stores list";echo "<br/><br/>";
        $url = "https://api.admitad.com/advcampaigns/?limit=2500";
        $result3 = $this->send_to_api($url,null,"GET","1",$_SESSION["admitad_access_token"]);
        foreach ($result3["results"] as $index => $item) {
            $is_there2 = $this->admitad_model->get_single_stores($item["id"]);
            if(!$is_there2){
                $data = [
                    "store_id"=>$item["id"],
                    "name"=>$item["name"],
                    "description"=>$item["description"],
                    "logo"=>$item["image"],
                    "image"=>$item["image"],
//                    "large_image"=>$item["image"],
                    "site_url"=>$item["site_url"],
                    "status"=>$item["status"] =="active" ? 1 : 0,
                    "currency"=>$item["currency"],
                    "rating"=>$item["rating"],
                    "activation_date"=>$item["activation_date"],
                    "modified_date"=>$item["modified_date"],
                ];
                $regions1 = [];
                $categories1 = [];
                foreach ($item['regions'] as $index1 => $region) {
                    $is_there3 = $this->admitad_model->get_single_regions($region);
                    if (in_array($is_there3[0]["id"], $regions1)) {

                    }else{
                        $regions1[] = $is_there2[0]["id"];
                    }
                }
                foreach ($item['categories'] as $index2 => $category) {
                    if (in_array($category["id"], $categories1)) {

                    }else{
                        $categories1[] = $category["id"];
                    }
                }
                $regions = ",".@implode(",", @$regions1).",";
                $categories = ",".@implode(",", @$categories1).",";
                $data["categories"] = $categories;
                $data["regions"] = $regions;
                $this->admitad_model->insert($data,"stores");
            }else{
                $data = [
                    "store_id"=>$item["id"],
                    "name"=>$item["name"],
                    "description"=>$item["description"],
                    "logo"=>$item["image"],
                    "image"=>$item["image"],
//                    "large_image"=>$item["image"],
                    "site_url"=>$item["site_url"],
                    "status"=>$item["status"] =="active" ? 1 : 0,
                    "currency"=>$item["currency"],
                    "rating"=>$item["rating"],
                    "activation_date"=>$item["activation_date"],
                    "modified_date"=>$item["modified_date"],
                ];
                $regions1 = [];
                $categories1 = [];
                foreach ($item['regions'] as $index1 => $region) {
                    if (in_array($region, $regions1)) {

                    }else{
                        $regions1[] = $region["region"];
                    }
                }
                foreach ($item['categories'] as $index2 => $category) {
                    if (in_array($category["id"], $categories1)) {

                    }else{
                        $categories1[] = $category["id"];
                    }
                }
                $regions = ",".@implode(",", @$regions1).",";
                $categories = ",".@implode(",", @$categories1).",";
                $data["categories"] = $categories;
                $data["regions"] = $regions;
                $this->admitad_model->edit_store($data);

            }
        }
        echo "Finished";
        header("Refresh: 1; url=".SITE_URL."api/admitadtest/get_coupons");
    }

    public function get_coupons(){
        echo "coupons list";echo "<br/><br/>";
        $all_coupons_id = [];
        $deleted_coupons = [];
        $updated_coupons = [];
//        $this->get_client();
//        $url = "https://api.admitad.com/coupons/?limit=2500";
//        $result = $this->send_to_api($url,null,"GET","1",$_SESSION["admitad_access_token"]);
//        for($i=1000;$i < 2000 ;$i++){
//            $url2 = "https://api.admitad.com/coupons/website/{$i}/?limit=1";
//            $result2 = $this->send_to_api($url2,null,"GET","Bearer",$_SESSION["admitad_access_token"]);
//            if($result2["results"]){
//                echo "<br/><br/>";echo $url2;echo "<br/><br/>";
//                echo "<pre>";
//                print_r($result2);
//                echo "</pre>";
//            }
//        }
        $url3 = "https://api.admitad.com/coupons/website/1779150/?limit=2500";
        $result3 = $this->send_to_api($url3,null,"GET","1",$_SESSION["admitad_access_token"]);
        foreach ($result3["results"] as $index => $item) {
            $is_there = $this->admitad_model->get_single_coupons($item["id"]);
            $all_coupons_id[] = $item["id"];
            if($item["species"]=="promocode") {
                $promocode = $item["promocode"];
                $promolink = $item["frameset_link"] ? $item["frameset_link"] : $item["goto_link"];
            }else if($item["species"]=="action") {
                $promocode = $item["promocode"] ? $item["promocode"] : "";
                $promolink = $item["frameset_link"] ? $item["frameset_link"] : $item["goto_link"];
            }else{
                $promocode = $item["promocode"];
                $promolink = $item["frameset_link"] ? $item["frameset_link"] : $item["goto_link"]; //goto_link
            }
            $data = [
                "coupon_id"=>$item["id"],
                "status"=>$item["status"] =="active" ? 1 : 0,
                "name"=>$item["name"],
                "short_name"=>$item["short_name"],
                "description"=>$item["description"],
                "rating"=>$item["rating"],
                "store_id"=>$item["campaign"]["id"],
                "exclusive"=>$item["exclusive"],
                "start_date"=>$item["date_start"],
                "end_date"=>$item["date_end"],
                "discount"=>$item["discount"] ? $item["discount"] : "0",
                "discountInt"=>$item["discount"] ? str_replace(["$","%"," "],["","",""],$item["discount"]) : "0",
                "types"=>$item["types"][0]["name"],
                "species"=>$item["species"],
                "language"=>$item["language"],
                "image"=>$item["image"],
                "source"=>"admitad",
                "promocode"=>$promocode,
                "promolink"=>$promolink,
                "code_type"=>$item["species"],
                "cashback"=>"cashback",
            ];
            $regions1 = [];
            $categories1 = [];
            foreach ($item['regions'] as $index1 => $region) {
                if (in_array($region, $regions1)) {

                }else{
                    $regions1[] = $region;
                }
            }
            foreach ($item['categories'] as $index2 => $category) {
                if (in_array($category["id"], $categories1)) {

                }else{
                    $categories1[] = $category["id"];
                }
            }
            $regions = ",".@implode(",", @$regions1).",";
            $categories = ",".@implode(",", @$categories1).",";
            $data["categories"] = $categories;
            $data["regions"] = $regions;
            if(!$is_there){
                $this->admitad_model->insert($data,"coupons");
            }else{
                $updated_coupons[] = $item["id"];
                $this->admitad_model->edit_coupons($data);
            }
        }
        if($all_coupons_id){
            $get_all_coupons = $this->admitad_model->get_all_coupons();
            foreach ($get_all_coupons as $index2 => $item2) {
                if (!in_array($item2["coupon_id"],$all_coupons_id)){
                    $deleted_coupons[] = $item2["coupon_id"];
                    $delete = $this->admitad_model->delete_coupons($item2["coupon_id"]);
                }
            }
        }
        echo "<pre>";
        print_r($result3);
        echo "</pre>";

//        echo "<pre>";
//        print_r($result);
//        echo "</pre>";
        echo "Finished";
    }
}
