<?php
namespace IllicitWeb;

function json_headers()
{
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
}

function is_https()
{
	return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
		($_SERVER['SERVER_PORT'] == 443));
}

function http_protocol()
{
	return is_https() ? 'https://' : 'http://';
}

// Returns base domain with no trailing slash
function base_domain()
{
	$http_host = preg_replace('/\/+$/', '', $_SERVER['HTTP_HOST']);

	return http_protocol().$http_host;
}

function curr_url() 
{
	static $url;

	if (!isset($url)) 
	{
		$url = base_domain().$_SERVER['REQUEST_URI'];
	}

	return $url;
}

function curr_url_no_query_string()
{
	$url = curr_url();

	return explode('?', $url)[0];
}

function curr_url_components()
{
	return get_url_components($_SERVER['REQUEST_URI']);
}

function get_url_components($url)
{
	$url = explode('?', $url)[0];
	$url = trim($url, '/');
	return preg_split('/\/+/', $url);
}
