<?php
return array(
    'modules' => array(
        'ZendServerGateway'
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            __DIR__ . '/autoload/{,*.}{global,local}.php',
            __DIR__ . '/{,*.}{global,local}.php'
        ),
        'module_paths' => array(
            './',
            './vendor'
        )
    ),
    'zend_mobile_mashup' => array(
        'facebook' => array(
            'app_id' => 'your-facebook-app-id-here',
            'app_secret' => 'your-facebook-app-secret-here'
        ),
        'twitter' => array(
            'access_token' => array(
                'token' => 'twitter-access-token-here',
                'secret' => 'twitter-access-secret-here'
            ),
            'oauth_options' => array(
                'consumerKey' => 'twitter-consumer-key-here',
                'consumerSecret' => 'twitter-consumer-secret-here'
            )
        ),
        'feed' => array(
            'title' => 'feed title here',
            'description' => 'feed description here',
            'link' => 'some URI where this information lives',
            'feedLink' => 'URI to the feed',
            'author' => array(
                'name' => 'feed author name',
                'uri' => 'URI for author'
            )
        ),
        // This should be the ID of a page for which you want to get activity
        // It's set now for the Zend Technologies page
        // 'facebook_page_id' => 'ID for facebook page you want to use',
        'facebook_page_id' => '633919923'
    )
);
