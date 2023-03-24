<?php
class Load{
    public function __construct() {
        
    }    
    public function view($fileName, $data = false){
        if($data == true){
            extract($data);
        }
        require_once "app/views/" . $fileName."_view.php";
    }    
    public function model($fileName){
        require_once "app/models/" . $fileName . ".php";
        return new $fileName();
    }    
    public function controllers($fileName){
        require_once "app/controllers/" . $fileName . ".php";
        return new $fileName();
    }    
    public function otherClasses($fileName){
        require_once "app/otherClasses/" . $fileName . ".php";
        return new $fileName();
    }     
}