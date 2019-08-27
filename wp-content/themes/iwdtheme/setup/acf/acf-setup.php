<?php
namespace IllicitWeb;

class AcfSetup
{
	static public function init()
	{
		self::setupAcfPlugins();

		add_action('init', function () {
			self::registerFieldGroups();
			self::registerSiteWideOptions();
		});
	}

	static private function setupAcfPlugins()
	{
		$path_relative = 'setup/acf/plugins/advanced-custom-fields-pro/';
		$acf_path = THEME_DIR.$path_relative;
		$acf_url = THEME_URL.$path_relative;

		add_filter('acf/settings/path', function ($path) use ($acf_path) {
		    return $acf_path;
		});

		add_filter('acf/settings/dir', function ($path) use ($acf_url) {
		    return $acf_url;
		});

		include_once($acf_path.'acf.php');
	}

	static private function registerFieldGroups()
	{
		$includes = config('acf.includes');

		$dir = THEME_DIR.'setup/acf/group-registrations/';

		foreach ($includes as $include)
		{
			include $dir.$include.'.php';
		}
	}

	static private function registerSiteWideOptions()
	{
		acf_add_options_page([
			'page_title' 	=> 'Options',
			'menu_title'	=> 'Options',
			'menu_slug' 	=> 'acf-options',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
		]);

		acf_add_local_field_group(array (
			'key' => 'acf_site-options',
			'title' => 'Site Options',
			'fields' => config('acf.site_wide_fields'),
			'location' => array (
				array (
					array (
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'acf-options',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));
	}
}

AcfSetup::init();
