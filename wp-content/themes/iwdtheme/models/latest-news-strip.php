<?php

namespace IllicitWeb;

use WP_Post;
use WP_Query;
use WP_Term;

use DateTime;
use DateInterval;

class LatestNewsStrip
{
    const TRUNCATE_WORD_COUNT = 15;

    // Each of these properties is either null or an array with properties
    // type ("wp"|"fb"|"tw")
    // html
    // truncated
    // url
    // new_tab
    private $tweet;
    private $fbPost;
    private $wpPost;

    public function populate()
    {
        $this->tweet = $this->fetchTweet();
        $this->fbPost = $this->fetchFbPost();
        $this->wpPost = $this->fetchWpPost();
    }

    public function toArray()
    {
        return [$this->wpPost, $this->tweet, $this->fbPost];
    }

    public function getTweet()
    {
        return $this->tweet;
    }

    public function getFbPost()
    {
        return $this->fbPost;
    }

    public function getWpPost()
    {
        return $this->wpPost;
    }

    private function fetchTweet()
    {
        $tweets = get_latest_tweets(1);

        if ($tweets)
        {
            $tweet = $tweets[0];

            assert(is_array($tweet));

            return [
                'type' => 'tw',
                'html' => $tweet['html'],
                'truncated' => $this->htmlToTruncatedText($tweet['html']),
                'url' => get_contact_field('twitter'),
                'new_tab' => true,
            ];
        }

        return null;
    }

    private function fetchFbPost()
    {
        $fb_post = get_latest_facebook_post();

        if (!empty($fb_post->message))
        {
            $html = $fb_post->message;

            assert(is_string($html));

            return [
                'type' => 'fb',
                'html' => $html,
                'truncated' => $this->htmlToTruncatedText($html),
                'url' => get_contact_field('facebook'),
                'new_tab' => true,
            ];
        }

        return null;
    }

    private function fetchWpPost()
    {
        $post = Post::fromLatestOne();

        if ($post)
        {
            $html = $post->content();

            return [
                'type' => 'wp',
                'html' => $html,
                'truncated' => $this->htmlToTruncatedText($html),
                'url' => $post->link(),
                'new_tab' => false,
            ];
        }

        return null;
    }

    private function htmlToTruncatedText($html)
    {
        return truncate(strip_tags($html), self::TRUNCATE_WORD_COUNT);
    }
}
