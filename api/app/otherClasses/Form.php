<?php

class Form{
    public $currentValue;
    public $values = array();
    public $errors = array();
    
    public function __construct() {}
    
    public function post($key){        
        $this->values[$key]    = @trim($_POST[$key]);
        $this->currentValue    = $key;
        return $this;
    }
    public function get($key){        
        $this->values[$key]     = trim($_GET[$key]);
        $this->currentValue    = $key;
        return $this;
    }
    public function isEmpty(){
        if(empty($this->values[$this->currentValue])){
            $this->errors[$this->currentValue]['empty'] = "Lütfen bu alanı boş bırakmayınız.";
        }
        return $this;
    }
    public function length($min = 0, $max){
        if(strlen($this->values[$this->currentValue]) < $min OR strlen($this->values[$this->currentValue]) > $max){
            $this->errors[$this->currentValue]['length'] = "Lütfen " . $min . " ve " . $max . " karakter arasında bir yazı giriniz.";
        }
        return $this;
    }
    public function isMail() {
        if(!filter_var($this->values[$this->currentValue], FILTER_VALIDATE_EMAIL)){
            $this->errors[$this->currentValue]['mail'] = "Lütfen geçerli bir mail adresi giriniz.";
        }
    }
    
    public function submit(){
        if(empty($this->errors)){
            return true;
        }else{
            return false;
        }
    }
    
    public function yazi($s) {
            $tr = array('Ç', 'ç', 'Ğ', 'ğ', 'ı', 'İ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü');
            $kod = array('&Ccedil;', '&ccedil;', '&#286;', '&#287;', '&#305;', '&#304;', '&Ouml;', '&ouml;', '&#350;', '&#351;', '&Uuml;', '&uuml;');
            $s = str_replace($tr, $kod, $s);
        return $s;
    }
    
    public function seo($s,$altust=null) {
        if($altust==""){$altust="-";}
        $tr = array('s','S','ı','İ','I','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç','ş','Ş',' ','ğ','Ğ',"'",'’','“','”','‘','’','!','^','#','+','$','%','&','/','{',')',']','(','[','=','}','?','*','_','@','€','æ','ß','<','>','|',',',';',':','.','"');
        $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','s','s',$altust,'g','g',"-",$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust,'a','e',$altust,'b',$altust,$altust,$altust,$altust,$altust,$altust,$altust,$altust);
        $s = str_replace($tr,$eng,$s);
        $s = strtolower($s);
        $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
        $s = preg_replace('/\s+/', $altust, $s);
        $s = preg_replace('|-+|', $altust, $s);
        $s = preg_replace('/#/', '', $s);
        $s = str_replace('.', '', $s);
        $s = trim($s, $altust);
        return $s;
    }
       
    public function tirnak2($veri)
    {
        $veri = is_array($veri) ? array_map('tirnak', $veri) : stripslashes($veri);
        return $veri;
    }
    public function tirnak($veri)
    {
        return str_replace(array("'", "\""),array("&#39;", "&quot;"),$veri);
    }

    public function kisalt($kelime, $str = 10)   {
      if (strlen($kelime) > $str)
      {
         if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
         else $kelime = substr($kelime, 0, $str).'..';
      }
      return $kelime;
    }
    public function find_array_in_array($tekArray, $tumArray) {
        //$rankmiz = $this->find_array_in_array($tekArray, $tumArray);
        $keys = array_keys($tumArray, $tekArray[0]);
        $out = array();
        foreach ($keys as $key) {
            $add = true;
            $result = array();
            foreach ($tekArray as $i => $value) {
                if (!(isset($tumArray[$key + $i]) && $tumArray[$key + $i] == $value)) {
                    $add = false;
                    break;
                }
                $result[] = $key + $i;
            }
            if ($add == true) { 
                $out[] = $result;
            }
        }
        return $out;
    }
    
    public static function delTree($dir) { 
	   $files = array_diff(scandir($dir), array('.','..')); 
	    foreach ($files as $file) { 
	      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
	    } 
	    return rmdir($dir); 
	} 
    public function xss_blocked($text){
        // Xss açığını kapatır.
        $text = preg_replace("#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i", "", $text);
        $text = preg_replace("#</*\w+:\w[^>]*+>#i", "", $text);
        $text = trim($text);
        $text = addslashes($text);
        
        return $text;
    }

    public function ccMasking($number, $maskingCharacter = '*') {
        return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
    }

    function tr_strtoupper($text)
    {
        $search=array("ç","i","ı","ğ","ö","ş","ü");
        $replace=array("Ç","İ","I","Ğ","Ö","Ş","Ü");
        $text=str_replace($search,$replace,$text);
        $text=strtoupper($text);
        return $text;
    }
    
}