<?php
error_reporting(true);
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Version extends Controller{
    public function __construct() {
        parent::__construct();
        // Oturum Kontrolü
        Session::checkSession();
    }

    public function update() {
        try {
            $entityManager = $this->doctrine->getirEntityManager();
            $files = glob('app/Entity/*.php');
            foreach ($files as $key => $value) {
                require_once $value;
                $kirp = str_replace(array("app/Entity/",".php"), array("",""), $value);
                $classes[] = $entityManager->getClassMetadata($kirp,"--force");
                $islenenler[] = $kirp;
            }
            $tool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
            $tool->updateSchema($classes);
            \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);

            $data["islenenler"] = $islenenler;
            $this->view->render("version/update",$data);
        }catch (Exception $e){
            $data["errors"] = $e->getMessage();
            $this->view->render("version/update",$data);
        }

    }


}
