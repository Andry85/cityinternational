<?php

namespace IllicitWeb;

// @return {bool} Whether logs are enabled (see notes on Global functions)
function logs_enabled()
{
	static $enabled;

	if (!isset($enabled)) 
	{
		if (defined('IW_ENABLE_LOGS')) 
		{
			$enabled = IW_ENABLE_LOGS;
		} 
		elseif (defined('WP_DEBUG')) 
		{
			$enabled = WP_DEBUG;
		} 
		else 
		{
			$enabled = false;
		}
	}
	
	return $enabled;
}

function create_log_dir()
{
	if (!is_dir(LOG_DIR))
	{
		$ok = mkdir(LOG_DIR, 0770);

		if (!$ok)
		{
			throw new \Exception("Failed to create log dir at ".LOG_DIR);
		}
	}
}

if (logs_enabled())
{
	ini_set('error_log', Logger::getLogFilePath());
	create_log_dir();
}

function client_is_dev()
{
    if (empty($_SERVER['REMOTE_ADDR']))
    {
        return false;
    }

    $ip = $_SERVER['REMOTE_ADDR'];

    $patterns = ['192.168.', '127.0.0.1', '89.240.15.41'];

    foreach ($patterns as $pattern)
    {
    	if (strpos($ip, $pattern) === 0)
    	{
    		return true;
    	}
    }

    return false;
}

function debugging()
{
	return definedtrue('WP_DEBUG');
}

// CF7 form debugging.
// To use this func, call it towards the end of footer.php, and define
// IW_DEBUG_APP_FORM to be true (in wp-config.php) while developing.
function cf7_form_fill_inputs()
{
	if (!debugging() || !definedtrue('IW_DEBUG_APP_FORM'))
	{
		return;
	}

	?>

	<script>

	jQuery(function ($) {


	// CONFIG
	// -------------------------------------------------------------------

	// Array of strings, each string a checkbox input 'name' attr value
	// for required checkboxes. (E.g. a T&C agree checkbox.)
	var requiredCheckboxes = [];


	// Whether email inputs should have a random email address put in them,
	// rather than the same one each time.
	var randomiseEmail = true;



	// -------------------------------------------------------------------



	if ($('form.wpcf7-form').length < 1)
	{
		return;
	}

	console.warn("CF7 form debugging is switched on - form inputs are being filled with junk!");

	var wordsString = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi fringilla finibus elit, a dapibus est tempor et. Curabitur urna sem, aliquet ac velit ac, tempus tempor nunc. Fusce pulvinar sem vel ipsum venenatis sollicitudin. Proin auctor nulla eros, nec semper velit eleifend quis. Donec consectetur et tellus sed sagittis. Suspendisse eu libero porta, pharetra sem ac, posuere dolor. Aliquam suscipit, velit eget tristique venenatis; lorem dui auctor arcu, eget viverra eros est ac magna. Vestibulum in consectetur libero. Fusce rhoncus mauris vitae leo volutpat interdum. Ut quis justo metus. Vestibulum massa ante, varius eget volutpat eget, imperdiet eu ipsum! Sed lorem augue, accumsan ac tempor vitae, suscipit ac nunc. Cras luctus libero dapibus justo pharetra pharetra. Etiam tempor erat eu est efficitur, quis placerat sem cursus? In at mauris ut risus facilisis maximus sed ac nibh! Quisque sodales urna ut augue eleifend, non vestibulum enim tincidunt. Proin sodales, metus quis cursus facilisis, leo sem lobortis ligula, eu tempus arcu orci ut tellus. Fusce sed pretium arcu. Phasellus aliquet nisi non mauris mattis molestie. Duis convallis nunc at convallis consectetur. Sed suscipit porta vehicula. Vivamus leo urna, mollis at lorem id, feugiat feugiat quam. Nam ullamcorper odio sit amet velit suscipit dapibus? Vestibulum eleifend elit non interdum varius. Pellentesque blandit lorem id mollis scelerisque. Praesent in venenatis risus, iaculis viverra felis. Aenean rutrum nunc sed erat luctus, pretium fermentum leo porta. Duis sollicitudin erat et mi mattis viverra. Nam bibendum eget nisl non volutpat.Fusce non sapien odio. Praesent id hendrerit erat, ac tincidunt orci! Etiam id felis in justo iaculis pharetra! Etiam in molestie sem. Sed facilisis purus sit amet enim luctus, nec euismod ante consequat. Etiam eget porttitor lorem. Aliquam mi arcu, efficitur ut erat ut, tempus aliquet nulla. Donec laoreet, ipsum eu ultricies interdum, nisl dui volutpat purus, et convallis sapien dolor id lectus. Sed pulvinar hendrerit ipsum; quis luctus purus lacinia nec. Maecenas id varius leo. In auctor diam neque, eu consectetur diam dapibus at. Maecenas placerat magna sed ex viverra, non euismod tortor vulputate.";
	var allWords = wordsString.toLowerCase().replace(/[^a-z\s\-]/gi, '').split(/\s+/g);

	function randomWords(num)
	{
		var words = [];

		for (var i = 0; i < num; ++i)
		{
			var randIndex = Math.floor(Math.random() * allWords.length);
			words.push(allWords[randIndex]);
		}

		return words.join(' ');
	}

	function getRandomEmail()
	{
		return 'test_' + randomLetters() + '@illicitwebdesign.co.uk';
	}

	function randomLetters()
	{
		var ltrs = 'abcdefghijklmnopqrstuvwxyz0123456789';
		var min = 4;
		var len = Math.round(Math.random() * 10) + min;
		var s = '';
		for (var i = 0; i < len; ++i) {
			var index = Math.floor(Math.random() * ltrs.length);
			s += ltrs[index];
		}
		return s;
	}

	function getRandomInt(lo, hi)
	{
		return Math.floor(Math.random() * (hi - lo)) + lo;
	}

	function val(name, value)
	{
		$('[name="' + name + '"]').val(value);
	}

	var map = {
		surname: 'Testname',
		lastname: 'Testname',
		forename: 'Joe',
		firstname: 'Joe',
		age: getRandomInt(10, 90),
		name: 'Joe Testname',
		tel: '0123 123 123',
		tel1: '0123 123 123',
		tel2: '0345 345 345',
		phone: '0123 123 123',
		phone1: '0123 123 123',
		phone2: '0345 345 345',
		hometel: '0234 234 234',
		mobiletel: '0777 777 777',
		email: randomiseEmail ? getRandomEmail() : 'test@illicitwebdesign.co.uk',
		address: "123 Test Street\nExeter\nDevon",
		address1: "123 Test Street",
		address2: "Exeter",
		address3: "Devon",
		postcode: 'EX3 3AN',
		ninumber: 'AA123456A',
		position: 'Test Job Position'
	};

	function fillEmptyTextAreas()
	{
		$('textarea').each(function () {
			var $inp = $(this);
			var val = $inp.val();
			if (!val)
			{
				var numWords = getRandomInt(5, 50);
				var words = randomWords(numWords);
				$inp.val(capFirstLtr(words) + '.');
			}
		});
	}

	function capFirstLtr(str)
	{
		var ch = str[0].toUpperCase();
		return ch + str.substr(1);
	}

	function fillEmptyTextInputs()
	{
		$('input[type="text"]').each(function () {
			var $inp = $(this);

			var val = $inp.val();
			if (!val)
			{
				if ($inp.attr('name').match(/postcode/i))
				{
					$inp.val('EX' + getRandomInt(0, 9) + ' ' + getRandomInt(0, 9) + 'AA');
				}
				else
				{
					var numWords = getRandomInt(1, 5);
					var words = randomWords(numWords);
					$inp.val(capFirstLtr(words));
				}
			}
		});
	}

	function fillEmptyEmailInputs()
	{
		$('input[type="email"]').each(function () {
			var $inp = $(this);
			var val = $inp.val();
			if (!val)
			{
				var email = randomiseEmail ?
					getRandomEmail() :
					'test@illicitwebdesign.co.uk';
				$inp.val(email);
			}
		});
	}

	function fillEmptyTelInputs()
	{
		$('input[type="tel"]').each(function () {
			var $inp = $(this);
			var val = $inp.val();
			if (!val)
			{
				$inp.val('0123 ' + getRandomInt(100, 999) + ' ' +
						 getRandomInt(100, 999));
			}
		});
	}

	function fillEmptyDateInputs()
	{
		$('input[type="date"]').each(function () {
			var $inp = $(this);
			var val = $inp.val();
			if (!val)
			{
				$inp.val(getRandomInt(1980, 2015) + '-' +
						 getRandomInt(10, 12) + '-' + getRandomInt(10, 28));
			}
		});
	}

	function fillViaMap()
	{
		for (var p in map)
		{
			if (map.hasOwnProperty(p))
			{
				val(p, map[p]);
			}
		}
	}

	function tickRequiredCheckboxes()
	{
		$.each(requiredCheckboxes, function () {
			$('[name="' + this + '"]').prop('checked', true);
		});
	}

	function clearInputs()
	{
		$('form.wpcf7-form')[0].reset();
	}

	function checkSomeCheckables()
	{
		$('input[type="checkbox"], input[type="radio"]').each(function each() {
			var $inp = $(this);
			if (Math.random() >= 0.5)
			{
				$inp.prop('checked', true);
			}
		});
	}

	function ensureAtLeastOneRadioPerGroup()
	{
		var done = [];
		$('input[type="radio"]').each(function each() {
			var $inp = $(this);
			var name = $inp.attr('name');
			if ($.inArray(name, done) >= 0)
			{
				return;
			}
			done.push(name);
			var $checked = $('input[type="radio"][name="' + name + '"]:checked');
			if ($checked.length === 0)
			{
				$inp.prop('checked', true);
			}
		});
	}

	function fillInputs()
	{
		clearInputs();
		fillViaMap();
		tickRequiredCheckboxes();
		fillEmptyTextAreas();
		fillEmptyTextInputs();
		fillEmptyEmailInputs();
		fillEmptyTelInputs();
		fillEmptyDateInputs();
		checkSomeCheckables();
		ensureAtLeastOneRadioPerGroup();
	}

	fillInputs();
	
	$('input').removeAttr('disabled');
});
</script>
<?php
}


// Fills WC checkout form inputs
function wc_debug_fill_checkout_inputs()
{

	if (!defined('WP_DEBUG') || !WP_DEBUG ||
		!defined('IW_WC_DEBUG_INPUTS') || !IW_WC_DEBUG_INPUTS)
	{
		return;
	}

	?>
	<script>
	jQuery(function ($) {

		function randomLetters()
		{
			var ltrs = 'abcdefghijklmnopqrstuvwxyz0123456789';
			var min = 4;
			var len = Math.round(Math.random() * 10) + min;
			var s = '';
			for (var i = 0; i < len; ++i) {
				var index = Math.floor(Math.random() * ltrs.length);
				s += ltrs[index];
			}
			return s;
		}

		function setInputs() {
			if (!$('[name="billing_first_name"]').val()) {
				$('[name="billing_first_name"]').val('Joetest');
				$('[name="billing_last_name"]').val('Ingstest');
				$('[name="billing_email"]').val('test_' + randomLetters() + '@illicitwebdesign.co.uk');
				$('[name="billing_phone"]').val('01234 123 123');
				$('[name="billing_address_1"]').val('123 Fake Street');
				$('[name="billing_address_2"]').val('St Thomas');
				$('[name="billing_city"]').val('Exeter');
				$('[name="billing_state"]').val('Devon');
				$('[name="billing_postcode"]').val('EX4 1EP');
				$('[name="member_user_occupation"]').val('Astronaut');
				$('[name="account_password"]').val('password');
				$('[name="fl-terms"]').prop('checked', true);
			}

			if (!$('#stripe-card-number').val()) {
				$('#stripe-card-number').val('4242424242424242');
				$('#stripe-card-cvc').val('123');
				$('#stripe-card-expiry').val('12/16');
				$('#terms').prop('checked', true);
			}

			if (!$('#s4wc-card-number').val()) {
				$('#s4wc-card-number').val('4242424242424242');
				$('#s4wc-card-cvc').val('123');
				$('#s4wc-card-expiry').val('12/16');
				$('#terms').prop('checked', true);
			}
		}

		for (var i = 0; i < 10; ++i) {
			setTimeout(setInputs, 500 * i);
		}
	});
	</script>
	<?php
}


function print_out_error($errno, $exc_msg, $title)
{
    static $index = 0;

    if (!should_throw_error($errno))
    {
        return;
    }

    $div_id = '_error_output-'.$index;
    ++$index;

    ?>
    <div id="<?= $div_id ?>" style="position: fixed; top: 0; left: 0; z-index: 999999; width: 100%; overflow: auto; padding:20px; background-color:#FEE; color: #111; border: 1px red solid; font-size: 14px; ">
        <p style="font-weight: bold; font-size: 32px;"><?= $title ?></p>
        <pre style="font-weight: bold;"><?= $exc_msg ?></pre>
        <br><br>
        <pre><?php debug_print_backtrace() ?></pre>
        <button id="close-<?= $div_id ?>">Close</button>
    </div>
    <script>
(function () {
    'use strict';
    var div = document.getElementById('<?= $div_id ?>');
    document.getElementsByTagName('body')[0].appendChild(div);
    var btn = document.getElementById("close-<?= $div_id ?>");
    btn.onclick = function () {
        div.parentNode.removeChild(div);
        return false;
    };
})();
    </script>
    <?php
}

function should_throw_error($errno)
{
    if (!definedtrue('WP_DEBUG') || !error_reporting())
    {
        return false;
    }

    if (is_admin())
    {
        return false;
    }

    if ($errno === E_USER_NOTICE || $errno === E_NOTICE)
    {
        return (defined('IW_IGNORE_NOTICES') && !IW_IGNORE_NOTICES);
    }

    return true;
}

