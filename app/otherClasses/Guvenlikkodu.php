<?php

class Guvenlikkodu {

    protected $code;
    protected $width = 125;
    protected $height = 35;
    protected $font = "public/eklentiler/font/Blurmix_0.TTF";
    protected $hane = "5";
    function __construct() 
    {        
        @session_start();
        $metin = $this->rastgele($this->hane);
        $this->code = $metin; 
        $_SESSION['guvenlik_kodu'] = $metin;
    }
    function rastgele($text) {
        $mevcut = "abcdefghjkmnprstuxvyz23456789ABCDEFGHJKMNPRSTUXVYZ";
        $salla = "";
        for($i=0;$i<$text;$i++) {
            @$salla .= $mevcut{rand(0,48)};
        }
        return $salla;
    }
    function getCode()
    {
        return $this->code;
    }
    function guvenlikKodu($renk,$yazirenk) 
    {
        list($br, $bg, $bb) = sscanf($renk, "#%02x%02x%02x");
        list($yr, $yg, $yb) = sscanf($yazirenk, "#%02x%02x%02x");
        // Arkaplan resmini oluşturuyoruz
            $img=imagecreatetruecolor($this->width,$this->height);
            imagesavealpha($img, true);
            $color = imagecolorallocatealpha($img, 0, 0, 0, 127);
            imagefill($img, 0, 0, $color);

        // Metin rengi ve karışıklık yaratmasını istediğimiz diğer renklerini tanımlıyoruz.
            $text_renk = imagecolorallocate($img, $yr, $yg, $yb);
            //$bg1 = imagecolorallocate($img, 244, 244, 244);
            //$bg2 = imagecolorallocate($img, 227, 239, 253);
            //$bg3 = imagecolorallocate($img, $br, $bg, $bb);

            header('Content-type: image/png');
            //imagettftext($img, 26, -4, 4, 25, $bg1, $this->font, $this->code);
            //imagettftext($img, 30, -7, 0, 15, $bg2, $this->font, $this->code);

        // Arka plana rastgele çizgiler yazdırıyoruz.
            //for( $i=0; $i<($this->width*$this->height)/400; $i++ ) {
                //imageline($img, mt_rand(0,$this->width), mt_rand(0,$this->height), mt_rand(0,$this->width), mt_rand(0,$this->height), $bg3);                  
            //}
        // Esasoğlan metnimizi (güvenlik kodu) bastırıyoruz.
            imagettftext($img, 28, 0, 0, 28, $text_renk, $this->font, $this->code);
            imagepng($img);
            imagedestroy($img);            
    }
}
