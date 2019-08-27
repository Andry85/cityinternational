<?php

namespace IllicitWeb;

use Exception;

class UrlBuilder
{
	const DEFAULT_PROTOCOL = 'http';

	private $protocol; // string, e.g. 'http'

	private $domainComponents; // string[] e.g. ['www', 'example', 'com']

	private $port; // int or null

	private $pathComponents; // string[]

	private $queryArgs; // assoc array of key value pairs

	private $fragment; // string (exc #) or null

	public function __construct($url = null)
	{
		$this->clear();

		if ($url !== null)
		{
			$this->setFromString($url);
		}
	}

	public function setFromCurrent()
	{
		$this->setFromString($this->getCurrentUrl());
	}

	private function getCurrentUrl()
	{
		return base_domain().$_SERVER['REQUEST_URI'];
	}

	public function setFromString($url)
	{
		$this->enforceString($url);
		
		$protocol = $this->extractProtocol($url);

		if ($protocol !== null)
		{
			$this->protocol = $protocol;
		}

		$domain = $this->extractDomain($url);

		if ($domain !== null)
		{
			$this->domainComponents = $this->splitDomain($domain);
		}

		$this->port = $this->extractPort($url);

		$path = $this->extractPath($url);

		if ($path)
		{
			$this->pathComponents = $this->splitPath($path);
		}

		$query_string = $this->extractQueryString($url);

		if ($query_string !== null)
		{
			$this->queryArgs = $this->parseQueryString($query_string);
		}

		$fragment = $this->extractFragment($url);

		if ($fragment !== null)
		{
			$this->fragment = $fragment;
		}
	}

	public function clear()
	{
		$this->protocol = static::DEFAULT_PROTOCOL;

		$this->domainComponents = [];

		$this->port = null;

		$this->pathComponents = [];

		$this->queryArgs = [];

		$this->fragment = null;
	}

	public function addQueryArg($key, $value)
	{
		$this->queryArgs[$key] = $value;
	}

	public function addPathComponent($path_component)
	{
		$this->enforceString($path_component);

		$this->pathComponents[] = $path_component;
	}

	// Returns string
	public function buildUrl()
	{
		$domain = $this->buildDomain();

		if ($domain)
		{
			$url = $this->protocol.'://'.$domain;

			if ($this->port)
			{
				$url .= ':'.$this->port;
			}

			$url .= '/';
		}
		else
		{
			$url = '';
		}

		$path = $this->buildPath();

		if ($path)
		{
			if ($url)
			{
				$url .= $this->removeLeadingSlash($path);
			}
			else
			{
				$url = $path;
			}
		}

		$query_string = $this->buildQueryString();

		if ($query_string !== null)
		{
			$url .= '?'.$query_string;
		}

		if ($this->fragment !== null)
		{
			$url .= '#'.$this->fragment;
		}

		return $url;
	}

	private function addLeadingSlash($s)
	{
		if (!$this->hasLeadingSlash($s))
		{
			$s = '/'.$s;
		}

		return $s;	
	}

	private function addTrailingSlash($s)
	{
		if (!$this->hasTrailingSlash($s))
		{
			$s .= '/';
		}

		return $s;
	}

	private function hasLeadingSlash($s)
	{
		return (preg_match('/^\//', $s) === 1);
	}

	private function hasTrailingSlash($s)
	{
		return (preg_match('/\/$/', $s) === 1);
	}

	private function removeLeadingSlash($s)
	{
		return preg_replace('/^\/+/', '', $s);
	}

	private function removeTrailingSlash($s)
	{
		return preg_replace('/\/+$/', '', $s);
	}

	public function __toString()
	{
		return $this->buildUrl();
	}

	public function getProtocol()
	{
		return $this->protocol;
	}

	public function getDomainComponents()
	{
		return $this->getDomainComponents;
	}

	public function getDomainName()
	{
		return $this->buildDomain();
	}

	public function getPort()
	{
		return $this->port;
	}

	public function getPathComponents()
	{
		return $this->pathComponents;
	}

	public function getPath()
	{
		return $this->buildPath();
	}

	public function getQueryArgs()
	{
		return $this->queryArgs;
	}

	public function getQueryArg($key)
	{
		$args = $this->queryArgs;
		return isset($args[$key]) ? $args[$key] : null;
	}

	// No leading question mark
	public function getQueryString()
	{
		return $this->buildQueryString();
	}

	// No leading hash
	public function getFragment()
	{
		return $this->fragment;
	}

	private function extractProtocol($url)
	{
		$matches = [];

		$regex_result = preg_match('/^([a-z]+)\:\/\//i', $url, $matches);

		if ($regex_result !== 1)
		{
			return null;
		}

		if (!isset($matches[1]))
		{
			return null;
		}

		return strtolower($matches[1]);
	}

	private function extractDomain($url)
	{
		$matches = [];

		$regex_result = preg_match('/^([a-z]+\:\/\/)?([a-z0-9\.\-]+\.[a-z0-9\.\-]+)/i', $url, $matches);

		if ($regex_result !== 1)
		{
			return null;
		}

		if (!isset($matches[2]))
		{
			return null;
		}

		return $matches[2];
	}

	private function splitDomain($domain)
	{
		return explode('.', $domain);
	}

	private function extractPort($url)
	{
		$matches = [];

		$regex_result = preg_match('/^([a-z]+\:\/\/)?([a-z0-9\.\-]+)\:(\d+)/i', $url, $matches);

		if ($regex_result !== 1)
		{
			return null;
		}

		if (!isset($matches[3]))
		{
			return null;
		}

		$port = (int)$matches[3];

		if ($port <= 0)
		{
			return null;
		}

		return $port;
	}

	// Duplicate slashes removed.
	private function extractPath($url)
	{
		$path = $this->removeDomain($url); // Remove protocol & domain

		$path = explode('?', $path)[0]; // Remove any query

		$path = explode('#', $path)[0]; // Remove any fragment

		$path = preg_replace('/\/{2,}/', '/', $path); // Remove dupe slashes

		return $path;
	}

	private function removeProtocol($url)
	{
		return preg_replace('/^([a-z]+\:\/\/)/i', '', $url);
	}

	// Retains leading slashes.
	// Protocol and port removed if present.
	private function removeDomain($url)
	{
		return preg_replace('/^([a-z]+\:\/\/)?([a-z0-9\.\-]+\.[a-z0-9\.\-]+)(\:\d*)?/i', '', $url);
	}

	private function splitPath($path)
	{
		if ($path === '')
		{
			return [];
		}

		$components = array_filter(
			preg_split('/\/+/', trim($path, '/')), 
			function ($component) { return $component !== ''; }
		);

		if ($this->hasLeadingSlash($path))
		{
			$components[0] = '/'.$components[0];
		}

		if ($this->hasTrailingSlash($path))
		{
			$last_index = count($components) - 1;
			$components[$last_index] .= '/';
		}

		return $components;
	}

	private function extractQueryString($url)
	{
		$matches = [];

		$regex_result = preg_match('/\?([^\#]+)/i', $url, $matches);

		if ($regex_result !== 1)
		{
			return null;
		}

		if (!isset($matches[1]))
		{
			return null;
		}

		return trim($matches[1]);
	}

	private function parseQueryString($query_string)
	{
		$array = [];

		parse_str($query_string, $array);

		return $array;
	}

	private function extractFragment($url)
	{
		$matches = [];

		$regex_result = preg_match('/\#(.+)$/i', $url, $matches);

		if ($regex_result !== 1)
		{
			return null;
		}

		if (!isset($matches[1]))
		{
			return null;
		}

		return trim($matches[1]);
	}

	private function buildDomain()
	{
		if (!$this->domainComponents)
		{
			return null;
		}

		return implode('.', $this->domainComponents);
	}

	private function buildPath()
	{
		if (!$this->pathComponents)
		{
			return null;
		}

		return implode('/', $this->pathComponents);
	}

	private function buildQueryString()
	{
		if (!$this->queryArgs)
		{
			return null;
		}

		$query_string = http_build_query($this->queryArgs);

		$query_string = trim($query_string, '=&');

		return $query_string;
	}

	private function enforceString($s)
	{
		if (!is_string($s))
		{
			throw new Exception('Expected string, got '.gettype($s));
		}
	}
}
