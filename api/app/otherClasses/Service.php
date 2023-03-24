<?php
error_reporting(true);
error_reporting(E_ALL);
ini_set('display_errors', 1);
//use AAD\Fatura\Exceptions\UnexpectedValueException;
//use NumberToWords;
class Service
{
    private $config = [
        "base_url"      => "https://earsivportaltest.efatura.gov.tr",
        "language"      => "tr",
        "currency"      => "TRY",
        "username"      => "",
        "password"      => "",
        "token"         => "",
        "service_type"  => "test",
    ];

    protected $curl_http_headers = [
        "accept: */*",
        "accept-language: tr,en-US;q=0.9,en;q=0.8",
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded;charset=UTF-8",
        "pragma: no-cache",
        "sec-fetch-mode: cors",
        "sec-fetch-site: same-origin",
        "connection: keep-alive"
    ];

    const COMMANDS = [
        "create_draft_invoice"                  => ["EARSIV_PORTAL_FATURA_OLUSTUR","RG_BASITFATURA"],
        "get_all_invoices_by_date_range"        => ["EARSIV_PORTAL_TASLAKLARI_GETIR", "RG_BASITTASLAKLAR"],
        "sign_draft_invoice"                    => ["EARSIV_PORTAL_FATURA_HSM_CIHAZI_ILE_IMZALA", "RG_BASITTASLAKLAR"],
        "get_invoice_html"                      => ["EARSIV_PORTAL_FATURA_GOSTER", "RG_BASITTASLAKLAR"],
        "cancel_draft_invoice"                  => ["EARSIV_PORTAL_FATURA_SIL", "RG_BASITTASLAKLAR"],
        "get_recipient_data_by_tax_id_or_tr_id" => ["SICIL_VEYA_MERNISTEN_BILGILERI_GETIR", "RG_BASITFATURA"],
        "send_sign_sms_code"                    => ["EARSIV_PORTAL_SMSSIFRE_GONDER", "RG_SMSONAY"],
        "verify_sms_code"                       => ["EARSIV_PORTAL_SMSSIFRE_DOGRULA", "RG_SMSONAY"],
        "get_user_data"                         => ["EARSIV_PORTAL_KULLANICI_BILGILERI_GETIR", "RG_KULLANICI"],
        "update_user_data"                      => ["EARSIV_PORTAL_KULLANICI_BILGILERI_KAYDET", "RG_KULLANICI"]
    ];

    private $uuid;

    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, $config);
        $tokens = $this->getToken();
        echo $tokens;
    }


    public function initService(array $config = [])
    {
        $this->config = array_merge($this->config, $config);
        $tokens = $this->getToken();
        return $tokens;
    }

    public function setConfig($key, $val)
    {
        $this->config[$key] = $val;
        return $this->config[$key];
    }

    public function getConfig($key)
    {
        return isset($this->config[$key]) ? $this->config[$key] : null;
    }
    const NIL = '00000000-0000-0000-0000-000000000000';
    const VALID_PATTERN = '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';
    public static function isValid($uuid)
    {
        $uuid = str_replace(array('urn:', 'uuid:', '{', '}'), '', $uuid);

        if ($uuid == self::NIL) {
            return true;
        }

        if (!preg_match('/' . self::VALID_PATTERN . '/', $uuid)) {
            return false;
        }
        return true;
    }
    public function setUuid($uuid)
    {
        if (!$this->isValid($uuid)) {
            throw new UnexpectedValueException("Belirttiğiniz uuid geçerli değil.");
        }
        $this->uuid = $uuid;
        return $uuid;
    }

    public function getUuid()
    {
        if (!isset($this->uuid)) {
            return $this->uuid1()->toString();
        }
        return $this->uuid;
    }
    public function toString()
    {
        return vsprintf(
            '%08s-%04s-%04s-%02s%02s-%012s',
            $this->fields
        );
    }
    protected $fields = array(
        'time_low' => '00000000',
        'time_mid' => '0000',
        'time_hi_and_version' => '0000',
        'clock_seq_hi_and_reserved' => '00',
        'clock_seq_low' => '00',
        'node' => '000000000000',
    );
    protected static function getIfconfig()
    {
        ob_start();
        switch (strtoupper(substr(php_uname('a'), 0, 3))) {
            case 'WIN':
                passthru('ipconfig /all 2>&1');
                break;
            case 'DAR':
                passthru('ifconfig 2>&1');
                break;
            case 'LIN':
            default:
                passthru('netstat -ie 2>&1');
                break;
        }

        return ob_get_clean();
    }
    protected static function getNodeFromSystem()
    {
        static $node = null;

        if ($node !== null) {
            return $node;
        }

        $pattern = '/[^:]([0-9A-Fa-f]{2}([:-])[0-9A-Fa-f]{2}(\2[0-9A-Fa-f]{2}){4})[^:]/';
        $matches = array();

        // Search the ifconfig output for all MAC addresses and return
        // the first one found
        if (preg_match_all($pattern, self::getIfconfig(), $matches, PREG_PATTERN_ORDER)) {
            $node = $matches[1][0];
            $node = str_replace(':', '', $node);
            $node = str_replace('-', '', $node);
        }

        return $node;
    }
    public static $force32Bit = false;
    protected static function is64BitSystem()
    {
        return (PHP_INT_SIZE == 8 && !self::$force32Bit);
    }
    public static $forceNoBigNumber = false;
    protected static function hasBigNumber()
    {
        return (class_exists('Moontoast\Math\BigNumber') && !self::$forceNoBigNumber);
    }
    protected static function calculateUuidTime($sec, $usec)
    {
        if (self::is64BitSystem()) {
            // 0x01b21dd213814000 is the number of 100-ns intervals between the
            // UUID epoch 1582-10-15 00:00:00 and the Unix epoch 1970-01-01 00:00:00.
            $uuidTime = ($sec * 10000000) + ($usec * 10) + 0x01b21dd213814000;

            return array(
                'low' => sprintf('%08x', $uuidTime & 0xffffffff),
                'mid' => sprintf('%04x', ($uuidTime >> 32) & 0xffff),
                'hi' => sprintf('%04x', ($uuidTime >> 48) & 0x0fff),
            );
        }

        if (self::hasBigNumber()) {
            $uuidTime = new \Moontoast\Math\BigNumber('0');

            $sec = new \Moontoast\Math\BigNumber($sec);
            $sec->multiply('10000000');

            $usec = new \Moontoast\Math\BigNumber($usec);
            $usec->multiply('10');

            $uuidTime->add($sec)
                ->add($usec)
                ->add('122192928000000000');

            $uuidTimeHex = sprintf('%016s', $uuidTime->convertToBase(16));

            return array(
                'low' => substr($uuidTimeHex, 8),
                'mid' => substr($uuidTimeHex, 4, 4),
                'hi' => substr($uuidTimeHex, 0, 4),
            );
        }

        throw new Exception\UnsatisfiedDependencyException(
            'When calling ' . __METHOD__ . ' on a 32-bit system, '
            . 'Moontoast\Math\BigNumber must be present'
        );
    }
    public static $ignoreSystemNode = false;
    public static $timeOfDayTest;
    public static function uuid1($node = null, $clockSeq = null)
    {
        if ($node === null && !self::$ignoreSystemNode) {
            $node = self::getNodeFromSystem();
        }

        // if $node is still null (couldn't get from system), randomly generate
        // a node value, according to RFC 4122, Section 4.5
        if ($node === null) {
            $node = sprintf('%06x%06x', mt_rand(0, 1 << 24), mt_rand(0, 1 << 24));
        }

        // Convert the node to hex, if it is still an integer
        if (is_int($node)) {
            $node = sprintf('%012x', $node);
        }

        if (ctype_xdigit($node) && strlen($node) <= 12) {
            $node = strtolower(sprintf('%012s', $node));
        } else {
            throw new InvalidArgumentException('Invalid node value');
        }

        if ($clockSeq === null) {
            // Not using "stable storage"; see RFC 4122, Section 4.2.1.1
            $clockSeq = mt_rand(0, 1 << 14);
        }

        // Create a 60-bit time value as a count of 100-nanosecond intervals
        // since 00:00:00.00, 15 October 1582
        if (self::$timeOfDayTest === null) {
            $timeOfDay = gettimeofday();
        } else {
            $timeOfDay = self::$timeOfDayTest;
        }
        $uuidTime = self::calculateUuidTime($timeOfDay['sec'], $timeOfDay['usec']);

        // Set the version number to 1
        $timeHi = hexdec($uuidTime['hi']) & 0x0fff;
        $timeHi &= ~(0xf000);
        $timeHi |= 1 << 12;

        // Set the variant to RFC 4122
        $clockSeqHi = ($clockSeq >> 8) & 0x3f;
        $clockSeqHi &= ~(0xc0);
        $clockSeqHi |= 0x80;

        $fields = array(
            'time_low' => $uuidTime['low'],
            'time_mid' => $uuidTime['mid'],
            'time_hi_and_version' => sprintf('%04x', $timeHi),
            'clock_seq_hi_and_reserved' => sprintf('%02x', $clockSeqHi),
            'clock_seq_low' => sprintf('%02x', $clockSeq & 0xff),
            'node' => $node,
        );

        return new self($fields);
    }

    public function currencyTransformerToWords($amount)
    {
        $amount = (string) str_replace(".", "", $amount);
//        $number_to_words = new NumberToWords\NumberToWords();
//        $currency_transformer = $number_to_words->getCurrencyTransformer($this->config['language']);
//        return mb_strtoupper($currency_transformer->toWords($amount, $this->config['currency']), 'utf-8');

        $fmt = new NumberFormatter( 'tr_TR', NumberFormatter::CURRENCY );
//        $new_amount =  $fmt->formatCurrency($amount, "EUR")."\n";
        $new_amount = $fmt->formatCurrency($amount, "TRY")."\n";
//        $new_amount = $fmt->formatCurrency($amount, "YTL")."\n\n";

        return mb_strtoupper($this->numberTowords($amount), 'utf-8');
    }
    public function numberTowords($num)
    {
        $ones = array(
            1 => "bir",
            2 => "iki",
            3 => "üç",
            4 => "dört",
            5 => "beş",
            6 => "altı",
            7 => "yedi",
            8 => "sekiz",
            9 => "dokuz",
            10 => "on",
            11 => "onbir",
            12 => "oniki",
            13 => "onüç",
            14 => "ondört",
            15 => "onbeş",
            16 => "onaltı",
            17 => "onyedi",
            18 => "onsekiz",
            19 => "ondokuz"
        );
        $tens = array(
            1 => "on",
            2 => "yirmi",
            3 => "otuz",
            4 => "kırk",
            5 => "elli",
            6 => "altmış",
            7 => "yetmiş",
            8 => "seksen",
            9 => "doksan"
        );
        $hundreds = array(
            "yüz",
            "bin",
            "milyon",
            "milyar",
            "trilyon",
            "katrilyon"
        ); //limit t quadrillion
        $num = number_format($num,2,".",",");
        $num_arr = explode(".",$num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",",$wholenum));
        krsort($whole_arr);
        $rettxt = "";
        foreach($whole_arr as $key => $i){
            if($i < 20){
                $rettxt .= $ones[$i];
            }elseif($i < 100){
                $rettxt .= $tens[substr($i,0,1)];
                $rettxt .= " ".$ones[substr($i,1,1)];
            }else{
                $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
                $rettxt .= " ".$tens[substr($i,1,1)];
                $rettxt .= " ".$ones[substr($i,2,1)];
            }
            if($key > 0){
                $rettxt .= " ".$hundreds[$key]." ";
            }
        }
        if($decnum > 0){
            $rettxt .= " ve ";
            if($decnum < 20){
                $rettxt .= $ones[$decnum];
            }elseif($decnum < 100){
                $rettxt .= $tens[substr($decnum,0,1)];
                $rettxt .= " ".$ones[substr($decnum,1,1)];
            }
        }
        return $rettxt;
    }
    public function getToken()
    {
        if (isset($this->config['token']) && !empty($this->config['token'])) {
            return $this->config['token'];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->config['base_url']}/earsiv-services/assos-login");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->curl_http_headers);
        curl_setopt($ch, CURLOPT_REFERER, "{$this->config['base_url']}/intragiris.html");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            "assoscmd" => $this->config['service_type'] == 'prod' ? "anologin" : "login",
            "rtype" => "json",
            "userid" => $this->config['username'],
            "sifre" => $this->config['password'],
            "sifre2" => $this->config['password'],
            "parola" => 1,
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_response = curl_exec($ch);
        $response = json_decode($server_response, true);
        curl_close($ch);

        $this->setConfig("token", $response['token']);
        return $response['token'];
    }

    public function runCommand($command, $page_name, $data = null, $url_encode = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->config['base_url']}/earsiv-services/dispatch");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->curl_http_headers);
        curl_setopt($ch, CURLOPT_REFERER, "{$this->config['base_url']}/login.jsp");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            "callid" => $this->getUuid(),
            "token" => $this->config['token'],
            "cmd" => $command,
            "pageName" => $page_name,
            "jp" => $url_encode ? urlencode(json_encode($data)) : json_encode($data),
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_response = curl_exec($ch);
        curl_close($ch);
        return json_decode($server_response, true);
    }

    public function createDraftInvoice($invoice_details = [])
    {
        $invoice_data = [
            "faturaUuid" => $this->getUuid(),
            "belgeNumarasi" => "",
            "faturaTarihi" => $invoice_details['date'],
            "saat" => $invoice_details['time'],
            "paraBirimi" => $this->config['currency'],
            "dovzTLkur" => "0",
            "faturaTipi" => "SATIS",
            "vknTckn" => $invoice_details['taxIDOrTRID'] ? $invoice_details['taxIDOrTRID'] : "11111111111",
            "aliciUnvan" => $invoice_details['title'] ? $invoice_details['title'] : "",
            "aliciAdi" => $invoice_details['name'],
            "aliciSoyadi" => $invoice_details['surname'],
            "binaAdi" => "",
            "binaNo" => "",
            "kapiNo" => "",
            "kasabaKoy" => "",
            "vergiDairesi" => $invoice_details['taxOffice'],
            "ulke" => "Türkiye",
            "bulvarcaddesokak" => $invoice_details['fullAddress'],
            "mahalleSemtIlce" => "",
            "sehir" => " ",
            "postaKodu" => "",
            "tel" => "",
            "fax" => "",
            "eposta" => "",
            "websitesi" => "",
            "iadeTable" => [],
            "ozelMatrahTutari" => "0",
            "ozelMatrahOrani" => 0,
            "ozelMatrahVergiTutari" => "0",
            "vergiCesidi" => " ",
            "malHizmetTable" => [],
            "tip" => "İskonto",
            "matrah" => round($invoice_details['grandTotal'], 2),
            "malhizmetToplamTutari" => round($invoice_details['grandTotal'], 2),
            "toplamIskonto" => "0",
            "hesaplanankdv" => round($invoice_details['totalVAT'], 2),
            "vergilerToplami" => round($invoice_details['totalVAT'], 2),
            "vergilerDahilToplamTutar" => round($invoice_details['grandTotalInclVAT'], 2),
            "odenecekTutar" => round($invoice_details['paymentTotal'], 2),
            "not" => $this->currencyTransformerToWords($invoice_details['paymentTotal']),
            "siparisNumarasi" => "",
            "siparisTarihi" => "",
            "irsaliyeNumarasi" => "",
            "irsaliyeTarihi" => "",
            "fisNo" => "",
            "fisTarihi" => "",
            "fisSaati" => " ",
            "fisTipi" => " ",
            "zRaporNo" => "",
            "okcSeriNo" => ""
        ];

        foreach ($invoice_details['items'] as $item) {
            $invoice_data['malHizmetTable'][] = [
                "malHizmet" => $item['name'],
                "miktar" => $item['quantity'] ? $item['quantity'] :1 ,
                "birim" => "C62",
                "birimFiyat" => round($item['unitPrice'], 2),
                "fiyat" => round($item['price'], 2),
                "iskontoArttm" => "İskonto",
                "iskontoOrani" => 0,
                "iskontoTutari" => "0",
                "iskontoNedeni" => "",
                "malHizmetTutari" => round(($item['quantity'] * $item['unitPrice']), 2),
                "kdvOrani" => round($item['VATRate'], 0),
                "vergiOrani" => 0,
                "kdvTutari" => round($item['VATAmount'], 2),
                "vergininKdvTutari" => "0"
            ];
        }
      
        $invoice = $this->runCommand(
            self::COMMANDS['create_draft_invoice'][0],
            self::COMMANDS['create_draft_invoice'][1],
            $invoice_data
        );
        print_r($invoice);
        return array_merge([
            "date" => $invoice_data['faturaTarihi'],
            "uuid" => $invoice_data['faturaUuid'],
        ], $invoice);
    }

    public function getAllInvoicesByDateRange($start_date, $end_date)
    {
        $invoices = $this->runCommand(
            self::COMMANDS['get_all_invoices_by_date_range'][0],
            self::COMMANDS['get_all_invoices_by_date_range'][1],
            [
                "baslangic" => $start_date,
                "bitis" => $end_date,
                "table" => []
            ]
        );
        return $invoices['data'];
    }

    public function findDraftInvoice($draft_invoice)
    {
        $drafts = $this->runCommand(
            self::COMMANDS['get_all_invoices_by_date_range'][0],
            self::COMMANDS['get_all_invoices_by_date_range'][1],
            [
                "baslangic" => $draft_invoice['date'],
                "bitis" => $draft_invoice['date'],
                "table" => []
            ]
        );
        print_r($drafts);
        foreach ($drafts['data'] as $item) {
            if ($item['ettn'] === $draft_invoice['uuid']) {
                return $item;
            }
        }

        return [];
    }

    public function signDraftInvoice($draft_invoice)
    {
        return $this->runCommand(
            self::COMMANDS['sign_draft_invoice'][0],
            self::COMMANDS['sign_draft_invoice'][1],
            [
                'imzalanacaklar' => [$draft_invoice]
            ]
        );
    }

    public function getInvoiceHTML($uuid, $signed = true)
    {
        $invoice = $this->runCommand(
            self::COMMANDS['get_invoice_html'][0],
            self::COMMANDS['get_invoice_html'][1],
            [
                'ettn' => $uuid,
                'onayDurumu' => $signed ? "Onaylandı" : "Onaylanmadı"
            ]
        );
        return $invoice['data'];
    }

    public function getDownloadURL($invoiceUUID, $signed = true)
    {
        $sign_status = urlencode($signed ? "Onaylandı" : "Onaylanmadı");

        return "{$this->config['base_url']}/earsiv-services/download?token={$this->config['token']}&ettn={$invoiceUUID}&belgeTip=FATURA&onayDurumu={$sign_status}&cmd=downloadResource";
    }

    public function createInvoice($invoice_details, $sign = true)
    {
        if (!isset($this->config['token']) || empty($this->config['token'])) {
            $this->getToken();
        }

        $draft_invoice = $this->createDraftInvoice($invoice_details);
        $draft_invoice_details = $this->findDraftInvoice($draft_invoice);

        if ($sign) {
            $this->signDraftInvoice($draft_invoice_details);
        }

        return [
          'uuid' => $draft_invoice['uuid'],
          'signed' => $sign
        ];
    }
    public function createInvoiceAndGetDownloadURL($args)
    {
        $invoice = $this->createInvoice($args['invoice_details'], $args['sign'] ? $args['sign'] :  true);
        return $this->getDownloadURL($invoice['uuid'], $invoice['signed']);
    }

    public function createInvoiceAndGetHTML($args)
    {
        $invoice = $this->createInvoice($args['invoice_details'], $args['sign'] ? $args['sign']: true);
        return $this->getInvoiceHTML($invoice['uuid'], $invoice['signed']);
    }

    public function cancelDraftInvoice($reason, $draft_invoice)
    {
        $cancel = $this->runCommand(
            self::COMMANDS['cancel_draft_invoice'][0],
            self::COMMANDS['cancel_draft_invoice'][1],
            [
                'silinecekler' => [$draft_invoice],
                'aciklama' => $reason
            ]
        );
        
        return $cancel['data'];
    }

    public function getRecipientDataByTaxIDOrTRID($tax_id_or_tr_id)
    {
        $recipient = $this->runCommand(
            self::COMMANDS['get_recipient_data_by_tax_id_or_tr_id'][0],
            self::COMMANDS['get_recipient_data_by_tax_id_or_tr_id'][1],
            [
                'vknTcknn' => $tax_id_or_tr_id
            ]
        );

        return $recipient['data'];
    }

    public function sendSignSMSCode($phone)
    {
        $sms = $this->runCommand(
            self::COMMANDS['send_sign_sms_code'][0],
            self::COMMANDS['send_sign_sms_code'][1],
            [
                "CEPTEL" => $phone,
                "KCEPTEL" => false,
                "TIP" => ""
            ]
        );

        return $sms['oid'];
    }

    public function verifySignSMSCode($sms_code, $operation_id)
    {
        $sms = $this->runCommand(
            self::COMMANDS['verify_sms_code'][0],
            self::COMMANDS['verify_sms_code'][1],
            [
                "SIFRE" => $sms_code,
                "OID" => $operation_id
            ]
        );

        return $sms['oid'];
    }

    public function getUserData()
    {
        $user = $this->runCommand(
            self::COMMANDS['get_user_data'][0],
            self::COMMANDS['get_user_data'][1],
            new \stdClass()
        );

        return [
            "taxIDOrTRID" => $user['data']['vknTckn'],
            "title" => $user['data']['unvan'],
            "name" => $user['data']['ad'],
            "surname" => $user['data']['soyad'],
            "registryNo" => $user['data']['sicilNo'],
            "mersisNo" => $user['data']['mersisNo'],
            "taxOffice" => $user['data']['vergiDairesi'],
            "fullAddress" => $user['data']['cadde'],
            "buildingName" => $user['data']['apartmanAdi'],
            "buildingNumber" => $user['data']['apartmanNo'],
            "doorNumber" => $user['data']['kapiNo'],
            "town" => $user['data']['kasaba'],
            "district" => $user['data']['ilce'],
            "city" => $user['data']['il'],
            "zipCode" => $user['data']['postaKodu'],
            "country" => $user['data']['ulke'],
            "phoneNumber" => $user['data']['telNo'],
            "faxNumber" => $user['data']['faksNo'],
            "email" => $user['data']['ePostaAdresi'],
            "webSite" => $user['data']['webSitesiAdresi'],
            "businessCenter" => $user['data']['isMerkezi']
        ];
    }

    public function updateUserData(array $user_data)
    {
        $fields = [
            "taxIDOrTRID" => 'vknTckn',
            "title" => 'unvan',
            "name" => 'ad',
            "surname" => 'soyad',
            "registryNo" => 'sicilNo',
            "mersisNo" => 'mersisNo',
            "taxOffice" => 'vergiDairesi',
            "fullAddress" => 'cadde',
            "buildingName" => 'apartmanAdi',
            "buildingNumber" => 'apartmanNo',
            "doorNumber" => 'kapiNo',
            "town" => 'kasaba',
            "district" => 'ilce',
            "city" => 'il',
            "zipCode" => 'postaKodu',
            "country" => 'ulke',
            "phoneNumber" => 'telNo',
            "faxNumber" => 'faksNo',
            "email" => 'ePostaAdresi',
            "webSite" => 'webSitesiAdresi',
            "businessCenter" => 'isMerkezi',
        ];

        $update_data = [];
        foreach ($fields as $source => $target) {
            if (isset($user_data[$source])) {
                $update_data[$target] = $user_data[$source];
            }
        }

        if (count($update_data) < 1) {
            return;
        }
        
        $user = $this->runCommand(
            self::COMMANDS['update_user_data'][0],
            self::COMMANDS['update_user_data'][1],
            $update_data
        );

        return $user['data'];
    }
}
