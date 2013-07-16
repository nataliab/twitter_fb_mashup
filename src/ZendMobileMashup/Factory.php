<?php

namespace ZendMobileMashup;

use Zend\Feed\Writer\Feed;
use Zend\Http\Client as HttpClient;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZendService\Twitter\Twitter;

class Factory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->has('Config') ? $services->get('Config') : array();

        if (!isset($config['zend_mobile_mashup'])) {
            throw new ServiceNotCreatedException('Unable to create MobileMashup; missing configuration');
        }

        $config = $config['zend_mobile_mashup'];
        if (!isset($config['facebook'])
            || !isset($config['twitter'])
            || !isset($config['feed'])
            || !isset($config['facebook_page_id'])
        ) {
            throw new ServiceNotCreatedException('Unable to create MobileMashup; configuration incomplete');
        }

        $facebookConfig = $config['facebook'];
        $twitterConfig  = $config['twitter'];
        $feedConfig     = $config['feed'];
        $facebookPage   = $config['facebook_page_id'];

        $adapter = new HttpClient\Adapter\Curl();
        $client  = new HttpClient();
        $client->setAdapter($adapter);

        $facebook = new Facebook($client, $facebookConfig['app_id'], $facebookConfig['app_secret']);

        $twitterConfig['http_client_options'] = array(
            'adapter' => 'Zend\Http\Client\Adapter\Curl',
            'curloptions' => array(
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
            ),
        );

        $twitter = new Twitter($twitterConfig);

        $feed = new Feed();
        $feed->setTitle($feedConfig['title']);
        $feed->setDescription($feedConfig['description']);
        $feed->setLink($feedConfig['link']);
        $feed->setFeedLink($feedConfig['feedLink'], 'rss');
        $feed->addAuthor($feedConfig['author']);
        $feed->setDateModified(time());

        return new Mashup($feed, $twitter, $facebook, $facebookPage);
    }
}
