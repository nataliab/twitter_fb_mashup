<?php
use ZendServerGateway\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;

class RPCServices extends AbstractActionController
{

    public function getFeedAction()
    {
        $services = new ServiceManager();
        $services->setService('Config', include 'config/application.config.php');
        $services->setFactory('Mashup', 'ZendMobileMashup\Factory');
        $mashup = $services->get('Mashup');
        return $mashup->getMergedStream();
    }
}

?>