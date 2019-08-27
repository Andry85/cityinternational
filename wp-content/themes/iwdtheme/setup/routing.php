<?php
/**
 * You can add routes in the setup/routes.php file.
 * 
 */

namespace IllicitWeb;

class Routing
{
	static public function init()
	{
		self::setupInitAction();

		self::registerRoutes();
	}

	// URL template strings mapped to funcs
	static private $registry = [];

	static private function setupInitAction()
	{
		add_action('init', function () {

			self::callRouteForUrl($_SERVER['REQUEST_URI']);

		}, 1000, 0);
	}

	static private function callRouteForUrl($url)
	{
		$route_data = self::getRouteDataForUrl($url);

		if (!$route_data)
		{
			return;
		}

		$result = call_user_func($route_data['fn'], $route_data['args']);

		if (is_array($result))
		{
			self::jsonHeaders();
			echo json_encode($result);
			die;
		}

		if ($result !== false)
		{
			die;
		}
	}

	static private function getRouteDataForUrl($url)
	{
		if (isset(self::$registry[$url]))
		{
			return [
				'fn' => self::$registry[$url],
				'args' => [],
			];
		}

		foreach (self::$registry as $url_template => $route_func)
		{
			$args = self::getUrlArgsForTemplate($url, $url_template);

			if ($args !== null)
			{
				return [
					'fn' => $route_func,
					'args' => $args,
				];
			}
		}
	}

	static private function getUrlArgsForTemplate($url, $url_template)
	{
		$url_components = self::getUrlComponents($url);

		$template_components = self::getTemplateComponents($url_template);

		$num_template_components = count($template_components);

		if (count($url_components) > $num_template_components)
		{
			// No match
			return null;
		}

		$url_args = [];

		for ($index = 0; $index < $num_template_components; ++$index)
		{
			$template_component = $template_components[$index];

			$var_name = self::extractVarNameFromTemplateComponent($template_component);

			if (!isset($url_components[$index]))
			{
				if (self::templateComponentIsOptional($template_component))
				{
					// Missing optional URL component
					$url_args[$var_name] = null;

					continue;
				}
				else
				{
					// Missing required URL component; no match
					return null;
				}
			}

			$url_component = $url_components[$index];

			if (self::templateComponentIsVariable($template_component))
			{
				$url_args[$var_name] = $url_component;
			}
			elseif ($url_component !== $template_component)
			{
				// No match
				return null;
			}
		}

		return $url_args;
	}

	static private function extractVarNameFromTemplateComponent($template_component)
	{
		return trim($template_component, ':?');
	}

	static private function templateComponentIsVariable($template_component)
	{
		return strpos($template_component, ':') === 0;
	}

	static private function templateComponentIsOptional($template_component)
	{
		return strpos($template_component, '?') === (strlen($template_component) - 1);
	}

	static private function getUrlComponents($url)
	{
		$url = explode('?', $url)[0];
		
		$url = trim($url, '/');

		return preg_split('/\/+/', $url);
	}

	static private function getTemplateComponents($url_template)
	{
		$url_template = trim($url_template, '/');

		return preg_split('/\/+/', $url_template);	
	}

	static private function registerRoutes()
	{
		$routes = config('routes');

		foreach ($routes as $url => $route)
		{
			self::registerRoute($url, $route);
		}
	}

	static private function registerRoute($url, $route)
	{
		$route_func = self::makeRouteCallable($route);
		
		if ($route_func)
		{
			self::$registry[$url] = $route_func;
		}
	}

	// $route is either a func or an include file path.
	// If a func, is returned unchanged.
	// A warning is emitted and null is returned if the file path is invalid.
	static private function makeRouteCallable($route)
	{
		if (is_callable($route))
		{
			return $route;
		}

		return self::filePathToCallable($route);
	}

	// A warning is emitted and null is returned if the file path is invalid.
	static private function filePathToCallable($route)
	{
		if (!is_file($route))
		{
			trigger_error(
				"Route include does not exist: $route",
				E_USER_WARNING
			);

			return null;
		}

		return function ($args = []) use ($route) {
			include $route;
		};
	}

	static private function jsonHeaders()
	{
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
	}
}

Routing::init();
