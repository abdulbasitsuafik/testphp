<?php
class regions extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
        Session::checkSession();
        $this->newmodel = $this->load->model("regions_model");
        $this->newform = $this->load->otherClasses("Form");
        $this->actions = $this->load->controllers("actions");
        $this->device_model = $this->load->model("device_model");
        $this->push_notification = $this->load->otherClasses("pushNotification");
        $this->notifications_model = $this->load->model("notifications_model");
    }

    public function index() {
        $form = $this->newform;
        $model = $this->newmodel;


        $data["title"] = "regions List";
//        $data["dashboard"] = false;
        $this->view->render("regions/index", $data);
    }
    public function form_control($POST,$posttype=""){
        $form = $this->newform;
        $model = $this->newmodel;
        foreach ($POST as $key => $value) {
            $form->post($key);
        }
        if(@$form->values['mecburiAlanlar']==""){
            $data = array(
                "name"=> $form->values['name'],
            );

//            if (@$form->values["status"]) {
//                $data["status"] = $form->values["status"];
//            } else {
//                $data["status"] = 1;
//            }
//            if(@$_FILES){
//                if (is_dir("uploads")) {
//                } else {
//                    mkdir("uploads");
//                }
//                if (is_dir("uploads/regions" )) {
//                } else {
//                    mkdir( "uploads/regions");
//                }
//                $output_dir = "uploads/regions/";
//
//                $fileName = @$_FILES["image"]["name"];
//                $nowdate = strtotime("now") . substr((string)microtime(), 1, 6);
//                $uzanti = explode(".",$fileName);
//                $uzanti = strtolower(".".end($uzanti));
//                if ($uzanti) {
//                    $yeni_ad = $output_dir . $nowdate . $uzanti;
//                    @copy(@$_FILES["image"]["tmp_name"],$yeni_ad);
//                    $data["image"] = $yeni_ad;
//                    $data["image"] = $yeni_ad;
//                }
//
//            }

            if ($posttype == "edit") {
                $data["id"] = @$form->values["b_id"];
                $kayıt = $model->edit($data);
                $response["status"] = true;
                $response["post"] = $_POST;
                $response["kayıt"] = $kayıt;
                $response["message"] = "Kayıt Başarılı 2";
                $response["content"] = $_POST;
                $response["files"] = $_FILES;
                $response["post_type"] = "edit";
                $response["get_table"] = true;
            } else {
                $model->add($data);
                $response["status"] = true;
                $response["message"] = "Registration Successful";
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
            $this->view->render("regions/modal",$data,"1");
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

            ob_start();
            $this->view->render("regions/modal",$data,"1");
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
    public function get_table(){
        ob_start();
        $model = $this->newmodel;
        $sorgu = $model->get_list();
        foreach ($sorgu as $key => $value){
            ?>
            <tr id="tableline-<?php echo $value["id"];?>">
                <td><?php echo $value['full_name']?></td>
                <td><?php echo $value['username']?></td>
                <td><?php echo $value['email']?></td>
                <td><?php echo $value['role'] == 3 ? "Student" : "Teacher" ?></td>
                <td><?php echo $value['created_at'];?></td>
                <td>
                    <?php echo $this->islemler($value);?>
                </td>
            </tr>
        <?php }
        $renderView = ob_get_clean();
        $reponse["renderView"] = $renderView;
        echo json_encode($reponse);
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
                    <a href="javascript:void(0)" onclick="change_status('<?php echo CONTROLLER;?>/status','<?php echo $value["id"];?>')" class="dropdown-item">
                        <div class="durumdegistirbuttons-<?php echo $value["id"];?>">
                            <?php if($value["status"] == 0){?>
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
        );
        // getting records as per search parameters
        $sql = "";
        if( !empty($requestData['columns'][0]['search']['value']) ){   //name
                $sql.=" AND id = '".$requestData['columns'][0]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
                $sql.=" AND name LIKE '".$requestData['columns'][1]['search']['value']."%' ";
        }

//        if( !empty($requestData['columns'][9]['search']['value']) ){  //salary
//            $sql.=" AND created_at = '".strtotime($requestData['columns'][9]['search']['value'])."' ";
//        }
            $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

            $makale_liste = $model->regions_list($sql);
            $toplammakale = $model->regions_list();
          //echo $sql;
            $durum = "";
            $data = array();
            foreach ($makale_liste as $key => $row) {
                    // preparing an array
                       $nestedData=array();
                       $nestedData[] = $row["id"];
                       $nestedData[] = $row["name"];

                       $nestedData[] = $row["created_at"];
                       $nestedData[] = $this->islemler($row);

                       $data[] = $nestedData;
               }

        $totaldata = @count($toplammakale);
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
