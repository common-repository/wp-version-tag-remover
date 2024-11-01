<?php
/**
 * Plugin Name: WP Version Tag Remover
 * Description: This plugin will remove the WordPress, CSS and JS version from your website header.
 * Author:      Arul Prasad J
 * Author URI:  https://profiles.wordpress.org/arulprasadj/
 * Text Domain: wp-version-tag-remover
 * Domain Path: /lang
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Version:     2.1
 */

/*
Copyright (C)  2020-2021 arulprasadj

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

*/

// Quit, if now WP environment.
defined( 'ABSPATH' ) || exit;

define( 'APJ_WVTR_VERSION', '2.1' );

define( 'APJ_WVTR_REQUIRED_WP_VERSION', '4.0' );

define( 'APJ_WVTR_PLUGIN', __FILE__ );

define( 'APJ_WVTR_PLUGIN_NAME', 'WP Version Tag Remover');

define( 'APJ_WVTR_PLUGIN_INT', 'wp-version-tag-remover.php');

define( 'APJ_WVTR_MENU_SLUG', 'wp-version-tag-remover/core/admin/admin-page.php' );

define( 'APJ_WVTR_OPT_NAME_CSS', 'wvtr_remove_css');

define( 'APJ_WVTR_OPT_NAME_JS', 'wvtr_remove_script');

define( 'APJ_WVTR_OPT_NAME_GENERATOR', 'wvtr_remove_generator');

define( 'APJ_WVTR_OPT_NAME_WP_VERSION', 'wvtr_remove_wpversion');

define( 'APJ_WVTR_OPT_NAME_WOOC_VERSION', 'wvtr_remove_woocversion');

define( 'APJ_WVTR_OPT_ERR_NAME', 'apj_wvtr_admin_error');

require_once plugin_dir_path(__FILE__) . 'core/apj-functions.php';

//Activate plugin
register_activation_hook(__FILE__, array('apjWVTR\WPVersionTagRemover', 'activate'));

//Uninstall plugin
register_uninstall_hook(__FILE__, array('apjWVTR\WPVersionTagRemover', 'uninstall'));

//Init hooks
\apjWVTR\WPVersionTagRemover::initHooks();


?>
