<?php
/*
Plugin Name: Compare Products for WooCommerce
Plugin URI: https://wpfactory.com/item/compare-products-woocommerce/
Description: Let your users know which products interest them the most by comparing them.
Version: 2.1.0
Author: Algoritmika Ltd
Author URI: https://algoritmika.com
Text Domain: compare-products-for-woocommerce
Domain Path: /langs
WC tested up to: 5.5
*/

defined( 'ABSPATH' ) || exit;

if ( 'compare-products-for-woocommerce.php' === basename( __FILE__ ) ) {
	/**
	 * Check if Pro plugin version is activated.
	 *
	 * @version 2.1.0
	 * @since   2.1.0
	 */
	$plugin = 'compare-products-for-woocommerce-pro/compare-products-for-woocommerce-pro.php';
	if (
		in_array( $plugin, (array) get_option( 'active_plugins', array() ), true ) ||
		( is_multisite() && array_key_exists( $plugin, (array) get_site_option( 'active_sitewide_plugins', array() ) ) )
	) {
		return;
	}
}

defined( 'ALG_WC_COMPARE_PRODUCTS_VERSION' ) || define( 'ALG_WC_COMPARE_PRODUCTS_VERSION', '2.1.0' );

defined( 'ALG_WC_COMPARE_PRODUCTS_FILE' )    || define( 'ALG_WC_COMPARE_PRODUCTS_FILE',    __FILE__ );

require_once( 'includes/class-alg-wc-compare-products.php' );

if ( ! function_exists( 'alg_wc_compare_products' ) ) {
	/**
	 * Returns the main instance of Alg_WC_Compare_Products to prevent the need to use globals.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function alg_wc_compare_products() {
		return Alg_WC_Compare_Products::instance();
	}
}

add_action( 'plugins_loaded', 'alg_wc_compare_products' );
