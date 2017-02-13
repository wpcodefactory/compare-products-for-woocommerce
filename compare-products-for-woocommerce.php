<?php
/*
Plugin Name: Compare Products for WooCommerce
Description: Let your users know which products interest them the most by comparing them.
Version: 1.0.0
Author: Algoritmika Ltd
Copyright: © 2017 Algoritmika Ltd.
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: alg-wc-compare-products
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Disble this plugin if Pro version is activated
if ( defined( 'ALG_WC_CP_PRO_DIR' ) ) {
	function auto_deactivate(){
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	add_action('admin_init','auto_deactivate');
}

// Check if WooCommerce is active
$plugin = 'woocommerce/woocommerce.php';
if (
	! in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins', array() ) ) ) &&
	! ( is_multisite() && array_key_exists( $plugin, get_site_option( 'active_sitewide_plugins', array() ) ) )
) {
	return;
}

// Autoloader without namespace
if ( ! function_exists( 'alg_wc_cp_autoloader' ) ) {

	/**
	 * Autoloads all classes
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   type $class
	 */
	function alg_wc_cp_autoloader( $class ) {
		if ( false !== strpos( $class, 'Alg_WC_CP' ) ) {
			$classes_dir     = array();
			$plugin_dir_path = realpath( plugin_dir_path( __FILE__ ) );
			$classes_dir[0]  = $plugin_dir_path . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR;
			$classes_dir[1]  = $plugin_dir_path . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR;
			$classes_dir[2]  = $plugin_dir_path . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR;
			$class_file      = 'class-' . strtolower( str_replace( array( '_', "\0" ), array( '-', '' ), $class ) . '.php' );

			foreach ( $classes_dir as $key => $dir ) {
				$file = $dir . $class_file;
				if ( is_file( $file ) ) {
					require_once $file;
					break;
				}
			}
		}
	}

	spl_autoload_register( 'alg_wc_cp_autoloader' );
}

// Constants
if ( ! defined( 'ALG_WC_CP_DIR' ) ) {
	define( 'ALG_WC_CP_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR );
}

if ( ! defined( 'ALG_WC_CP_URL' ) ) {
	define( 'ALG_WC_CP_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'ALG_WC_CP_BASENAME' ) ) {
	define( 'ALG_WC_CP_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'ALG_WC_CP_FOLDER_NAME' ) ) {
	define( 'ALG_WC_CP_FOLDER_NAME', untrailingslashit( plugin_dir_path( plugin_basename( __FILE__ ) ) ) );
}

// Loads the template
if ( ! function_exists( 'alg_wc_cp_locate_template' ) ) {
	/**
	 * Returns a template.
	 *
	 * Searches For a template on stylesheet directory and if it's not found get this same template on plugin's template folder
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @global  type $woocommerce
	 * @param   type $path
	 * @param   type $params
	 * @return  type
	 */
	function alg_wc_cp_locate_template( $path, $params = null ) {
		$located     = locate_template( array(
			ALG_WC_CP_FOLDER_NAME . '/' . $path,
		) );
		$plugin_path = ALG_WC_CP_DIR . 'templates' . DIRECTORY_SEPARATOR . $path;
		if ( ! $located && file_exists( $plugin_path ) ) {
			$final_file = $plugin_path;
		} elseif ( $located ) {
			$final_file = $located;
		}
		if ( $params ) {
			$params = apply_filters( 'alg_wc_cp_locate_template_params', $params, $final_file, $path );
			set_query_var( 'params', $params );
		}
		ob_start();
		include( $final_file );
		$final_file = apply_filters( 'alg_wc_cp_locate_template', $final_file, $params, $path );

		return ob_get_clean();
	}
}

if ( ! function_exists( 'alg_wc_compare_products' ) ) {
	/**
	 * Returns the main instance of alg_wc_compare_products_Core to prevent the need to use globals.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  alg_wc_compare_products_Core
	 */
	function alg_wc_compare_products() {
		return Alg_WC_CP_Core::instance();
	}
}

$alg_wc_wl = alg_wc_compare_products();

// Called when plugin is activated
register_activation_hook( __FILE__, array( $alg_wc_wl, 'on_install' ) );

// Called when plugin is uninstalled
register_uninstall_hook( __FILE__, array( Alg_WC_CP_Core::get_class_name(), 'on_uninstall' ) );