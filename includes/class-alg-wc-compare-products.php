<?php
/**
 * Compare Products for WooCommerce - Main Class
 *
 * @version 2.1.0
 * @since   2.0.0
 *
 * @author  Algoritmika Ltd
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Compare_Products' ) ) :

final class Alg_WC_Compare_Products {

	/**
	 * Plugin version.
	 *
	 * @var   string
	 * @since 2.0.0
	 */
	public $version = ALG_WC_COMPARE_PRODUCTS_VERSION;

	/**
	 * @var   Alg_WC_Compare_Products The single instance of the class
	 * @since 2.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Alg_WC_Compare_Products Instance
	 *
	 * Ensures only one instance of Alg_WC_Compare_Products is loaded or can be loaded.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 *
	 * @static
	 * @return  Alg_WC_Compare_Products - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Alg_WC_Compare_Products Constructor.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 *
	 * @access  public
	 */
	function __construct() {

		// Check for active WooCommerce plugin
		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		// Set up localisation
		add_action( 'init', array( $this, 'localize' ) );

		// Pro
		if ( 'compare-products-for-woocommerce-pro.php' === basename( ALG_WC_COMPARE_PRODUCTS_FILE ) ) {
			require_once( 'pro/class-alg-wc-compare-products-pro.php' );
		}

		// Include required files
		$this->includes();

		// Admin
		if ( is_admin() ) {
			$this->admin();
		}

		// Install/uninstall
		register_activation_hook( ALG_WC_COMPARE_PRODUCTS_FILE, 'alg_wc_cp_on_install' );
		register_uninstall_hook(  ALG_WC_COMPARE_PRODUCTS_FILE, 'alg_wc_cp_on_uninstall' );

	}

	/**
	 * localize.
	 *
	 * @version 2.1.0
	 * @since   2.1.0
	 */
	function localize() {
		load_plugin_textdomain( 'compare-products-for-woocommerce', false, dirname( plugin_basename( ALG_WC_COMPARE_PRODUCTS_FILE ) ) . '/langs/' );
	}

	/**
	 * includes.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function includes() {
		// Functions
		require_once( 'alg-wc-compare-products-functions.php' );
		// Classes
		require_once( 'class-alg-wc-cp-comparison-list.php' );
		require_once( 'class-alg-wc-cp-widget-link.php' );
		// Core
		$this->core = require_once( 'class-alg-wc-compare-products-core.php' );
	}

	/**
	 * admin.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function admin() {
		// Action links
		add_filter( 'plugin_action_links_' . plugin_basename( ALG_WC_COMPARE_PRODUCTS_FILE ), array( $this, 'action_links' ) );
		// Settings
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab' ) );
		// Version updated
		if ( get_option( 'alg_wc_cp_version', '' ) !== $this->version ) {
			add_action( 'admin_init', array( $this, 'version_updated' ) );
		}
	}

	/**
	 * action_links.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 *
	 * @param   mixed $links
	 * @return  array
	 */
	function action_links( $links ) {
		$custom_links = array();
		$custom_links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=alg_wc_cp' ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>';
		if ( 'compare-products-for-woocommerce.php' === basename( ALG_WC_COMPARE_PRODUCTS_FILE ) ) {
			$custom_links[] = '<a target="_blank" style="font-weight: bold; color: green;" href="https://wpfactory.com/item/compare-products-woocommerce/">' .
				__( 'Go Pro', 'compare-products-for-woocommerce' ) . '</a>';
		}
		return array_merge( $custom_links, $links );
	}

	/**
	 * add_woocommerce_settings_tab.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function add_woocommerce_settings_tab( $settings ) {
		$settings[] = require_once( 'settings/class-alg-wc-compare-products-settings.php' );
		return $settings;
	}

	/**
	 * version_updated.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function version_updated() {
		update_option( 'alg_wc_cp_version', $this->version );
	}

	/**
	 * plugin_url.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 *
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( ALG_WC_COMPARE_PRODUCTS_FILE ) );
	}

	/**
	 * plugin_path.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 *
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( ALG_WC_COMPARE_PRODUCTS_FILE ) );
	}

	/**
	 * folder_name.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 *
	 * @return  string
	 */
	function folder_name() {
		return untrailingslashit( plugin_dir_path( plugin_basename( ALG_WC_COMPARE_PRODUCTS_FILE ) ) );
	}

}

endif;
