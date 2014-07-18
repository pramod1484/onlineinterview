<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initResources ()
    {
        $view = new Zend_View();
        $view->addHelperPath('ZendX/JQuery/View/Helper/', 
                'ZendX_JQuery_View_Helper');
        
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
    }

    /**
     * Initialize Doctrine
     * 
     * @return Doctrine_Manager
     */
    public function _initDoctrine ()
    {
        // include and register Doctrine's class loader
        require_once ('Doctrine/Common/ClassLoader.php');
        $classLoader = new \Doctrine\Common\ClassLoader('Doctrine', 
                APPLICATION_PATH . '/../library/');
        $classLoader->register();
        
        // create the Doctrine configuration
        $config = new \Doctrine\ORM\Configuration();
        
        // setting the cache ( to ArrayCache. Take a look at
        // the Doctrine manual for different options ! )
        $cache = new \Doctrine\Common\Cache\ArrayCache();
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        
        $useSimpleAnnotationReader = FALSE;
        // choosing the driver for our database schema
        // we'll use annotations
        $driver = $config->newDefaultAnnotationDriver(
                array(
                        APPLICATION_PATH . '/../library/ANSH/Shared/Model/Entity'
                ), $useSimpleAnnotationReader);
        
        $config->setMetadataDriverImpl($driver);
        // set the proxy dir and set some options
        $config->setProxyDir(
                APPLICATION_PATH . '/../library/ANSH/Shared/Model/Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setProxyNamespace('App\Proxies');
        $eventManager = new Doctrine\Common\EventManager();
        // now create the entity manager and use the connection
        // settings we defined in our application.ini
        $connectionSettings = $this->getOption('doctrine');
        $conn = array(
                'driver' => $connectionSettings['conn']['driv'],
                'user' => $connectionSettings['conn']['user'],
                'password' => $connectionSettings['conn']['pass'],
                'dbname' => $connectionSettings['conn']['dbname'],
                'host' => $connectionSettings['conn']['host']
        );
        $entityManager = \Doctrine\ORM\EntityManager::create($conn, $config, 
                $eventManager);
        
        // push the entity manager into our registry for later use
        $registry = Zend_Registry::getInstance();
        $registry->entityManager = $entityManager;
        
        return $entityManager;
    }
}
