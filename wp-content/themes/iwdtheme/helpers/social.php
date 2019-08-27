<?php

namespace IllicitWeb;

// @return {array} Tweet assocs
function get_latest_tweets($num=2)
{
	if (function_exists('IllicitWeb\\Twitter\\get_latest_tweets_html')) 
	{
		return \IllicitWeb\Twitter\get_latest_tweets_html($num);
	}

	trigger_error('No IllicitWeb\\Twitter\\get_latest_tweets_html() func');

	return [];
}

// @return {string} Twitter user screen name, as specified in Twitter plugin
// config. Empty string on fail.
function get_twitter_screenname_as_link()
{
	if (function_exists('IllicitWeb\\Twitter\\get_screen_name')) 
	{
		$name = \IllicitWeb\Twitter\get_screen_name();
		if (!$name)
		{
			return '';
		}

		$url = 'https://twitter.com/'.$name;
	
		return '<a target="_blank" href="'.$url.'">@'.$name.'</a>';
	}

	trigger_error('No IllicitWeb\\Twitter\\get_latest_tweets_html() func');

	return '';
}

// @return {array|null} FB post assoc or null on fail
function get_latest_facebook_post()
{
	if (function_exists('IllicitWeb\\Facebook\\get_latest_post')) 
	{
		return \IllicitWeb\Facebook\get_latest_post();
	}

	trigger_error('No IllicitWeb\\Facebook\\get_latest_post() func');
	
	return null;
}
