<?php
/**
 * @class ClientSizeDetector
 *
 * Provides static method to detect whether on mobile, tablet or desktop.
 *
 * Returns a string (one of the constants defined at the top of the class).
 *
 * "mobile" | "tablet" | "desktop"
 *
 * Result is cached.
 *
 * Dependency: MobileDetect library.
 *
 */

namespace IllicitWeb;

use Exception;

class ClientSizeDetector
{
	const MOBILE = 'mobile';
	const TABLET = 'tablet';
	CONST DESKTOP = 'desktop';

	static public function detect()
	{
		static $client_size;

		if (!isset($client_size))
		{
			$client_size = self::detectFresh();
		}

		return $client_size;
	}

	static private function detectFresh()
	{
		$mobile_detect = new MobileDetect();

		if ($mobile_detect->isTablet())
		{
			return self::TABLET;
		}
		
		if ($mobile_detect->isMobile())
		{
			return self::MOBILE;
		}

		return self::DESKTOP;
	}
}
