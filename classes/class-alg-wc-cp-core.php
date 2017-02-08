<?php
/**
 * Compare products for WooCommerce  - Core Class
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Core' ) ) :

	final class Alg_WC_CP_Core {

		/**
		 * Plugin version.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		public $version = '1.0.0';

		/**
		 * @var   Alg_WC_CP_Core The single instance of the class
		 * @since 1.0.0
		 */
		protected static $_instance = null;

		/**
		 * Main Alg_WC_CP_Core Instance
		 *
		 * Ensures only one instance of Alg_WC_CP_Core is loaded or can be loaded.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @static
		 * @return  Alg_WC_CP_Core - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Constructor.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function __construct() {

			// Set up localization
			$this->handle_localization();

			// Init admin part
			$this->init_admin();

			if ( true === filter_var( get_option( Alg_WC_CP_Settings_General::OPTION_ENABLE_PLUGIN, false ), FILTER_VALIDATE_BOOLEAN ) ) {

				// Manages buttons
				$this->handle_buttons();

				// Enqueue scripts
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

				// Manages query vars
				add_filter( 'query_vars', array( $this, 'handle_query_vars' ) );

				// Takes actions based on the requested url
				add_action( 'woocommerce_init', array( $this, 'route' ), 20 );

				// Creates comparison list
				add_action( 'wp_footer', array( $this, 'create_comparison_list' ) );

				// Start session if necessary
				add_action( 'init', array( $this, "handle_session" ), 1 );
				add_action( 'woocommerce_init', array( $this, "handle_session" ), 1 );
			}
		}

		/**
		 * Creates comparison list
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function create_comparison_list(){

			if ( Alg_WC_CP_Comparison_list::$add_product_response !== false || Alg_WC_CP_Comparison_list::$remove_product_response !== false ) {
				echo Alg_WC_CP_Comparison_list::create_comparison_list();
			}
		}

		/**
		 * Start session if necessary
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function handle_session() {
			if ( ! session_id() ) {
				session_start();
			}

		}

		/**
		 * Takes actions based on the requested url
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function route() {
			$args   = $_GET;
			$args   = wp_parse_args( $args, array(
				Alg_WC_CP_Query_Vars::ACTION => '',
			) );
			$action = sanitize_text_field( $args[ Alg_WC_CP_Query_Vars::ACTION ] );

			if ( $action == 'compare' ) {

				// Add product to compare list
				$response = Alg_WC_CP_Comparison_list::add_product_to_comparison_list( $args );

				// Show WooCommerce notification
				Alg_WC_CP_Comparison_list::show_notification_after_comparing( $args );

			} else if ( $action == 'remove' ) {

				// Removes product from compare list
				$response = Alg_WC_CP_Comparison_list::remove_product_from_comparison_list( $args );

				// Show WooCommerce notification
				Alg_WC_CP_Comparison_list::show_notification_after_comparing( $args );

			}
		}

		/**
		 * Manages query vars
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function handle_query_vars($vars){
			$vars = Alg_WC_CP_Default_Button::handle_query_vars($vars);
			return $vars;
		}

		/**
		 * Load scripts and styles
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function enqueue_scripts() {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			// Font awesome
			$css_file = 'http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css';
			$font_awesome_opt = get_option( Alg_WC_CP_Settings_General::OPTION_FONT_AWESOME, true );
			if ( filter_var( $font_awesome_opt, FILTER_VALIDATE_BOOLEAN ) !== false ) {
				wp_register_style( 'alg-wc-cp-font-awesome', $css_file, array() );
				wp_enqueue_style( 'alg-wc-cp-font-awesome' );
			}

			// Izimodal - A modal plugin (http://izimodal.marcelodolce.com)
			wp_register_script( 'alg-wc-cp-izimodal', 'https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.4.2/js/iziModal.min.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'alg-wc-cp-izimodal' );
			wp_register_style( 'alg-wc-cp-izimodal', 'https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.4.2/css/iziModal.min.css', array(), false );
			wp_enqueue_style( 'alg-wc-cp-izimodal' );

			// Main css file
			$css_file = 'assets/css/alg-wc-cp'.$suffix.'.css';
			$css_ver = date( "ymd-Gis", filemtime( ALG_WC_CP_DIR . $css_file ) );
			wp_register_style( 'alg-wc-compare-products', ALG_WC_CP_URL . $css_file, array(), $css_ver );
			wp_enqueue_style( 'alg-wc-compare-products' );

			// Show comparison list
			if(Alg_WC_CP_Comparison_list::$add_product_response!==false || Alg_WC_CP_Comparison_list::$remove_product_response!==false){
				Alg_WC_CP_Comparison_list::show_comparison_list();
			}

		}

		/**
		 * Manages buttons.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		private function handle_buttons(){
			Alg_WC_CP_Default_Button::manage_button_loading();
		}

		/**
		 * Init admin fields
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		private function init_admin() {
			if ( is_admin() ) {
				add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab' ) );
				add_filter( 'plugin_action_links_' . ALG_WC_CP_BASENAME, array( $this, 'action_links' ) );
			}

			// Admin setting options inside WooCommerce
			new Alg_WC_CP_Settings_General();
			new Alg_WC_CP_Settings_Buttons();

			if ( is_admin() && get_option( 'alg_wc_cp_version', '' ) !== $this->version ) {
				update_option( 'alg_wc_cp_version', $this->version );
			}
		}

		/**
		 * Show action links on the plugin screen
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @param   mixed $links
		 * @return  array
		 */
		function action_links( $links ) {
			$custom_links = array( '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=alg_wc_cp' ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>' );
			return array_merge( $custom_links, $links );
		}

		/**
		 * Add Wish List settings tab to WooCommerce settings.
		 *
		 * @version 1.1.0
		 * @since   1.0.0
		 */
		function add_woocommerce_settings_tab( $settings ) {
			$settings[] = new Alg_WC_CP_Settings();
			return $settings;
		}

		/**
		 * Handle Localization
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function handle_localization() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'alg-wc-compare-products' );
			load_textdomain( 'alg-wc-compare-products', WP_LANG_DIR . dirname( ALG_WC_CP_BASENAME ) . 'alg-wc-compare-products' . '-' . $locale . '.mo' );
			load_plugin_textdomain( 'alg-wc-compare-products', false, dirname( ALG_WC_CP_BASENAME ) . '/languages/' );
		}

		/**
		 * Method called when the plugin is activated
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function on_install() {

		}

		/**
		 * Method called when the plugin is uninstalled
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public static function on_uninstall() {

		}

		/**
		 * Returns class name
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @return type
		 */
		public static function get_class_name() {
			return get_called_class();
		}

	}

endif;