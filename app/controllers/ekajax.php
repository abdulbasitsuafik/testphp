<?php
class ekajax extends Controller{
    public function __construct() {
        parent::__construct();
        $this->islemController = $this->load->controllers("islemler");
    }
    public function sqlSorgu($sql,$array){
        $model = $this->load->model("index_model");
        return $model->sqlSorgu($sql,$array);       
    }
    public function kontrol() { 
        $entityManager = $this->doctrine->getirEntityManager(); 
        $files = glob('admin/app/Entity/*.php');
        foreach ($files as $key => $value) {    
            require_once $value;
        }

        /*$veri = $entityManager->getRepository('headlines');
        $databases = $veri->findAll(); 
        $data["gelen"] =  $databases;

        //$headlines = $entityManager->getRepository('headlines')->findBy(array("id" => "1"));

        $headlines = $entityManager->getRepository('headlines')
        ->createQueryBuilder("id")
        ->where('id = 1')
        ->getQuery()
        ->getResult();
        */
        $qb = $entityManager->createQueryBuilder();
        $deneme7 = $qb->select('a')
        ->from('headlines', 'a')
        ->where('a.id = :id')
        ->setParameter(":id", 1)
        ->orderBy('a.id', 'ASC')
        ->getQuery()
        ->getResult();
        /*
        $qb = $entityManager->createQueryBuilder("a");
        $deneme8 = $qb->select("a")
        ->from('headlines', 'a')
        //->Join('headlines_langs', 'b',"ON","a.id = b.head_id")
        //->orderBy('b.head_id', 'ASC')
        ->getQuery()
        ->getResult();


        $conn = $this->doctrine->dbConnect(); 
        $queryBuilder = $conn->createQueryBuilder();
        $deneme= $queryBuilder
            ->select()
            ->from('headlines')
            ->where('id = :id')
            ->setParameter(":id", 1);
            //->getQuery()
            //->getResult();

        $sql = "SELECT * FROM ".PREFIX."headlines";
        $stmt = $conn->executeQuery($sql); // Simple, but has several drawbacks

        //$query = $entityManager->createQuery("SELECT * FROM namespaceTestBundle:Test test");
        //$tests = $query->getArrayResult();
        */

        echo "<pre>";
        //print_r($stmt->fetch());
        print_r($deneme7);
        echo "</pre>";
        //$this->load->view("panel/header");
        //$this->load->view("panel/versiyon/kontrol", $data);
        //$this->load->view("panel/footer");
    }
}