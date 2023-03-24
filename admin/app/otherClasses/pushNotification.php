<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 12.03.2018
 * Time: 11:07
 */

class PushNotification
{

    //TODO CİHAZ TABLOSU EKLENMESİ GEREKİYOR. ENTİTY İSMİNE GÖRE AŞAĞIDAKİ Device  yazan yerli aktif ediniz.

    // (Android)API access key from Google API's Console.
//    private static $API_ACCESS_KEY = 'AIzaSyBMtTtx64aEgbyF_vApjZ7HJQ1r6Zph8rw';
//    private static $API_ACCESS_KEY = 'AIzaSyBUaSW_6UVzo_gG-Gd5dY8mvJ8mmm9d4qk';
//    private static $API_ACCESS_KEY = 'AAAAjjixEmc:APA91bGwrjCef8xdGs3rWf1zrdGqThp1fC6jatAoQkzEbUyoevfYJau8k9gCFLxBNZxIBYgzCpktHGULp2HS4X0ozche0o1qVuGNjxtGoh4I6QWs5ExFDyJB-ktyhANa7CccWeUMGmFp';//TODO google apikey
    private static $API_ACCESS_KEY = 'AAAA2vgQpB4:APA91bHg317LQvCpyFS0M359oMuBk_We6W98-x9tJSevl2v09l62tAqF2NOFsIYhcBqnLrKFUGrv7_B_AhYI4-anOv1rvvS4kikujZ9a57sP3ZCFXTxmHe8mkYnFgUbL0yy6tgR_DzNL';//TODO google apikey

    // (iOS) Private key's passphrase.
    private static $passphrase = 'joashp';

    // (Windows Phone 8) The name of our push channel.
    private static $channelName = "joashp";

    // Change the above three vriables as per your app.

    public function __construct() {
//        exit('Init function is not allowed');
    }


    public function prepareNotificationData($title,$desc,$extra = array(),$actions = array(),$vibrate = 1, $vibrationPattern = [2000, 1000, 500, 500]){


        /*$message = array(
            'title' => $data['title'],
            'message' => $data['desc'],
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1,
            'extra' => $data['extra'],
            "actions" => [
                ["icon" => "emailGuests", "title" => "EMAIL GUESTS", "callback" => "app.emailGuests", "foreground" => true],
                ["icon" => "snooze", "title" => "SNOOZE", "callback" => "app.snooze", "foreground" => false]
            ],
            "vibrationPattern" => [2000, 1000, 500, 500]

        );*/

        //data adında array oluşturduk. Başlık ve açıklamayı içine aktardık.
        $data['title'] = $title;
        $data['desc'] = $desc;
        $data['actions'] = $actions;
        $data['vibrate'] = $vibrate;
        $data['vibrationPattern'] = $vibrationPattern;

//        $array = array('url' => $url);
//        $array = array_merge($array,$extra);

        //Mobil uygulamada neresi açılacak onun yolu
        $data['extra'] = $extra;//ekstranın içine kendi gödnereceğimiz dataları yazıyoruz. Örnek url => tıklanıca mobilde neresi açılacak diye bir parametre. Uygulamada bu parametreyi çekip yönlendirme yapabilirisin
        dump($data);exit;
        return $data;

    }


    public function prepareNotificationActionButton($title,$callback,$foreground = true,$icon = null){

        //$foreground uygulama tamamen kapalı iken tıklanınca açar.false olursa uygulama arkaplanda çalışıyorsa uygulamayı açmadan işlem yaptırır
        return ["icon" => $icon, "title" => $title, "callback" => $callback, "foreground" => $foreground];

    }

    public function sendNotificationFromToken(Device $token,$data){


        if(!is_object($token)){

            return false;
        }

        $deviceToken = $token->getPushToken();
        $osType = $token->getOsType();

        $response = "";
        if(mb_strtolower($osType) == "android"){
            $response = $this->android($data,$deviceToken);
        }else{
//            $response = $this->iOS($data,$deviceToken);

        }


        return $response;


    }

    // Sends Push notification for Android users
    public function sendAndoid($data, $reg_ids=null,$androidTokenIds = array())
    {
//        if($reg_ids==null){
//            $reg_ids = [
//                "cfJzmjjZSF22Zj8MIoT8Si:APA91bHWGtTmN9hy9BEzJ5zTMJIbLw0W3YE-ZzW3zzaDN7DmA6dX_lMUHlMwCc0nY_uGHRPB-D60iZmdHzbCMQG9Vr2UemZ7pek5CvWUtO0rJJv4ShzK2mpgliIqpV8mG_5aSCcNWzyb",
//            ];
//        }

        //Google tek seferde 1000 adet bildirim gönderebilir. O yüzden arrayımizi 1000'erli guruplara bölüyoruz.
        $array_chunk = array_chunk($reg_ids, 1000);
        $androidTokenIdsChunk = array_chunk($androidTokenIds, 1000);
        $response = [];
        $error_tokens = [];
        $error_token_ids = [];
        $success_token_ids = [];

//        echo "<pre>";
//        print_r($reg_ids);
//        dump($array_chunk);exit;
        if (is_array($array_chunk) || is_object($array_chunk)){
            foreach ($array_chunk as $key => $value) {

                $r = $this->android($data, $value);
//                dump($r);exit;
                $re = json_decode($r, true);
                $results = $re["results"];
                $results["re"] = $re;
//            dump($data);
//            dump($value);
//            dump($re);
//            dump($results);
//            dump($androidTokenIdsChunk);

                //dump($results);
//            echo "<hr>";
                if (is_array($results) || is_object($results)) {
                    foreach ($results as $key2 => $result) {


//                if(array_key_exists("error",$result)){
//                    array_push($error_token_ids,$androidTokenIdsChunk[$key][$key2]);
//                }else if(array_key_exists("message_id",$result)){
//                    array_push($success_token_ids,$androidTokenIdsChunk[$key][$key2]);
//
//                }

                    }
                }
//
                $response[$key]["error_token_ids"] = $error_token_ids;
            }
        }



//        echo "push gimişolmaslı";

//        exit;


        return $response;
    }


    // Sends Push's toast notification for Windows Phone 8 users
    public function WP($data, $uri) {
        $delay = 2;
        $msg =  "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
            "<wp:Notification xmlns:wp=\"WPNotification\">" .
            "<wp:Toast>" .
            "<wp:Text1>".htmlspecialchars($data['mtitle'])."</wp:Text1>" .
            "<wp:Text2>".htmlspecialchars($data['mdesc'])."</wp:Text2>" .
            "</wp:Toast>" .
            "</wp:Notification>";

        $sendedheaders =  array(
            'Content-Type: text/xml',
            'Accept: application/*',
            'X-WindowsPhone-Target: toast',
            "X-NotificationClass: $delay"
        );

        $response = $this->useCurl($uri, $sendedheaders, $msg);

        $result = array();
        foreach(explode("\n", $response) as $line) {
            $tab = explode(":", $line, 2);
            if (count($tab) == 2)
                $result[$tab[0]] = trim($tab[1]);
        }

        return $result;
    }

    // Sends Push notification for iOS users
    public function iOS($data, $devicetoken) {

        $deviceToken = $devicetoken;

        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', self::$passphrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client(
            'ssl://gateway.sandbox.push.apple.com:2195', $err,
            $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        // Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'title' => $data['mtitle'],
                'body' => $data['mdesc'],
            ),
            'sound' => 'default'
        );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        fclose($fp);

        if (!$result)
            return 'Message not delivered' . PHP_EOL;
        else
            return 'Message successfully delivered' . PHP_EOL;

    }

    // Curl &$model,
    private function useCurl($url, $headers, $fields = null) {
        // Open connection
        $ch = curl_init();

        if ($url) {
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($fields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }

            // Close connection
            curl_close($ch);



            return $result;

        }
    }
    // Sends Push notification for Android users
    private function android($data, $reg_ids) {


//        dump($data);exit;
//        $url = 'https://android.googleapis.com/gcm/send';
        $url = 'https://fcm.googleapis.com/fcm/send';
//        $url = 'https://fcm.googleapis.com/v1/projects/campaign-d34ce/messages:send';
//        $url = 'https://iid.googleapis.com/iid/v1:batchAdd';
//        $url = 'https://gcm-http.googleapis.com/gcm/send';

//        dump($message);exit;
        $headers = array(
            'Authorization: key=' .self::$API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        if(!is_array($reg_ids)){
            $reg_ids = array($reg_ids);
        }

        $extdata = array(
            "title"=> $data['title'],
            "message"=>$data['desc'],
//                "action"=> "url",
//                "action_destination"=> "http://androiddeft.com",
            "image"=>$data["banner"],
            "img_url"=>$data["banner"],
            "picture"=>$data["banner"],
            "summaryText" => $data['title'],
            "headsUp"=> true,
            "playSound"=> true,
            "enableLights"=> true,
            "color"=> "#c41e63",
            "style" => 'picture',
            "vibrate" => true,
            "vibrationPattern" => [2000, 1000, 500, 500],
            "sound" => true,
            "largeIcon" => "ic_large_app",
            "smallIcon" => "ic_stat_berichten",
            "detail_id"=>$data["detail_id"]
        );
        $fields = array(
            'registration_ids' => $reg_ids,
            'notification' => [
                'title' => $data['title'],
                'body' => $data['desc'],
                'sound' => 'https://atlagit.tech/uploads/sound/atlagitsound.mp3',
//                'click_action' => 'FCM_PLUGIN_ACTIVITY',
                'icon' => 'ic_stat_berichten',
                "image"=>$data["banner"],
                "img_url"=>$data["banner"],
                "picture"=>$data["banner"],
                'color' => '#c41e63',
                'iconColor' => '#c41e63',
                "msgcnt"=>1,
            ],
            'priority' => 1,
        );
        if ($extdata) {
            $fields['data'] = $extdata;
        }

//        dump($fields);exit;
        return $this->useCurl($url, $headers, json_encode($fields));
    }

    public static function sendMessage($title, $body, $to, $data = [], $priority = 'high')
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
//        $url = 'https://fcm.googleapis.com/v1/projects/campaign-d34ce/messages:send';
        $fields = [
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
                'click_action' => 'FCM_PLUGIN_ACTIVITY',
                'icon' => 'fcm_push_icon'
            ],
            'to' => $to,
            'priority' => $priority
        ];

        if ($data) {
            $fields['data'] = $data;
        }
        $fields = json_encode($fields);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization:key=' . self::$API_ACCESS_KEY,
        ));
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
//        dump($result);exit;
        return $result;
    }


}
