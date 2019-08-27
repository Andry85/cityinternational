<?php
namespace IllicitWeb;

class ClientDetect
{
	// Returns OS constant (see functions.php for constants)
	static public function getOS()
	{
		static $os;

		if (!isset($os))
		{
			$os = self::determineOS();
		}

		return $os;
	}

	static public function getBrowser()
	{
		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		if (strpos($user_agent, 'Chrome')) return BR_CHROME;
	    if (strpos($user_agent, 'Firefox')) return BR_FIREFOX;
	    if (strpos($user_agent, 'Safari')) return BR_SAFARI;
	    if (strpos($user_agent, 'Edge')) return BR_EDGE;
	    if (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return BR_IE;
	    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return BR_OPERA;

	    return null;
	}

	static private function determineOS()
	{
		static $map = [
			'/win/i' => OS_WINDOWS,
			'/mac/i' => OS_MAC,
			'/android/i' => OS_ANDROID,
			'/blackberry/i' => OS_BLACKBERRY,
			'/linux|ubuntu/i' => OS_LINUX,
			'/iphone|ipod|ipad/i' => OS_IOS,
		];

		$ua = $_SERVER['HTTP_USER_AGENT'];

		foreach ($map as $pattern => $os)
		{
			if (preg_match($pattern, $ua))
			{
				return $os;
			}
		}

		return null;
	}
}
