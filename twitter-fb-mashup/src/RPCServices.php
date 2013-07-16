<?php
use ZendServerGateway\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\FeedModel;

class RPCServices extends AbstractActionController
{

    public function getGetFeedAction()
    {
        $services = new ServiceManager();
        $services->setService('Config', include 'config/application.config.php');
        $services->setFactory('Mashup', 'ZendMobileMashup\Factory');
        $mashup = $services->get('Mashup');
        $view = new FeedModel();
        $view->setFeed($mashup->getFeed());
        $view->setTerminal(true);
        return $view;
    }
}

?>