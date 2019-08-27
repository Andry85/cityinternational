<?php

namespace IllicitWeb;

/**
 * - Creates a new log file for each day.
 * - Adds a JavaScript snippet to the wp footer for each message, so that
 *   messages can be read directly.
 *
 */
class Logger
{
	const TYPE_INFO = 0;
	const TYPE_WARNING = 1;
	const TYPE_ERROR = 2;

	// @param {string} $msg
	// @param {int} [$code]
	public function info($msg, $code=null)
	{
        $this->processReport(self::TYPE_INFO, $msg, $code);
	}

	// @param {string} $msg
	// @param {int} [$code]
	public function warn($msg, $code=null)
	{
        $this->processReport(self::TYPE_WARNING, $msg, $code);
	}

	// @param {string} $msg
	// @param {int} [$code]
	public function error($msg, $code=null)
	{
        $this->processReport(self::TYPE_ERROR, $msg, $code);
	}

	// Adds report to the log file and appends it to the footer in a JS snippet.
	// @param {int} $type One of the TYPE_XXX constants
	// @param {string} $msg
	// @param {int|null} $code
	private function processReport($type, $msg, $code)
	{
        $msg = $this->msgToString($msg);
        $this->addFileEntry($type, $msg, $code);
        $this->addFooterEntry($type, $msg, $code);
	}

    // If $msg is not a string, it will be converted to one.
    // @param {mixed} $msg
    // @return {string}
    private function msgToString($msg)
    {
        if (is_string($msg)) 
        {
            return $msg;
        } 
        elseif (is_array($msg) || is_object($msg)) 
        {
            return '['.gettype($msg).'] '.json_encode($msg, JSON_PRETTY_PRINT);
        } 
        elseif (is_bool($msg)) 
        {
            return ($msg ? 'TRUE' : 'FALSE');
        } 
        else
        {
            return (string)$msg;
        }
    }

	// Takes unmodified message, modifies it, appends it to the log file.
	private function addFileEntry($type, $msg, $code)
	{
        $line = $this->createFileEntryText($type, $msg, $code);
        $this->appendLineToFile($line);
	}

	// Takes the message passed to info(), warn() or error(), and adds a type, datetime and linebreak,
	// formats everything nicely, adds in the code, and returns the resulting string.
	// @param {int} $type One of the TYPE_XXX constants
	// @param {string} $msg
	// @param {int|null} $code
	// @return {string}
	private function createFileEntryText($type, $msg, $code)
	{
        $date = date('H:i:s Y-m-d');
        $type_name = $this->typeConstToString($type);
        $code_string = ($code !== null) ? "[$code]" : '';
        $line = "$date $type_name $code_string $msg\n";
        return $line;
	}

    private function typeConstToString($type)
    {
        $map = array(
            self::TYPE_INFO => 'INFO',
            self::TYPE_WARNING => 'WARNING',
            self::TYPE_ERROR => 'ERROR',
        );
        return $map[$type];
    }

	// Appends line of text to log file.
	// @param {string} $line Line of text (inc. line break)
	private function appendLineToFile($line)
	{
        $contents = $this->getLogFileContents().$line;
        $path = self::getLogFilePath();
        file_put_contents($path, $contents);
	}

    // @return {string} Current contents of log file, or empty string if no file
    private function getLogFileContents()
    {
        $path = self::getLogFilePath();
        if (file_exists($path)) {
            return file_get_contents($path);
        } else {
            return '';
        }
    }

	// Takes the message passed to info(), warn() or error(), and adds a type, datetime and linebreak,
	// formats everything nicely, adds in the code, and returns the resulting string.
	// @param {int} $type One of the TYPE_XXX constants
	// @param {string} $msg
	// @param {int|null} $code
	// @return {string}
	private function createFooterEntryText($type, $msg, $code)
	{
        $type_name = $this->typeConstToString($type);
        $code_string = ($code !== null) ? "[$code]" : '';
        $line = "PHP $type_name: $code_string $msg";
        return $line;
	}

	// Adds JavaScript console message as a snippet in the wp footer.
	// @param {int} $type One of the TYPE_XXX constants
	// @param {string} $msg
	// @param {int|null} $code
	private function addFooterEntry($type, $msg, $code)
	{
        $line = $this->createFooterEntryText($type, $msg, $code);
        $line = addslashes($line);
        $func = $this->typeConstToJsConsoleFunc($type);
        add_action('wp_footer', function () use ($func, $line) {

            $line = preg_replace('/\r\n|\r|\n/', '\\n', $line);

            ?>
            <script>
            if (typeof console === 'object') {
                console.<?= $func ?>("<?= $line ?>");
            }
            </script>
            <?php
        });
	}

    private function typeConstToJsConsoleFunc($type)
    {
        $map = array(
            self::TYPE_INFO => 'log',
            self::TYPE_WARNING => 'warn',
            self::TYPE_ERROR => 'error',
        );
        return $map[$type];
    }

	// @return {string} file path to today's log file
	static public function getLogFilePath()
	{
		return LOG_DIR.self::getLogFileBasename();
	}

	// @return {string} file basename to today's log file
	static private function getLogFileBasename()
	{
		return date('Y-m-d').'.log';
	}
}
