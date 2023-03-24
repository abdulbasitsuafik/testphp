<?php
class Languages extends Controller{
    public function __construct() {
        parent::__construct();
        $this->newmodel = $this->load->model("languages_model");
        $this->newform = $this->load->otherClasses("Form");
    }
    public function sqlSorgu($sql,$array=[]){
        return $this->newmodel->sqlSorgu($sql,$array);
    }
    public function index(){
        $form = $this->newform;
        $model = $this->newmodel;

//        $general_settings2 = $this->newmodel->insert_settings(["izin_tipi"=>"1"]);
//        $general_settings2 = $this->newmodel->insert_languages(["name"=>"English","code"=>"en","rank"=>"1","status"=>"1"]);
//        $general_settings = $this->sqlSorgu("SELECT * FROM ".PREFIX."languages");

        if(@$_POST){
            $response = $this->form_control($_POST);
            echo json_encode($response);
        }else{
            $data["title"] = "Languages";
            $data["dashboard"] = false;
            $data["general_settings"] = $general_settings;

            $this->view->render("languages/index",$data);
        }
    }
    public function add() {
        $form = $this->newform;
        $model = $this->newmodel;
        if(@$_POST["modal_getir"]){
            foreach ($_POST as $key => $value) {
                $form->post($key);
            }
            $data["title"] = "Add";
            $data["page_type"] = "add";

//            $data["languages"] = $model->active_languages();
            $data["title"] = [];
            ob_start();
            $this->view->render("languages/modal",$data,"1");
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
            $data["title"] = "Settings";
            $data["page_type"] = "edit";
            $data["id"] =@$form->values["id"];
            $data["data"] = $model->get_single(@$form->values["id"])[0];

            ob_start();
            $this->view->render("languages/modal",$data,"1");
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
    public function form_control($POST,$posttype=""){
//        error_reporting(true);
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
        $form = $this->newform;
        $model = $this->newmodel;
        foreach ($POST as $key => $value) {
            $form->post($key);
        }
        if(@$form->values['mecburiAlanlar']==""){
            $data = [];

//            genel

            $data['name'] = $form->values['name'];
            $data['code'] = $form->values['code'];
            $data['rank'] =$form->values['rank'];

            if(@$form->values["status"]){
                $data["status"] = $form->values["status"];
            }elseif(@$form->values["status"]==0) {
                $data["status"] = 0;
            }else{
                $data["status"] = 1;
            }

            if($posttype=="edit"){
                $data["head_id"] = @$form->values["b_id"];
                $modelstatus = $model->edit($data);
                $response["post_type"] = "edit";
            }else{
                $modelstatus = $model->add($data);
//                $response["post_type"] = "add";
            }

            $response["message"] = "Successful";
            $response["status"] = true;
            $response["modelstatus"] = $modelstatus;
            $response["content"] = $POST;
            $response["files"] = $_FILES;
            $response["data"] = $data;
        }else{
            $response["status"] = false;
            $response["message"] = "Fill in the blanks...";
            $response["post"] = $_POST;
            $response["files"] = $_FILES;
        }
        return $response;
    }
    public function islemler($value){
        ob_start();
        ?>
        <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle durumdegistir-<?php echo $value["id"];?>">Actions <span class="caret"></span> </button>
            <ul class="dropdown-menu">
                <li><a href="javascript:void(0)" onclick="modalGetir('<?php echo CONTROLLER;?>/edit','<?php echo $value["id"];?>')" class="dropdown-item"><span class="fa fa-edit"> </span> Düzenle</a></li>
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
    public function dataListe() {
        $model = $this->newmodel;
        $requestData= $_REQUEST;

        $columns = array(
            // datatable column index  => database column name
            0 =>'id',
            1 => 'name',
            2 => 'code',
            3 => 'rank',
            4 => 'status',
            8 => ''
        );
        // getting records as per search parameters
        $sql = "";
        if( !empty($requestData['columns'][0]['search']['value']) ){   //name
            $sql.=" AND id = '".$requestData['columns'][0]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
            $sql.=" AND name LIKE '".$requestData['columns'][1]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){  //salary
            $sql.=" AND code LIKE '%".$requestData['columns'][2]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][3]['search']['value']) ){  //salary
            $sql.=" AND rank LIKE '".$requestData['columns'][3]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][4]['search']['value']) ){  //salary
            $sql.=" AND status LIKE '".$requestData['columns'][4]['search']['value']."%' ";
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
                $new_subject = ' <span class="badge badge-danger onaysiz-id-'.$row["id"].'">Pasif</span>';
            }else{
                $new_subject = $row["status"];
            }


            // preparing an array
            $nestedData=array();
            $nestedData[] = $row["id"];
            $nestedData[] = $row["name"];
            $nestedData[] = $row["code"];
            $nestedData[] = $row["ranks"];
            $nestedData[] = $new_subject;
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
    public function delete($id=null)
    {
//        $form = $this->newform;
        $model = $this->newmodel;
        if ($_POST) {
            $id = $_POST["id"];
            $model->delete($id);
            $response["status"] =true;
            $response["message"] ="Successful";
            echo json_encode($response);
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

}
