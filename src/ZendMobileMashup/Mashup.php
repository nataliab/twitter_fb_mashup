<?php

namespace ZendMobileMashup;

use Zend\Feed\Writer\Feed as FeedWriter;
use ZendService\Twitter\Twitter;

class Mashup
{
    protected $facebook;
    protected $facebookPageId;
    protected $feed;
    protected $twitter;

    public function __construct(
        FeedWriter $feed,
        Twitter $twitter,
        Facebook $facebook,
        $facebookPageId
    ) {
        $this->feed           = $feed;
        $this->twitter        = $twitter;
        $this->facebook       = $facebook;
        $this->facebookPageId = $facebookPageId;
    }

    public function getFeed()
    {
        $stream = $this->getMergedStream();

        foreach ($stream as $item) {
            $entry = $this->feed->createEntry();

            $entry->setTitle($item['title']);
            $entry->setLink($item['link']);
            $entry->addAuthor($item['author']);
            $entry->setDateCreated($item['date_created']);
            $entry->setDateModified($item['date_modified']);
            $entry->setDescription($item['description']);
            $entry->setContent($item['content']);

            $this->feed->addEntry($entry);
        }

        return $this->feed;
    }

    protected function getMergedStream()
    {
        $facebook = $this->getFacebookStream();
        $twitter  = $this->getTwitterStream();
        $merged   = array_merge($facebook, $twitter);

        // sort by time (newest first)
        usort($merged, function ($a, $b) {
            if ($a['date_created'] == $b['date_created']) {
                return 0;
            }
            return ($a['date_created'] < $b['date_created']) ? 1 : -1;
        });

        // Return only 25 newest
        return array_slice($merged, 0, 25);
    }

    protected function getFacebookStream()
    {
        $data   = $this->facebook->fetchPage($this->facebookPageId);
        $parsed = array();
        foreach ($data as $item) {
            $content = '';
            if (isset($item['story'])) {
                $content = $item['story'];
            } elseif (isset($item['message'])) {
                $content = $item['message'];
            }

            $parsed[] = array(
                'title'         => $content,
                'link'          => sprintf('https://www.facebook.com/%s', $item['id']),
                'author'        => array(
                    'name' => $item['from']['name'],
                    'uri'  => sprintf('https://www.facebook.com/people/@/%s', $item['from']['id']),
                ),
                'date_created'  => strtotime($item['created_time']),
                'date_modified' => strtotime($item['updated_time']),
                'description'   => $content,
                'content'       => $content,
            );
        }
        return $parsed;
    }

    protected function getTwitterStream()
    {
        $response = $this->twitter->statuses->homeTimeline();
        if (!$response->isSuccess()) {
            throw new \Exception('Unable to fetch user timeline from Twitter: ' . var_export($response, 1));
        }

        $parsed = array();
        foreach ($response->toValue() as $tweet) {
            $parsed[] = array(
                'title'         => $tweet->text,
                'link'          => sprintf('https://twitter.com/%s/status/%s', $tweet->user->screen_name, $tweet->id_str),
                'author'        => array(
                    'name' => $tweet->user->name,
                    'uri'  => $tweet->user->url,
                ),
                'date_created'  => strtotime($tweet->created_at),
                'date_modified' => strtotime($tweet->created_at),
                'description'   => $tweet->text,
                'content'       => $tweet->text,
            );
        }
        return $parsed;
    }
}
