<?php

namespace IllicitWeb;

use Exception;

abstract class ErrorException extends Exception {}
class WarningErrorException extends ErrorException {}
class FatalErrorException extends ErrorException {}
class NoticeErrorException extends ErrorException {}
