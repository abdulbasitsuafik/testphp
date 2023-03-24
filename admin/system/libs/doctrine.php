<?php
require_once "../vendor/autoload.php";
require_once "../vendor/DoctrineExtentions/DoctrineExtentions.php";
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use DoctrineExtensions\TablePrefix;
use Doctrine\Common\EventManager;
//use Doctrine\DBAL\Types\Type;
class Doctrine {
    function __construct() {
//        Type::addType('mytype', 'My\Project\Types\MyType');
    }

    public function getirEntityManager() {
        $evm = new EventManager;
        $paths = array("../app/Entity");
        $isDevMode = true;

        // the connection configuration
        $dbParams = array(
            'driver'   => vt_driver,
            'host'   => vt_host,
            'user'     => vt_kullaniciadi,
            'password' => vt_sifre,
            'dbname'   => vt_veritabaniadi,
            'charset'  => 'UTF8',
            'driverOptions' => array('1002'=> "SET NAMES 'UTF8' COLLATE 'utf8_general_ci'"),
            'defaultDatabaseOptions' => [
                 'charset' => 'utf8',
                 'collate' => 'utf8_general_ci'
            ]
        );
        $tablePrefix = new TablePrefix(PREFIX);
        $evm->addEventListener(Events::loadClassMetadata, $tablePrefix);

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $entityManager = EntityManager::create($dbParams, $config, $evm);
        return $entityManager;
    }

}
