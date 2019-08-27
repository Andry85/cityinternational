<?php
namespace IllicitWeb;

use Exception;

abstract class JsonAjaxHandler extends AjaxHandler
{
    static protected function sendOutput($data)
    {
        output_json($data);
    }
}
