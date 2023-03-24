<?php
class Store extends Controller{
    public function __construct() {
        parent::__construct();
        Session::checkSession();
        $this->islemController = $this->load->controllers("islemler");
        $this->indexController = $this->load->controllers("index");
        $this->newmodel = $this->load->model("uyelik_model");
        $this->index_model = $this->load->model("index_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->system_tools = $this->load->otherClasses("SystemTools");
    }
    public function sqlSorgu($sql,$array){
        $model = $this->load->model("index_model");
        return $model->sqlSorgu($sql,$array);
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
                if($_POST["new_data"]["completed"]){
                    $jsonData["completed"] = $_POST["new_data"]["completed"];
                }
                if($_POST["new_data"]["product"]){
                    $jsonData["product"] = $_POST["new_data"]["product"];
                }
                if($_POST["new_data"]["card_data"]){
                    $jsonData["card_data"] = $_POST["new_data"]["card_data"];
                }
                $result = $this->send_to_api($_POST["url"],$jsonData);
                if($result["status_code"]==200){
                    $response = $result;
//                    $response["link"] = SITE_URL."memberships/home";
                    $response["status"] = true;
                    $response["alert"] = false;
                    $response["title"] = @$result["title"];
                    $response["message"] = @$result["message"];
                    $response["post"] = $_POST;
                    if($_POST["theme_tpl"]){
                        ob_start();
                        $data["response"] = $response;
//                        $this->view->render($_POST["theme_tpl"],$data,"1");
                        $this->paytr($data);
                        $renderView = ob_get_clean();

                        $response["renderView"] = $renderView;
                    }
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
//            $data["browser_info"] = $this->newform->getBrowser();
//            $data["login"] = true;
//            $this->view->render("memberships/login", $data);
        }

    }
    public function modal_getir(){
        if($_POST){
            ob_start();
            $data["id"] = $_POST["id"];

            $urundetay = $this->sqlSorgu("SELECT * from products WHERE id = :id ",[":id"=>$_POST["id"]]);

            $data["array"] = $urundetay[0];
            $data["title"] = $urundetay[0]["name"];

            $this->view->render("api/store/modal",$data,"1");
            $renderView = ob_get_clean();

            $response["renderView"] = $renderView;
            echo json_encode($response);
        }else{
            echo "Bu sayfaya giriş yetkiniz yoktur.";
        }
    }

    public function payment($id){
        $data["title"] = "Ödeme Sayfası ";
        $this->view->render("api/store/payment", $data);
    }
    public function paytr($response){
        $id = $response["response"]["post"]["new_data"]["product"];
        $product = $this->index_model->get_products($id);

        $user_basket = htmlentities(json_encode(array(
            array($product[0]["name"], $product[0]["price"], 1),
        )));

        $data["user_basket"] = $user_basket;
        $data["title"] = "Ödeme Sayfası ";
        $data["data"] = $response["response"]["data"];
        $data["token"] = $response["response"]["token"];
        $data["id"] = $id;
        $data["card_data"] = $response["response"]["post"]["new_data"]["card_data"];
        return $this->view->render("api/store/paytr", $data);
    }
}
