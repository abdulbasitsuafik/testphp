<?php
class Contacts extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
        Session::checkSession();
        $this->newmodel = $this->load->model("contacts_model");
        $this->users_model = $this->load->model("users_model");
        $this->admin_users_model = $this->load->model("admin_users_model");
        $this->devices_model = $this->load->model("device_model");
        $this->settings_model = $this->load->model("settings_model");
        $this->newform = $this->load->otherClasses("Form");

        $this->general = $this->load->controllers("general");
    }
    public function index(){
        $data["title"] = "Contact Forms";
        $data["dashboard"] = false;
        $this->view->render("contacts/index", $data);
    }
    public function form_control($POST,$posttype=""){
        $form = $this->newform;
        $model = $this->newmodel;
        foreach ($POST as $key => $value) {
            $form->post($key);
        }
        if(@$form->values['mecburiAlanlar']==""){
            $data = array(
                "cevap_konu"=> $form->values['konu'],
                "cevap_mesaj"=> $form->values['mesaj'],
            );

            if (@$form->values["status"]) {
                $data["status"] = $form->values["status"];
            } else {
                $data["status"] = 1;
            }
            if ($posttype == "edit") {
                $form_detail = $this->newmodel->get_single(@$form->values["b_id"]);
                $user_email = $this->users_model->get_single($form_detail[0]["user"])[0]["email"];
                $konu = $data["cevap_konu"];
                $message = $data["cevap_mesaj"];
                $this->general->mail_design_and_send([$user_email],$konu,$message);


                $data["id"] = @$form->values["b_id"];
                $model->edit($data);
                $response["status"] = true;
                $response["message"] = "Kayıt Başarılı";
                $response["content"] = $_POST;
                $response["post_type"] = "edit";
                $response["files"] = $_FILES;
                $response["get_table"] = true;
            } else {
                $model->add($data);
                $response["status"] = true;
                $response["message"] = "Başarılı";
                $response["content"] = $_POST;
                $response["files"] = $_FILES;
                $response["get_table"] = true;
                $response["post_type"] = "add";
            }

        }else{
            $response["status"] = false;
            $response["message"] = "Fill in the blanks...";
            $response["content"] = $_POST;
        }
        return @$response;
    }
    public function add() {
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST["modal_getir"]){
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }
            $data = [];
            ob_start();
            $this->view->render("users/modal",$data,"1");
            $renderView = ob_get_clean();

            $newData["renderView"] = $renderView;

            echo json_encode($newData);
        }else{
            if($_POST) {
                $response = $this->form_control($_POST,"add");
                echo json_encode($response);
            }
        }

    }
    public function edit() {
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST["modal_getir"]){
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }

            $data["id"] = $form->values["id"];
            $data["data"] = $model->get_single($data["id"])[0];

            $user = $this->admin_users_model->get_single($data["data"]["updated_by"]);
            if($user){
                $data["data"]["tarafindan"] = $user[0]["name"];
            }else{
                $data["data"]["tarafindan"] = $data["data"]["updated_by"];
            }

            ob_start();
            $this->view->render("contacts/modal",$data,"1");
            $renderView = ob_get_clean();

            $newData["renderView"] = $renderView;

            echo json_encode($newData);
        }else{
            if($_POST) {
                $response = $this->form_control($_POST,"edit");
                echo json_encode($response);
            }
        }

    }
    public function change_status(){
        $form = $this->newform;
        $model = $this->newmodel;
        if ($_POST){
            $id = $_POST["id"];

            $get_single = $model->get_single($id);
            $status = $model->change_status($id,$get_single[0]["status"]);
            $response["status"] = $status;


//            $users_list = $model->users_list();
//            foreach ($users_list as $index => $item) {
//                $data["phone"] = str_replace("+9","9",@$item["phone_number"]);
//                $data["id"] = @$item["id"];
//                $model->edit($data);
//            }

            echo json_encode($response);
        }
    }
    public function delete($id=null)
    {
//        $form = $this->newform;
        $model = $this->newmodel;
        if ($_POST) {
            $id = $_POST["id"];
            $model->delete($id);
            $response["status"] =true;
            $response["message"] ="Silme işlemi başarılı";
            echo json_encode($response);
        }
    }
    public function islemler($value){
        ob_start();
        ?>
        <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle durumdegistir-<?php echo $value["id"];?>">Actions <span class="caret"></span> </button>
            <ul class="dropdown-menu">
                <li><a href="javascript:void(0)" onclick="modalGetir('<?php echo CONTROLLER;?>/edit','<?php echo $value["id"];?>')" class="dropdown-item"><span class="fa fa-comment"> </span> Reply</a></li>
                <li>
                    <a href="javascript:void(0)" onclick="item_delete('<?php echo CONTROLLER;?>/delete','<?php echo $value["id"];?>')" class="dropdown-item"> <span class="fa fa-trash"> </span> Delete</a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="change_status('<?php echo CONTROLLER;?>/change_status','<?php echo $value["id"];?>')" class="dropdown-item">
                        <div class="durumdegistirbuttons-<?php echo $value["id"];?>">
                            <?php if($value["blocked"] == 0){?>
                                <span class=" tooltip-buttonicon-eye ">
                                    <span class="fa fa-eye"></span>
                                    Passive
                                </span>
                            <?php }else{ ?>
                                <span class=" tooltip-buttonicon-eye ">
                                    <span class="fa fa-eye-slash"></span>
                                    Active
                                </span>
                            <?php } ?>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <?php
        $renderView = ob_get_clean();
        return $renderView;
    }
    public function resimcek($resim,$w,$h,$zc=null,$q=null){
        if(file_exists("../".$resim)){
            $resim_yeni =  SITE_URL."".$resim;
            if($w!='')$resim_yeni.="/w".$w;
            if($h!='')$resim_yeni.="/h".$h;
            if($zc!='')$resim_yeni.="/zc".$zc;
            if($q!='')$resim_yeni.="/q".$q;
            return $resim_yeni;
        }else{
            $resim_yeni =  SITE_URL."uploads/logo.png";
            if($w!='')$resim_yeni.="/w".$w;
            if($h!='')$resim_yeni.="/h".$h;
            if($zc!='')$resim_yeni.="/zc".$zc;
            return $resim_yeni;
        }
    }
    public function dataListe() {
        $model = $this->newmodel;
        $requestData= $_REQUEST;

        $columns = array(
            // datatable column index  => database column name
            0 =>'id',
            1 => 'subject',
            2 => 'message',
            3 => 'type',
            4 => 'device_id',
            5 => 'user',
            6 => 'user_name',
            7 => 'created_at',
            8 => 'image',
            9 => ''
        );
        // getting records as per search parameters
        $sql = "";
        if( !empty($requestData['columns'][0]['search']['value']) ){   //name
            $sql.=" AND id = '".$requestData['columns'][0]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
            $sql.=" AND subject LIKE '".$requestData['columns'][1]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){  //salary
            $sql.=" AND message LIKE '%".$requestData['columns'][2]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][3]['search']['value']) ){  //salary
            $sql.=" AND type LIKE '".$requestData['columns'][3]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][4]['search']['value']) ){  //salary
//                $sql.=" AND role = '".strtotime($requestData['columns'][4]['search']['value'])."%' ";
            $sql.=" AND device_id = '".$requestData['columns'][4]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][5]['search']['value']) ){  //salary
            $sql.=" AND user = '".$requestData['columns'][5]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][6]['search']['value']) ){  //salary
            $sql.=" AND user_name = '".$requestData['columns'][6]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][7]['search']['value']) ){  //salary
            $sql.=" AND created_at = '".$requestData['columns'][7]['search']['value']."' ";
        }
        $sql2 = $sql;
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

        $makale_liste = $model->get_data_list($sql);
        $toplammakale = $model->get_data_list($sql2);
        //echo $sql;
        $durum = "";
        $data = array();
        foreach ($makale_liste as $key => $row) {

//            $model_device = $this->device_model->find_device(["user"=>$row["user"]]);
//            if($model_device){
//                $new_device_version = $model_device[0]["os_type"]." - ".$model_device[0]["app_version"];
//            }else{
//                $new_device_version = "";
//            }
            if ($row["status"] == 0){
                $new_subject = $row["subject"].' <span class="badge badge-danger onaysiz-id-'.$row["id"].'">New</span>';
            }else{
                $new_subject = $row["subject"];
            }
            if($row["image"]){
                $new_image = '<a href="'.SITE_URL.$row["image"].'" title="Image from Unsplash" data-gallery=""><img style="height:100px;" src="'.($this->resimcek($row["image"],150,150)).'"></a>';
//                $new_image = '<img style="height:100px;" src="'.SITE_URL.$row["image"].'"/>';
            }else{
                $new_image ="yok";
            }


            // preparing an array
            $nestedData=array();
            $nestedData[] = $row["id"];
            $nestedData[] = $new_image;
            $nestedData[] = $new_subject;
            $nestedData[] = $row["message"];
            $nestedData[] = $row["type"];
            $nestedData[] = $row["device_id"];
            $nestedData[] = $row["user"];
            $nestedData[] = $row["user_name"];
            $nestedData[] = $row["created_at"];
            $nestedData[] = $this->islemler($row);

            $data[] = $nestedData;
        }

        $totaldata = @count($makale_liste);
        $totalfiltered = @count($toplammakale);

        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal"    => intval( $totaldata ),  // total number of records
            "recordsFiltered" => intval( $totalfiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
        );
        echo json_encode($json_data);
        //print_r($json_data);
    }
}
