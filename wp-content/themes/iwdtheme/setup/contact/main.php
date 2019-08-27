<?php

namespace IllicitWeb;

include THEME_DIR.'setup/contact/setup-admin-menu.php';

function get_contact_fields_data()
{
	return array(
		'phone' => array(
			'label' => 'Phone number',
		),
		'phone_2' => array(
			'label' => 'Phone number 2',
		),
		'phone_3' => array(
			'label' => 'Phone number 3',
		),
		'phone_4' => array(
			'label' => 'Phone number 4',
		),
		'email' => array(
			'label' => 'Email address',
		),
		'email_2' => array(
			'label' => 'Email address 2',
		),
		'facebook' => array(
			'label' => 'Facebook page URL',
		),
		'twitter' => array(
			'label' => 'Twitter page URL',
		),
		'linkedin' => array(
			'label' => 'LinkedIn page URL',
		),
		'googleplus' => array(
			'label' => 'Google+ page URL',
		),
		'vimeo' => array(
			'label' => 'Vimeo URL',
		),
		'instagram' => array(
			'label' => 'Instagram URL',
		),
		'youtube' => array(
			'label' => 'YouTube channel URL',
		),
		'pinterest' => array(
			'label' => 'Pinterest page URL',
		),
		'slideshare' => array(
			'label' => 'Slideshare page URL',
		),
		'postal' => array(
			'label' => 'Postal address',
			'type' => 'textarea',
		),
	);
}

function get_contact_field($field)
{
	static $results = array();
	
	if (!isset($results[$field]))
	{
		$results[$field] = get_option(CONTACT_OPT_NAME_PREFIX.$field);
	}

	return $results[$field];
}

// @param {string} $email Email address
// @param {array} [$html_attr] Assoc array mapping HTML attr names to values
// @param {string} [$text] This text is exposed - don't put the email address in it!
// To make the text in the <a> the email address, set/leave it NULL.
// $text must be html-escaped (inc quotes)
// @return {string} HTML fragment: will build obfuscated <a> mailto: for $email email address
function obfuscate_email($email, $html_attr = null, $text = null, $subject = null) {
	static $count = 0;
	$parts = explode('@', $email);
	if (!isset($parts[1])) return ''; // not an email addr
	// note: @ = &#x00040;
	$id = ($count++).'-'.md5(time().rand(0,999));
	$attr_html = '<a ';
	if ($html_attr) {
		foreach ($html_attr as $name => $value) {
			$attr_html .= $name.'="'.$value.'" ';
		}
	}
	ob_start();
	?>
	<span id="<?= $id ?>"></span>
	<script>
	(function(){
		var s=document.getElementById('<?= $id ?>');
		var e='<?= $parts[1] ?>';
		e = '<?= $parts[0] ?>' + '&' + '#' + 'x0' + '00' + '40;' + e;
		<?php if ($text === null || $text === $email): ?>
		var t=e;
		<?php else: ?>
		var t='<?= substr($text, 0, 3) ?>'
			+ '<?= substr($text, 3) ?>';
		<?php endif ?>
		var h = '<?= $attr_html ?>';
		h += 'href="mai' + 'lto' + ':' + e + '<?php
			if ($subject !== null) {
				$subject = htmlspecialchars($subject);
				echo "?sub' + 'ject=$subject";
			}
		?>">' + t + '</a>';
		s.innerHTML=h;
	})();
	</script>
	<?php
	return ob_get_clean();
}

// @return {string} Safe email link HTML
function get_safe_email_link($html_attr=null, $text=null, $subject=null, $field=null)
{
	if (!$field) 
	{
		$field = 'email';
	}
	
	$email = get_contact_field($field);
	
	if ($email)
	{
		return obfuscate_email($email, $html_attr, $text, $subject);
	}
	else
	{
		return '';
	}
}

function get_tel_link($html_attr=null, $field=null)
{
	if (!$field)
	{
		$field = 'phone';
	}

	$phone = get_contact_field($field);

	if (!$phone)
	{
		return '';
	}

	$href = preg_replace('/^\s*\+*\s*44\s*\(\s*0\s*\)\s*/', '44', $phone);
	$href = preg_replace('/[^0-9]/', '', $href);
	$href = preg_replace('/^0/', '44', $href);
	$href = 'tel:'.$href;

	$html = '<a href="'.$href.'"';

	if ($html_attr)
	{
		foreach ($html_attr as $attr => $value)
		{
			$value = htmlspecialchars($value);
			$html .=  " $attr=\"$value\"";
		}
	}

	$html .= '>'.htmlspecialchars($phone).'</a>';

	return $html;
}

