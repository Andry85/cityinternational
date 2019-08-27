<?php

namespace IllicitWeb;

include THEME_DIR.'setup/debug/exceptions.php';
include THEME_DIR.'setup/debug/logger.php';
include THEME_DIR.'setup/debug/functions.php';
include THEME_DIR.'setup/debug/global_functions.php';


if (!defined('WP_DEBUG') || !WP_DEBUG) return;

set_error_handler(function ($errno, $errstr, $errfile=null, $errline=null, $errcontext=null) {

    $exc_msg = "$errfile [$errline] $errstr";

    if (function_exists('iwerror'))
    {
        iwerror($exc_msg);
    }

    if (!should_throw_error($errno))
    {
        return false;
    }

    switch ($errno)
    {
        case E_USER_NOTICE:
        case E_NOTICE:
            print_out_error($errno, $exc_msg, 'Notice');
            throw new NoticeErrorException($exc_msg);

        case E_USER_WARNING:
        case E_WARNING:
            print_out_error($errno, $exc_msg, 'Warning');
            throw new WarningErrorException($exc_msg);

        case E_USER_ERROR:
            print_out_error($errno, $exc_msg, 'Fatal Error');
            throw new FatalErrorException($exc_msg);

        default:
            return false;
    }
});
