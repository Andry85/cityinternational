<?php
/**
 * HOW IT WORKS: THE FLOW
 * ============================================================================
 * The flow is like this:
 *
 * - Client-side, data is gathered, json-encoded, and POSTed under the key
 *   'data' (along with the property 'action').
 *
 *   (Note: the 'action' string must be the ACTION class const.)
 *   
 * - Server-side, an AjaxHandler subclass is defined (with the
 *   necessary abstract methods defined).
 *   
 *   The AjaxHandler subclasses's static init() method is called just after its
 *   definition.
 *
 *   The most interesting/important abstract method to define is processData(),
 *   which takes whatever the value of 'data' (decoded from json) and
 *   returns any data (which will then be outputted). If no input data supplied,
 *   or decoding fails, null is passed.
 *
 *   (Note: If you want JSON output, use a JsonAjaxHandler subclass.)
 *
 * - Client-side, we receive the encoded output data returned from processData(),
 *   then we can do whatever with it.
 * 
 * (The above gives an indication of what needs to be implemented afresh.)
 *
 * SUBCLASSES
 * ==============
 * Subclasses *must* define an ACTION const (and implement abstract methods,
 * obvs). ACTION is the name of the WP ajax action.
 *
 * Subclasses *may* define an ADMIN_ONLY const bool (default is false).
 *
 */


namespace IllicitWeb;

use Exception;
use ReflectionClass;

abstract class AjaxHandler
{
    abstract protected function processData($input_data);

    const POST_KEY_DATA = 'data';

    static public function printActionInput($input_id=null)
    {
        ?>
        <input type="hidden"<?php
            if ($input_id):
                ?> id="<?= $input_id ?>"<?php
            endif ?> name="action" value="<?= self::getActionName() ?>">
        <?php
    }

    final static public function init()
    {
        $action = self::getActionName();
        $class = get_called_class();
        $main = $class.'::main';

        add_action("wp_ajax_$action", $main);

        if (!self::isAdminOnly())
        {
            add_action("wp_ajax_nopriv_$action", $main);
        }
    }

    static public function main()
    {
        $instance = new static();
        $input = self::getInputData();
        static::sendOutput($instance->processData($input));
        die;
    }

    static private function getClassConstant($name)
    {
        $reflector = new ReflectionClass(get_called_class());
        return $reflector->getConstant($name);
    }

    static private function getActionName()
    {
        return self::getClassConstant('ACTION');
    }

    // Optionally override this. Must return bool.
    static private function isAdminOnly()
    {
        return (bool)self::getClassConstant('ADMIN_ONLY');
    }

    static protected function sendOutput($data)
    {
        echo $data;
        die;
    }

    static private function getInputData()
    {
        $key = self::POST_KEY_DATA;

        if (empty($_POST[$key]))
        {
            return null;
        }

        assert(is_string($_POST[$key]), 
            "Expected \$_POST['$key'] to be string, got ".gettype($_POST[$key]).
            "\n\n".json_encode($_POST[$key], JSON_PRETTY_PRINT));

        return json_decode(stripslashes($_POST[$key]), true);
    }
}
