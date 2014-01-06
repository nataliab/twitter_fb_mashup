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
						'app_id' => '425446084238355',//'your-facebook-app-id-here',
						'app_secret' => '88cb7f9232a012bd7b2ffc0e652aa7db'//'your-facebook-app-secret-here'
				),
				'twitter' => array(
						'access_token' => array(
								'token' => '245770498-rOpBeaXhD3I98H5XctJKZlzw2huX4utHh3uDdDUO',//twitter-access-token-here',
								'secret' => 'tY2oaIW6oIUQJcayNFJotuvGZfNO7U2xBvLac0x4'//twitter-access-secret-here'
						),
						'oauth_options' => array(
								'consumerKey' => 'xDaZTuqVQq6txs8PeiYWvQ',//twitter-consumer-key-here',
								'consumerSecret' => 'Pna6zdWgoKzv9uwjeuZpSpJhp5JMsyL2ZcjhQMPmao'//twitter-consumer-secret-here'
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
				// It's set now for the NASA page
				// 'facebook_page_id' => 'ID for facebook page you want to use',
				'facebook_page_id' => '57242657138'
		)
);