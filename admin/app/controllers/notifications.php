<?php
class Notifications extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
        Session::checkSession();
//        $this->system_tools = $this->load->otherClasses("SystemTools");
        $this->push_notification = $this->load->otherClasses("pushNotification");
        $this->device_model = $this->load->model("device_model");
        $this->users_model = $this->load->model("users_model");
        $this->stores_model = $this->load->model("stores_model");
        $this->newmodel = $this->load->model("notifications_model");
        $this->newform = $this->load->otherClasses("Form");
    }
    public function index(){
        $form = $this->newform;
        $model = $this->newmodel;
        $data["title"] = "Bildirimler";
//            $data["dashboard"] = false;
        $this->view->render("notifications/index", $data);
    }
    public function send_notification($data,$reg_ids=[]){
//        $data = [
//            "title"=>"Deneme Bildirim",
//            "desc"=>"Deneme Bildirim açıklama",
//            "banner"=>"https://www.tolgaege.com/tosbaexams/admin/static/temalar/default/assets/logo.gif",
//            "detail_id"=>"",
//        ];
//        $all_androids = $this->device_model->find_device(["os_type"=>"android"]);
//        $reg_ids = [];
//        foreach ($all_androids as $index => $item) {
//            $reg_ids[] = $item["push_token"];
//        }
        $return = $this->push_notification->sendAndoid($data,$reg_ids);
        return $return;
    }
    public function form_control($POST,$posttype=""){
        $form = $this->newform;
        $model = $this->newmodel;
        foreach ($POST as $key => $value) {
            $form->post($key);
        }
        if(@$form->values['mecburiAlanlar']==""){
            $d = new DateTime();
            $created_at = $d->format('Y-m-d H:i:s');
            $data = array(
                "title" => $form->values['title'],
                "body" => $form->values['body'],
                "image" => $form->values['image'],
                "store_id" => $form->values['store_id'],
                "created_at"=>$created_at,
                "updated_at"=>$created_at,
                "readed"=>0
            );

            $insert_id = $this->newmodel->add($data);

            $newdata = [
                "title"=>$form->values['title'],
                "desc"=>$form->values['body'],
                "banner"=>$form->values['image'],
                "detail_id"=>$form->values['store_id'],
            ];

            $all_androids = $this->device_model->find_device();
            $reg_ids = [];
            $userdata = [];
            foreach ($all_androids as $index => $item) {
                if($item["user"]){
                    $get_user = $this->users_model->get_single($item["user"]);
                    $reg_ids[] = $item["push_token"];
                    $userdata = [
                        "user_id"=>$item["user"],
                        "notification_id"=>$insert_id,
                        "favorite"=>0,
                        "readed"=>0
                    ];

                    $this->newmodel->add_to_user($userdata);
                }else{
                    $reg_ids[] = $item["push_token"];
                    $userdata = [
                        "user_id"=>$item["user"],
                        "notification_id"=>$insert_id,
                        "favorite"=>0,
                        "readed"=>0
                    ];
                }
            }

            $response_cevap = $this->send_notification($newdata,$reg_ids);
            $response["status"] = true;
            $response["message"] = "Successful";
            $response["content"] = $_POST;
            $response["files"] = $_FILES;
            $response["response"] = $response_cevap;
//            $response["get_table"] = true;
//            $response["post_type"] = "add";
            $response["newdata"] = $newdata;
            $response["reg_ids"] = $reg_ids;

        }else{
            $response["status"] = false;
            $response["message"] = "Fill in the blanks";
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
//            $cities = $this->users_model->get_cities();
//            $new_cities = [];
//            foreach ($cities as $index => $city) {
//                $new_cities[] = [
//                    "id"=>$city["IL_ID"],
//                    "baslik"=>$city["IL_ADI"]
//                ];
//            }
//            $data["cities"] = $new_cities;
            $new_campaigns = $this->stores_model->get_list();
            $data["campaigns"] = $new_campaigns;
            ob_start();
            $this->view->render("notifications/modal",$data,"1");
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
    public function islemler($value){
        ob_start();
        ?>
        <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle durumdegistir-<?php echo $value["id"];?>">Actions <span class="caret"></span> </button>
            <ul class="dropdown-menu">
                <li><a href="javascript:void(0)" onclick="modalGetir('<?php echo CONTROLLER;?>/edit','<?php echo $value["id"];?>')" class="dropdown-item"><span class="fa fa-edit"> </span> Edit</a></li>
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
    public function delete($id=null)
    {
        $form = $this->newform;
        $model = $this->newmodel;
        if (@$_POST) {
            $id = $_POST["id"];
            $model->delete($id);
            $response["message"] ="Successful";
            $response["status"] = true;
            $response["refresh"] = true;
            echo json_encode($response);
        }
    }
    public function dataListe() {
        $model = $this->newmodel;
        $requestData= $_REQUEST;

        $columns = array(
            // datatable column index  => database column name
            0 =>'id',
            1 => 'full_name',
            2=> 'email',
            3 => 'phone_number',
            4 => 'role',
            5 => 'created_at',
            6 => ''
        );
        // getting records as per search parameters
        $sql = "";
        if( !empty($requestData['columns'][0]['search']['value']) ){   //name
            $sql.=" AND id LIKE '".$requestData['columns'][0]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
            $sql.=" AND full_name LIKE '".$requestData['columns'][1]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){  //salary
            $sql.=" AND email LIKE '%".$requestData['columns'][2]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][3]['search']['value']) ){  //salary
            $sql.=" AND phone_number LIKE '".$requestData['columns'][3]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][4]['search']['value']) ){  //salary
            $sql.=" AND role LIKE '".strtotime($requestData['columns'][4]['search']['value'])."%' ";
        }
        if( !empty($requestData['columns'][5]['search']['value']) ){  //salary
            $sql.=" AND created_at LIKE '".strtotime($requestData['columns'][5]['search']['value'])."%' ";
        }
        $sql2 = $sql;
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

        $makale_liste = $model->users_list($sql);
        $toplammakale = $model->users_list($sql2);
        //echo $sql;
        $durum = "";
        $data = array();
        foreach ($makale_liste as $key => $row) {
            if($row["blocked"]=="0"){$status="Aktif";$renk = "btn-warning";}else{$status="Pasif";$renk = "btn-default";}

            // preparing an array
            $nestedData=array();
            $nestedData[] = $row["id"];
            $nestedData[] = $row["title"] . "--- ".$row["store_id"];
            $nestedData[] = $row["body"];
            $nestedData[] = $row["image"];
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
