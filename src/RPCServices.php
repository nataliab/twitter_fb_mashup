<?php
use ZendServerGateway\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;

/**
 * Class responsible for providing the feed.
 * 
 * My function
 *
 * @example /path/to/example.php How to use this function
 * @example anotherexample.inc This example is in the "examples" subdirectory
 * @author natalia.b
 * @copyright Zend Technologies Ltd.
 *
 */
class RPCServices extends AbstractActionController
{

	/**
	 * Returns the merged FB and Twitter feed
	 * @return JSON formatted data
	 */
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