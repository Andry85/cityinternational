<?php

use IllicitWeb\Logger;

function dwf($msg)
{
    if (\IllicitWeb\logs_enabled())
    {
        $logger = new Logger();
        $logger->info($msg, Logger::TYPE_INFO);
    }
}
