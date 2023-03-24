<?php
class Panel extends Controller{
    public function __construct() {
        parent::__construct();        
        // Oturum Kontrolü
        Session::checkSession();        
    }
    public function index(){
         header('location: '."../headlines/liste");
    } 
    public function anasayfa(){
        // Load the Google API PHP Client Library.
            require_once '../vendor/autoload.php';
            $analytics = $this->initializeAnalytics();
            $profile = $this->getFirstProfileId($analytics);
            $results = $this->getResults($analytics, $profile);
            $browsers = $this->getBrowsers($analytics, $profile);
            $operationSystem = $this->getOperatingSystem($analytics, $profile);
            $Keywords = $this->getSearchWords($analytics, $profile);
            $referer = $this->getReferrers($analytics, $profile);
            $pagepath = $this->getPagePath($analytics, $profile);
            $pageexitpath = $this->getexitPagePath($analytics, $profile);
            $city = $this->getCity($analytics, $profile);
            $country = $this->getCountry($analytics, $profile);
            $data["results"] = $results;
            $data["browsers"] = $browsers;
            $data["system"] = $operationSystem;
            $data["keywords"] = $Keywords;
            $data["referer"] = $referer;
            $data["pagepath"] = $pagepath;
            $data["pageexit"] = $pageexitpath;
            $data["city"] = $city;
            $data["country"] = $country;
            
        $this->load->view("panel/header");
        $this->load->view("panel/anasayfa",$data);
        $this->load->view("panel/footer");           

        }
        
        /*
         * https://developers.google.com/analytics/devguides/reporting/core/dimsmets#cats=traffic_sources
         */
        public function initializeAnalytics()
        {
          // Creates and returns the Analytics Reporting service object.

          // Use the developers console and download your service account
          // credentials in JSON format. Place them in this directory or
          // change the key file location if necessary.
          $KEY_FILE_LOCATION = '../vendor/analytic-account.json';

          // Create and configure a new client object.
          $client = new Google_Client();
          $client->setApplicationName("Hello Analytics Reporting");
          $client->setAuthConfig($KEY_FILE_LOCATION);
          $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
          $analytics = new Google_Service_Analytics($client);

          return $analytics;
        }

        public function getFirstProfileId($analytics) {
          // Get the user's first view (profile) ID.

          // Get the list of accounts for the authorized user.
          $accounts = $analytics->management_accounts->listManagementAccounts();

          if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();

            // Get the list of properties for the authorized user.
            $properties = $analytics->management_webproperties
                ->listManagementWebproperties($firstAccountId);

            if (count($properties->getItems()) > 0) {
              $items = $properties->getItems();
              $firstPropertyId = $items[0]->getId();

              // Get the list of views (profiles) for the authorized user.
              $profiles = $analytics->management_profiles
                  ->listManagementProfiles($firstAccountId, $firstPropertyId);

              if (count($profiles->getItems()) > 0) {
                $items = $profiles->getItems();

                // Return the first view (profile) ID.
                return $items[0]->getId();

              } else {
                throw new Exception('No views (profiles) found for this user.');
              }
            } else {
              throw new Exception('No properties found for this user.');
            }
          } else {
            throw new Exception('No accounts found for this user.');
          }
        }
        
        public function getResults($analytics, $profileId) {
          // Calls the Core Reporting API and queries for the number of sessions
          $optParams= array(
             'dimensions'=> 'ga:date',
             'metrics'=> 'ga:sessions,ga:pageviews,ga:visits'
            );
          // for the last seven days.
           return $analytics->data_ga->get(
               'ga:' . $profileId,
               '14daysAgo',
               'today',
               'ga:sessions',$optParams);
        }
        
        /**
        * Get Browsers for given period
        *
        */
        public function getBrowsers($analytics, $profileId){
           // Calls the Core Reporting API and queries for the number of sessions
          $optParams= array(
             'dimensions'=> 'ga:browser,ga:browserVersion',
             'metrics'=> 'ga:visits,ga:pageviews',
             'sort'       => 'ga:visits'
            );
          // for the last seven days.
           return $analytics->data_ga->get(
               'ga:' . $profileId,
               '30daysAgo',
               'today',
               'ga:sessions',$optParams);
        }
        
        /**
        * Get Operating System for given period
        *
        */
        public function getOperatingSystem($analytics, $profileId){
             // Calls the Core Reporting API and queries for the number of sessions
          $optParams= array(
             'dimensions'=> 'ga:operatingSystem',
             'metrics'=> 'ga:visits,ga:pageviews',
             'sort'       => 'ga:visits'
            );
          // for the last seven days.
           return $analytics->data_ga->get(
               'ga:' . $profileId,
               '30daysAgo',
               'today',
               'ga:sessions',$optParams);
        }
        
        /**
        * Get search words for given period
        *
        */
        public function getSearchWords($analytics, $profileId){
            $optParams= array(
             'dimensions'=> 'ga:keyword',
             'metrics'=> 'ga:visits,ga:pageviews',
             'sort'       => 'ga:keyword'
            );
          // for the last seven days.
           return $analytics->data_ga->get(
               'ga:' . $profileId,
               '30daysAgo',
               'today',
               'ga:sessions',$optParams);
        }
        
        /**
        * Get referrers for given period
        *
        */
        public function getReferrers($analytics, $profileId){
             $optParams= array(
             'dimensions'=> 'ga:source',
             'metrics'=> 'ga:visits,ga:pageviews',
             'sort'       => 'ga:source'
            );
          // for the last seven days.
           return $analytics->data_ga->get(
               'ga:' . $profileId,
               '30daysAgo',
               'today',
               'ga:sessions',$optParams);
        }
        
        /**
        * Get referrers for given period
        *
        */
        public function getPagePath($analytics, $profileId){
             $optParams= array(
             'dimensions'=> 'ga:pagePath',
             'metrics'=> 'ga:visits,ga:pageviews',
             'sort'       => 'ga:pagePath'
            );
          // for the last seven days.
           return $analytics->data_ga->get(
               'ga:' . $profileId,
               '30daysAgo',
               'today',
               'ga:sessions',$optParams);
        }
        
        /**
        * Get referrers for given period
        *
        */
        public function getexitPagePath($analytics, $profileId){
             $optParams= array(
             'dimensions'=> 'ga:exitPagePath',
             'metrics'=> 'ga:visits,ga:pageviews',
             'sort'       => 'ga:exitPagePath'
            );
          // for the last seven days.
           return $analytics->data_ga->get(
               'ga:' . $profileId,
               '30daysAgo',
               'today',
               'ga:sessions',$optParams);
        }
        
        /**
        * Get referrers for given period
        *
        */
        public function getCity($analytics, $profileId){
             $optParams= array(
             'dimensions'=> 'ga:city',
             'metrics'=> 'ga:visits,ga:pageviews',
             'sort'       => 'ga:city'
            );
          // for the last seven days.
           return $analytics->data_ga->get(
               'ga:' . $profileId,
               '30daysAgo',
               'today',
               'ga:sessions',$optParams);
        }
        
        /**
        * Get referrers for given period
        *
        */
        public function getCountry($analytics, $profileId){
             $optParams= array(
             'dimensions'=> 'ga:country',
             'metrics'=> 'ga:visits,ga:pageviews',
             'sort'       => 'ga:country'
            );
          // for the last seven days.
           return $analytics->data_ga->get(
               'ga:' . $profileId,
               '30daysAgo',
               'today',
               'ga:sessions',$optParams);
        }
        
        
        /**
        * Get visitors for given period
        *
        */
        public function getVisitors(){

            return $this->getData(array( 'dimensions' => 'ga:day',
                                         'metrics'    => 'ga:visits',
                                         'sort'       => 'ga:day'));
        }

        /**
        * Get pageviews for given period
        *
        */
        public function getPageviews(){

            return $this->getData(array( 'dimensions' => 'ga:day',
                                         'metrics'    => 'ga:pageviews',
                                         'sort'       => 'ga:day'));
        }

        /**
        * Get visitors per hour for given period
        *
        */
        public function getVisitsPerHour(){

            return $this->getData(array( 'dimensions' => 'ga:hour',
                                         'metrics'    => 'ga:visits',
                                         'sort'       => 'ga:hour'));
        }        

        /**
        * Get screen resolution for given period
        *
        */
        public function getScreenResolution(){

            $aData = $this->getData(array(   'dimensions' => 'ga:screenResolution',
                                             'metrics'    => 'ga:visits',
                                             'sort'       => 'ga:visits'));

            // sort descending by number of visits
            arsort($aData);
            return $aData;
        }

        public function printResults($results) {
          // Parses the response from the Core Reporting API and prints
          // the profile name and total sessions.
          echo "Toplam oturum sayısı: ".$results[totalsForAllResults]['ga:visits']."<br/>"; 
            echo "Toplam Sayfa Gezintisi : ".$results[totalsForAllResults]['ga:pageviews']."<br/>";
            var_dump($results);
        }
    
}
