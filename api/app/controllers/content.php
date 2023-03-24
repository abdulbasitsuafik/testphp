<?php
class Content extends Controller{
    public function __construct() {
        parent::__construct();
        $this->newmodel = $this->load->model("content_model");
        $this->content_model = $this->load->model("content_model");
        $this->store_model = $this->load->model("store_model");
        $this->device_model = $this->load->model("device_model");
        $this->actions = $this->load->controllers("actions");
        $this->system_tools = $this->load->otherClasses("SystemTools");
    }
    public function index(){
        echo "Welcome to Content";
    }
    public function content(){
        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');
        $data = [
            "_id"=>"1",
            "title"=>"deneme",
            "description"=>"deneme",
            "image"=>"deneme",
            "iV"=>5,
            "user"=>[
                "_id"=>"1",
                "name"=>"1",
                "image"=>"1",
                "date"=>$created_at
            ],
        ];
        echo json_encode($data);
    }
    public function urlcek($rank){
        $suanki_url = @$_GET['url'];
        $suanki_url = explode("/",$suanki_url);
        return @$suanki_url[$rank];
    }
    public function get_head()
    {
        $statusCode = 200;
//        $content = $_POST;
        $content = json_decode(file_get_contents('php://input'), TRUE);

        /**
         * Gelen parametreler
         */

        $device_id = @$content["device_id"];
        $content_id = @$content["content_id"];
        $multiple = @$content["multiple"];

        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');

        $device = $this->device_model->find_device(["device_id"=>$device_id]);

        /**
         * Device yoksa yeni device açma
         */
        //TODO device varsa ne yapıalcak
        if ($device) {
            $new_videos = [];
            $new_images = [];
            if($multiple){
                $contents = $this->newmodel->get_head_subs($content_id);
            }else{
                $contents = $this->newmodel->get_head($content_id)[0];
                $images = $this->newmodel->get_head_files($content_id,"image");
                $new_images = $images;

                $videos = $this->newmodel->get_head_files($content_id,"video");
                foreach ($videos as $index => $video) {
                    $videoId = $video["file_path"];
                    $videoId = explode("=",$videoId)[1];
                    $new_videos[] =  [
                        "title"=>$video["title"],
                        "videoId"=>$videoId,
                        "channel_name"=>"Panel App",
                    ];
                }
            }

            if ($contents){
                $response = [
                    "message"=>"Ok",
                    "data"=>$contents,
                    "videos"=>$new_videos,
                    "images"=>$new_images,
                ];
            }else{
                $statusCode = 401;
                $response = [
                    "message"=>"Empty",
                    "data"=>[]
                ];
            }

        }else{
            $response = [
                "message"=>"Device Update Successfuly",
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }
    public function get_heads()
    {
        $statusCode = 200;
//        $content = $_POST;
        $content = json_decode(file_get_contents('php://input'), TRUE);

        /**
         * Gelen parametreler
         */

        $device_id = @$content["device_id"];
        $content_id = @$content["content_id"];

        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');

        $device = $this->device_model->find_device(["device_id"=>$device_id]);

        /**
         * Device yoksa yeni device açma
         */
        //TODO device varsa ne yapıalcak
        if (!$device) {

            $contents = $this->newmodel->get_head_subs($content_id);
            if ($contents){
                $response = [
                    "message"=>"Ok",
                    "data"=>$contents
                ];
            }else{
                $statusCode = 401;
                $response = [
                    "message"=>"Empty",
                    "data"=>[]
                ];
            }

        }else{
            $response = [
                "message"=>"Device Update Successfuly",
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }
    public function get_contents()
    {
        $statusCode = 200;
//        $content = $_POST;
        $content = json_decode(file_get_contents('php://input'), TRUE);

        /**
         * Gelen parametreler
         */

        $device_id = @$content["device_id"];
        $content_name = @$content["content_name"];
        $class = @$content["class"];
        $lesson = @$content["lesson"];

        $d = new DateTime();
        $created_at = $d->format('Y-m-d H:i:s');

        $device = $this->device_model->find_device(["device_id"=>$device_id]);

        /**
         * Device yoksa yeni device açma
         */
        //TODO device varsa ne yapıalcak
        if ($device) {
            $datas = [
                "content_name"=>$content_name,
                "class"=>$class,
                "lesson"=>$lesson,
            ];
            $contents = $this->content_model->get_contents($datas);
            if ($contents){
                $response = [
                    "message"=>"Ok",
                    "data"=>$contents
                ];
            }else{
                $statusCode = 401;
                $response = [
                    "message"=>"Empty",
                    "data"=>[]
                ];
            }

        }else{
            $response = [
                "message"=>"Empty",
            ];
        }

        return $this->system_tools->json_response($response,$statusCode);
    }
    public function get_head_text($id)
    {
        $lang = $this->urlcek(3);
        $contents = $this->newmodel->get_head($id,$lang);
        echo "<div>";
        echo $contents[0]["content"];
        echo "</div>";
    }
}
