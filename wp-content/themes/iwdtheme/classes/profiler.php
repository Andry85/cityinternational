<?php
/**

Example usage:
------------------

	$stop = Profiler::start('Descriptive ID for my code block');

	// Do stuff that we want to monitor...

	$stop();

	Then you'll get (if WP_DEBUG and IW_PROFILE both defined true) the
	timer results printed out to the JS console.

*/

namespace IllicitWeb;

class Profiler
{
	// Array mapping IDs to sub-arrays.
	// Each subarray is num array of { start, end } microtimes.
	static private $timers = [];

	static public function start($id)
	{
		if (!isset(self::$timers[$id]))
		{
			self::$timers[$id] = [];
		}
		
		$stop_fn = function () use ($id) {
			self::stop($id);
		};

		self::$timers[$id][] = [microtime(true)];

		return $stop_fn;
	}

	static public function stop($id)
	{
		$index = count(self::$timers[$id]) - 1;

		self::$timers[$id][$index][1] = microtime(true);
	}

	static public function getResultsAsArray()
	{
		$results = [];

		foreach (self::$timers as $id => $timers)
		{
			$result = [
				'times' => [],
			];

			$total = 0;

			foreach ($timers as $times)
			{		
				$start = $times[0];
				$end = $times[1];

				if (!$end)
				{
					continue;
				}

				$delta = $end - $start;

				$result['times'][] = $delta;

				$total += $delta;
			}

			$result['total'] = $total;

			$results[$id] = $result;
		}

		$results = self::sortResults($results);

		return $results;
	}

	static private function formatNumber($n)
	{
		return number_format($n, 8);
	}

	static public function getResultsAsText()
	{
		$results = self::getResultsAsArray();

		if (!$results)
		{
			return null;
		}

		$text = "IllicitWeb Profiler results\n---------------------------\n\n";

		foreach ($results as $id => $result)
		{
			$text .= "$id - Total: ".self::formatNumber($result['total'])."\n";

			if (count($result['times']) > 1)
			{
				foreach ($result['times'] as $index => $delta)
				{
					$text .= "    [$index] ".self::formatNumber($delta)."\n";
				}	
			}
		}

		return $text;
	}

	static public function setupSendResultsToJsConsole()
	{
		if (defined('WP_DEBUG') && WP_DEBUG && defined('IW_PROFILE') && IW_PROFILE)
		{
			add_action('wp_footer', function () {
				
				$text = self::getResultsAsText();

				if ($text)
				{
					$text = addslashes($text);
					$text = preg_replace('/\r\n|\r|\n/', '\\n', $text);
					$text = '\n\n'.$text.'\n\n';
				}
				else
				{
					$text = 'No IllicitWeb profiler results.';
				}

				?>
				<script>
				console.log("<?= $text ?>");
				</script>
				<?php
			});
		}
	}

	
	// Sort in descending order of total execution time
	static private function sortResults(array $results)
	{
		//@fixme this isn't working.
		uasort($results, function ($test_a, $test_b) {
			$delta_a = $test_a['total'];
			$delta_b = $test_b['total'];

			return ($delta_a - $delta_b) * -1;
		});

		// $results are still unsorted (or wrongly sorted) here. @fixme
		
		return $results;
	}
}

Profiler::setupSendResultsToJsConsole();
