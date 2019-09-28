<?php

namespace IllicitWeb;

// Constants

/// File paths
define(__NAMESPACE__.'\\THEME_DIR', dirname(__FILE__).'/');
define(__NAMESPACE__.'\\PLUGINS_DIR', ABSPATH.'wp-content/plugins/');
define(__NAMESPACE__.'\\CONFIG_DIR', THEME_DIR.'config/');
define(__NAMESPACE__.'\\IMAGES_DIR', THEME_DIR.'images/');

/// URLs
define(__NAMESPACE__.'\\THEME_URL', get_template_directory_uri().'/');
define(__NAMESPACE__.'\\JS_URL', THEME_URL.'js/');
define(__NAMESPACE__.'\\JS_LIBS_URL', THEME_URL.'js-libs/');
define(__NAMESPACE__.'\\IMAGES_URL', THEME_URL.'images/');
define(__NAMESPACE__.'\\NODE_MODULES_URL', THEME_URL.'node_modules/');
define(__NAMESPACE__.'\\LOG_DIR', THEME_DIR.'setup/debug/logs/');

/// Date formats
define(__NAMESPACE__.'\\WP_DATE_FORMAT', 'Y-m-d H:i:s'); // WP core format
define(__NAMESPACE__.'\\TERSE_DATE_FORMAT', 'd.m.Y'); // Custom format
define(__NAMESPACE__.'\\PRETTY_DATE_FORMAT', 'jS M Y'); // Custom format

/// WooCommerce
define(__NAMESPACE__.'\\WC_PRODUCT', 'product');
define(__NAMESPACE__.'\\WC_PRODUCT_VARIATION', 'product_variation');
define(__NAMESPACE__.'\\WC_PRODUCT_CAT', 'product_cat');
define(__NAMESPACE__.'\\WC_ORDER', 'shop_order');

/// Client (platforms, browsers)
define(__NAMESPACE__.'\\OS_WINDOWS', 'OS_WINDOWS');
define(__NAMESPACE__.'\\OS_MAC', 'OS_MAC');
define(__NAMESPACE__.'\\OS_LINUX', 'OS_LINUX');
define(__NAMESPACE__.'\\OS_IOS', 'OS_IOS');
define(__NAMESPACE__.'\\OS_ANDROID', 'OS_ANDROID');
define(__NAMESPACE__.'\\OS_BLACKBERRY', 'OS_BLACKBERRY');
define(__NAMESPACE__.'\\BR_FIREFOX', 'BR_FIREFOX');
define(__NAMESPACE__.'\\BR_CHROME', 'BR_CHROME');
define(__NAMESPACE__.'\\BR_SAFARI', 'BR_SAFARI');
define(__NAMESPACE__.'\\BR_OPERA', 'BR_OPERA');
define(__NAMESPACE__.'\\BR_EDGE', 'BR_EDGE');
define(__NAMESPACE__.'\\BR_IE', 'BR_IE');

// Contact details
define(__NAMESPACE__.'\\CONTACT_OPT_GRP', 'iw_contact_details_optgrp');
define(__NAMESPACE__.'\\CONTACT_OPT_NAME_PREFIX', 'iw_contact_details_opt_');

// Custom post types / taxonomies
define(__NAMESPACE__.'\\PTYPE_BANNER', 'iw_banner');
define(__NAMESPACE__.'\\PTYPE_GALLERY', 'iw_gallery');
define(__NAMESPACE__.'\\TAX_GALLERY_CAT', 'iw_gallery_cat');

/// Banner config
define(__NAMESPACE__.'\\PARALLAX_SPEED', 0.5);

// Header
define(__NAMESPACE__.'\\HEADER_SEARCH_POPOUT', true);
define(__NAMESPACE__.'\\HEADER_TRANSPARENT', true);

// Helper functions
include THEME_DIR.'helpers/acf.php';
include THEME_DIR.'helpers/classnames.php';
include THEME_DIR.'helpers/config.php';
include THEME_DIR.'helpers/http.php';
include THEME_DIR.'helpers/layout.php';
include THEME_DIR.'helpers/media.php';
include THEME_DIR.'helpers/misc.php';
include THEME_DIR.'helpers/post.php';
include THEME_DIR.'helpers/terms.php';
include THEME_DIR.'helpers/redirects.php';
include THEME_DIR.'helpers/social.php';
include THEME_DIR.'helpers/string.php';

// Image classes
include THEME_DIR.'classes/image/bad-color-input-exception.php';
include THEME_DIR.'classes/image/bad-image-input-exception.php';
include THEME_DIR.'classes/image/color.php';
include THEME_DIR.'classes/image/image.php';

// Cache classes
include THEME_DIR.'classes/cache.php';
include THEME_DIR.'classes/cache-post-meta.php';

// Misc classes
include THEME_DIR.'classes/client-detect.php';
include THEME_DIR.'classes/client-size-detector.php';
include THEME_DIR.'classes/file-management.php';
include THEME_DIR.'classes/mobile-detect.php';
include THEME_DIR.'classes/money-formatter.php';
include THEME_DIR.'classes/path-builder.php';
include THEME_DIR.'classes/pdf/pdf-generator.php';
include THEME_DIR.'classes/profiler.php';
include THEME_DIR.'classes/url-builder.php';

// Ajax
include THEME_DIR.'ajax/ajax-handler.php';
include THEME_DIR.'ajax/json-ajax-handler.php';

// Custom Post Types
include THEME_DIR.'post-types/banner.php';
include THEME_DIR.'post-types/gallery.php';

// Model Classes

/// ACF Objects
include THEME_DIR.'models/acf-object.php';

//// Posts
include THEME_DIR.'models/post.php';
include THEME_DIR.'models/banner.php';
include THEME_DIR.'models/gallery.php';
include THEME_DIR.'models/menu-item.php';

//// Terms
include THEME_DIR.'models/term.php';
include THEME_DIR.'models/menu.php';

/// Post Lists
include THEME_DIR.'models/post-list.php';

/// Tree Nodes
include THEME_DIR.'models/tree/tree-node.php';
include THEME_DIR.'models/tree/term-tree-node.php';
include THEME_DIR.'models/tree/menu-tree-node.php';
include THEME_DIR.'models/tree/menu-item-tree-node.php';

/// Misc
include THEME_DIR.'models/latest-news-strip.php';

// Templating

/// General
include THEME_DIR.'templating/printer.php';
include THEME_DIR.'templating/page-printer.php';
include THEME_DIR.'templating/front-page-printer.php';
include THEME_DIR.'templating/blog-page-printer.php';
include THEME_DIR.'templating/section-printer.php';
include THEME_DIR.'templating/pdf-printer.php';

/// Main WP Routes
include THEME_DIR.'templating/single-printer.php';
include THEME_DIR.'templating/archive-printer.php';
include THEME_DIR.'templating/author-printer.php';
include THEME_DIR.'templating/category-printer.php';
include THEME_DIR.'templating/tag-printer.php';
include THEME_DIR.'templating/search-printer.php';

/// Header
include THEME_DIR.'templating/header/header-printer.php';
include THEME_DIR.'templating/header/simple-header-printer.php';
include THEME_DIR.'templating/header/simple-header-3-col-printer.php';
include THEME_DIR.'templating/header/simple-header-contact-top-printer.php';

/// Banner
include THEME_DIR.'templating/banner-printer.php';
include THEME_DIR.'templating/page-banner-printer.php';
include THEME_DIR.'templating/top-banner-printer.php';
include THEME_DIR.'templating/second-banner-printer.php';

/// Page post content
include THEME_DIR.'templating/page-content-printer.php';
include THEME_DIR.'templating/large-page-content-printer.php';

/// Blog post archives
include THEME_DIR.'templating/category-archive-printer.php';
include THEME_DIR.'templating/monthly-archive-printer.php';

/// Misc
include THEME_DIR.'templating/big-links-printer.php';
include THEME_DIR.'templating/cycling-content-printer.php';
include THEME_DIR.'templating/side-nav-printer.php';
include THEME_DIR.'templating/latest-news-strip-printer.php';
include THEME_DIR.'templating/mail-signup-printer.php';
include THEME_DIR.'templating/map-embed-printer.php';
include THEME_DIR.'templating/multipage-printer.php';
include THEME_DIR.'templating/page-gallery-printer.php';
include THEME_DIR.'templating/post-excerpt-printer.php';
include THEME_DIR.'templating/post-list-printer.php';
include THEME_DIR.'templating/secondary-content-printer.php';
include THEME_DIR.'templating/secondary-post-printer.php';
include THEME_DIR.'templating/social-feeds-printer.php';
include THEME_DIR.'templating/social-icon-links-printer.php';
include THEME_DIR.'templating/social-links-pinned-printer.php';
include THEME_DIR.'templating/scripts-printer.php';
include THEME_DIR.'templating/slides-printer.php';
include THEME_DIR.'templating/gallery-printer.php';
include THEME_DIR.'templating/slidey-gallery-printer.php';
include THEME_DIR.'templating/full-screen-section.php';
include THEME_DIR.'templating/column-section-printer.php';
include THEME_DIR.'templating/areas-of-law-printer.php';
include THEME_DIR.'templating/team-printer.php';

// Setup
include THEME_DIR.'setup/acf/acf-setup.php';
include THEME_DIR.'setup/basic-setup.php';
include THEME_DIR.'setup/contact/main.php';
include THEME_DIR.'setup/debug/main.php';
include THEME_DIR.'setup/head.php';
include THEME_DIR.'setup/gallery.php';
include THEME_DIR.'setup/misc-wp-hooks.php';
include THEME_DIR.'setup/routing.php';
include THEME_DIR.'setup/widgets.php';
include THEME_DIR.'setup/wc/main.php';

// Shortcodes
include THEME_DIR.'shortcodes/blog.php';
include THEME_DIR.'shortcodes/button.php';
include THEME_DIR.'shortcodes/contact.php';
include THEME_DIR.'shortcodes/content-block.php';
include THEME_DIR.'shortcodes/gallery.php';
include THEME_DIR.'shortcodes/gmap.php';
include THEME_DIR.'shortcodes/img.php';
include THEME_DIR.'shortcodes/img-div.php';
include THEME_DIR.'shortcodes/loggedin.php';
include THEME_DIR.'shortcodes/menu.php';
include THEME_DIR.'shortcodes/social.php';

add_action('admin_init', function() {
	remove_post_type_support('page', 'editor');
});

remove_filter('widget_text_content', 'wpautop');

remove_action('load-update-core.php','wp_update_themes');
add_filter('pre_site_transient_update_themes',create_function('$a', "return null;"));
wp_clear_scheduled_hook('wp_update_themes');
add_filter('pre_site_transient_update_core',create_function('$a', "return null;"));
wp_clear_scheduled_hook('wp_version_check');
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
wp_clear_scheduled_hook( 'wp_update_plugins' );