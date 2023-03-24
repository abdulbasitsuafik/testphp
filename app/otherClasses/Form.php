<?php

class Form{
    public $currentValue;
    public $values = array();
    public $errors = array();

    public function __construct() {}
    public function post($key){
        $this->values[$key]    = trim($_POST[$key]);
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
    public function seo($s,$altust) {
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
    public function karaktersil($s) {
        $tr = array('a','b','c','ç','d','e','f','g','ğ','h','ı','i','j','k','l','m','n','o','ö','p','r','s','ş','t','u','ü','v','y','z','S','ı','İ','I','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç','ş','Ş',' ','ğ','Ğ',"'",'’','“','”','‘','’','!','^','#','+','$','%','&','/','{',')',']','(','[','=','}','?','*','_','@','€','æ','ß','<','>','|',',',';',':','.','"');
        $eng = array('','','','','','','','','','','','','','','','','','','','',"",'','','','','','','','','','','','','','','','','','','','','','','','','',"",'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
        $s = str_replace($tr,$eng,$s);
        $s = strtolower($s);
        $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
        $s = preg_replace('/\s+/', '-', $s);
        $s = preg_replace('|-+|', '-', $s);
        $s = preg_replace('/#/', '', $s);
        $s = str_replace('.', '', $s);
        $s = trim($s, '-');
        $s = trim($s, 'abcçdefgğhıijklmnoöprsştuüvyz');
        return $s;
   }
   public function tirnak($veri)
   {
        return str_replace(array("'", "\""),array("&#39;", "&quot;"),$veri);
   }
   public function kisalt($kelime, $str = 10)   {
       $kelime = str_replace(array("<p>","</p>"), array("",""), $kelime);
      if (strlen($kelime) > $str)
      {
         if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
         else $kelime = substr($kelime, 0, $str).'..';
      }
      return $kelime;
    }
    public function xss_blocked($text){
        // Xss açığını kapatır.
        $text = preg_replace("#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i", "", $text);
        $text = preg_replace("#</*\w+:\w[^>]*+>#i", "", $text);
        $text = trim($text);
        $text = addslashes($text);

        return $text;
    }
    public function page_http(){
        $page_http  = "http";
        if(@$_SERVER["HTTPS"] == "on"){$page_http .= "s";}
        $page_http .= "://";

        return $page_http;
    }
    public function html_press(){
        $gzip_pres = true;
        function gzipKontrol(){
            $kontrol   = str_replace(" ", "", strtolower($_SERVER['HTTP_ACCEPT_ENCODING']));
            $kontrol   = explode(",", $kontrol);
            return in_array("gzip", $kontrol);
        }
        function bosluksil($kaynak){
            $kaynak    = preg_replace('#^\s*//.+$#m', null, $kaynak);
            $kaynak    = preg_replace("/\s+/", ' ', $kaynak);
            $kaynak    = preg_replace('/<!--(.|\s)*?-->/', null, $kaynak);
            $kaynak    = trim($kaynak);
            return $kaynak;
        }
        function kaynak_presle($kaynak){
            global $gzip_pres;
            $sayfa_cikti = bosluksil($kaynak);
            if(!gzipKontrol() || headers_sent() || !$gzip_pres)
                return $sayfa_cikti;
            header("Content-Encoding : gzip");
            return gzencode($sayfa_cikti);
        }
        ob_start("kaynak_presle");
    }
    public function get_url($rank){
        $suanki_url = isset($_GET["url"]) ? $_GET["url"] : null;
        if(!empty($_GET['url'])){
            $suanki_url = rtrim($_GET['url'], "/");
            $suanki_url = explode("/",$suanki_url);
            return @$suanki_url[$rank];
        }
    }
    function getUserIP() {
        if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
                $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    function getMacLinux() {
        exec('netstat -ie', $result);
        if(is_array($result)) {
            $iface = array();
            foreach($result as $key => $line) {
                if($key > 0) {
                    $tmp = str_replace(" ", "", substr($line, 0, 10));
                    if($tmp <> "") {
                        $macpos = strpos($line, "HWaddr");
                        if($macpos !== false) {
                            $iface[] = array('iface' => $tmp, 'mac' => strtolower(substr($line, $macpos+7, 17)));
                        }
                    }
                }
            }
            return $iface[0]['mac'];
        } else {
            return "notfound";
        }
    }
    public function get_mac_address(){
        $MAC0 = exec('getmac');
        $MAC1 = strtok($MAC, ' ');
        $MAC2 = system('arp -an');
        $MAC3 = shell_exec ("ifconfig -a | grep -Po 'HWaddr \K.*$'");

        $mac = shell_exec("ip link | awk '{print $2}'");
        preg_match_all('/([a-z0-9]+):\s+((?:[0-9a-f]{2}:){5}[0-9a-f]{2})/i', $mac, $matches);
        $output = array_combine($matches[1], $matches[2]);
        $mac_address_values =  json_encode($output, JSON_PRETTY_PRINT);


        $ipAddress=$_SERVER['REMOTE_ADDR'];
        $macAddr=false;

        $arp=`arp -a $ipAddress`;
        $lines=explode("\n", $arp);

        foreach($lines as $line)
        {
            $cols=preg_split('/\s+/', trim($line));
            if ($cols[0]==$ipAddress)
            {
                $macAddr=$cols[1];
            }
        }
//        require_once 'MacAddress.php';
//        $MacAddress = new MacAddress();
        $new_mac = [
            "mac_address_values"=>$mac_address_values,
            "MAC0" =>$MAC0,
            "MAC1" =>$MAC1,
            "MAC2" =>$MAC2,
            "MAC3" =>$MAC3,
            "macAddr"=>$macAddr,
        ];

        return json_encode($new_mac);
    }
    function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }elseif(preg_match('/Firefox/i',$u_agent)){
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }elseif(preg_match('/OPR/i',$u_agent)){
            $bname = 'Opera';
            $ub = "Opera";
        }elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
            $bname = 'Apple Safari';
            $ub = "Safari";
        }elseif(preg_match('/Netscape/i',$u_agent)){
            $bname = 'Netscape';
            $ub = "Netscape";
        }elseif(preg_match('/Edge/i',$u_agent)){
            $bname = 'Edge';
            $ub = "Edge";
        }elseif(preg_match('/Trident/i',$u_agent)){
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }else {
                $version= $matches['version'][1];
            }
        }else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        $data = array(
            'userAgent' => $u_agent,
            'model'      => $bname,
            'os_version'   => $version,
            'brand'  => $platform,
            'pattern'    => $pattern,
            "mac_address"        => "",
            "device_id"        => $this->getUserIP(),
            "local_language"        => substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)
        );

        $_SESSION["device_id"] = $data["device_id"];
        $_SESSION["local_language"] = $data["local_language"];
        return $data;
    }
}
