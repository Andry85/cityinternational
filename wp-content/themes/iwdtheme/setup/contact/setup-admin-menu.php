<?php
//fixme basetheme add

namespace IllicitWeb;

add_action('admin_init', function () {
	foreach (get_contact_fields_data() as $field => $data) {
		register_setting(
			CONTACT_OPT_GRP, // option group name
			CONTACT_OPT_NAME_PREFIX.$field, // option name
			function ($value) { // sanitize callback
				return trim(strip_tags($value));
			}
		);
	}
});

add_action('admin_menu', function () {
	add_options_page(
		'Contact Details',
		'Contact Details',
		'manage_options',
		'iw_contact_details',
		__NAMESPACE__.'\\ContactDetailsAdminPage::printOptionsPage'
	);
});

class ContactDetailsAdminPage
{
	public static function printOptionsPage()
	{
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		?>
		<div class="wrap">
			<style>
				#notes_iw_contact_details {
					max-width: 600px;
				}
			</style>
			<h2>Contact Details</h2>
			<form method="post" action="options.php" id="form_iw_contact_details">
				<?php settings_fields(CONTACT_OPT_GRP); ?>
				<table>
					<?php foreach (get_contact_fields_data() as $field => $data): ?>
					<tr>
						<th><?= $data['label'] ?></th>
						<td>
							<?php

							switch (empty($data['type']) ? null : $data['type']) {
								case 'textarea':
									?>
									<textarea name="<?= CONTACT_OPT_NAME_PREFIX.$field ?>"><?= htmlspecialchars(get_option( CONTACT_OPT_NAME_PREFIX.$field )) ?></textarea>
									<?php
									break;
								default:
									?>
									<input name="<?= CONTACT_OPT_NAME_PREFIX.$field ?>" value="<?= get_option( CONTACT_OPT_NAME_PREFIX.$field ) ?>" type="text">
									<?php
							}

							?>
						</td>
					</tr>
					<?php endforeach ?>
				</table>
				<?php submit_button(); ?>
			</form>
			<div id="notes_iw_contact_details">
				<h3>Notes</h3>
				<p>
					Put your basic contact details here. Depending on the theme, these details may appear in various
					places in your web pages. You can drop them into content yourself using shortcodes such as
					<em>[contact_email]</em>. This means if any of the details change you only need to come here to change them,
					rather than trawling through your posts.
				</p>
				<h3>Shortcodes</h3>
				<ul>
					<li>[contact_email]</li>
					<li>[contact_email_2]</li>
					<li>[contact_phone]</li>
					<li>[contact_phone_2]</li>
					<li>[contact_postal_address]</li>
				</ul>
			</div>
		</div>
		<script>document.getElementById('form_iw_contact_details').reset();</script>
		<?php
	}
}
