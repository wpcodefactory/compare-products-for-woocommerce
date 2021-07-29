<?php
/**
 * Compare Products for WooCommerce - Core Class
 *
 * @version 2.0.0
 * @since   2.0.0
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Compare_Products_Core' ) ) :

class Alg_WC_Compare_Products_Core {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @todo    [feature] custom redirect (e.g. to comparison list page) after adding product to compare (i.e. in case of non-modal)
	 */
	function __construct() {
		if ( 'yes' === get_option( 'alg_wc_cp_enable', 'yes' ) ) {
			// Manages buttons
			$this->handle_buttons();
			// Enqueue scripts
			add_action( 'wp_enqueue_scripts',             array( $this, 'enqueue_scripts' ) );
			// Takes actions based on the requested url
			add_action( 'woocommerce_init',               array( $this, 'route' ), 20 );
			// Creates comparison list
			add_action( 'wp_footer',                      array( $this, 'create_comparison_list' ) );
			// Start session if necessary
			add_action( 'init',                           array( $this, 'handle_session' ), 1 );
			add_action( 'woocommerce_init',               array( $this, 'handle_session' ), 1 );
			// Shortcodes
			add_shortcode( 'alg_wc_cp_table',             array( $this, 'create_comparison_list_shortcode' ) );
			// Widget
			add_action( 'widgets_init',                   array( $this, 'create_widgets' ) );
			// Action
			do_action( 'alg_wc_compare_products_core_loaded' );
		}
	}

	/**
	 * Create widgets.
	 *
	 * @version 2.0.0
	 * @since   1.1.0
	 */
	function create_widgets() {
		if ( 'yes' === get_option( 'alg_wc_cp_cl_widget_link', 'yes' ) ) {
			register_widget( 'Alg_WC_CP_Widget_Link' );
		}
	}

	/**
	 * create_comparison_list_shortcode.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function create_comparison_list_shortcode( $atts, $content = '' ) {
		return Alg_WC_CP_Comparison_List::create_comparison_list( array( 'use_modal' => false ) );
	}

	/**
	 * get_modal_arg.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function get_modal_arg() {
		return ( isset( $_REQUEST['alg_wc_cp_modal'] ) ? sanitize_text_field( $_REQUEST['alg_wc_cp_modal'] ) : false );
	}

	/**
	 * Creates comparison list.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function create_comparison_list() {
		if ( 'no' === get_option( 'alg_wc_cp_cl_use_modal', 'yes' ) || 'open' != $this->get_modal_arg() ) {
			return;
		}
		echo Alg_WC_CP_Comparison_List::create_comparison_list();
	}

	/**
	 * Start session if necessary.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @todo    [dev] WC session
	 */
	function handle_session() {
		if ( ! session_id() ) {
			session_start();
		}

	}

	/**
	 * Takes actions based on the requested url.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function route() {
		$args   = $_GET;
		$args   = wp_parse_args( $args, array( 'alg_wc_cp_action' => '' ) );
		$action = sanitize_text_field( $args['alg_wc_cp_action'] );
		if ( 'compare' == $action ) {
			// Add product to compare list
			$response = Alg_WC_CP_Comparison_List::add_product_to_comparison_list( $args );
			// Show WooCommerce notification
			Alg_WC_CP_Comparison_List::show_notification_after_comparing( $args );
		} elseif ( 'remove' == $action ) {
			// Removes product from compare list
			$response = Alg_WC_CP_Comparison_List::remove_product_from_comparison_list( $args );
			// Show WooCommerce notification
			Alg_WC_CP_Comparison_List::show_notification_after_comparing( $args );
		}
	}

	/**
	 * Load scripts and styles.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function enqueue_scripts() {
		// Font awesome
		if ( 'yes' === get_option( 'alg_wc_cp_fontawesome', 'yes' ) ) {
			if ( ! wp_script_is( 'alg-font-awesome' ) ) {
				wp_enqueue_style( 'alg-font-awesome',
					'//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css',
					array()
				);
			}
		}
		// Main css file
		wp_enqueue_style( 'alg-wc-compare-products',
			alg_wc_compare_products()->plugin_url() . '/' . 'assets/css/alg-wc-cp' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' ) . '.css',
			array(),
			alg_wc_compare_products()->version
		);
		// Izimodal (http://izimodal.marcelodolce.com)
		if ( 'yes' === get_option( 'alg_wc_cp_cl_use_modal', 'yes' ) ) {
			wp_enqueue_script( 'alg-wc-cp-izimodal',
				'//cdnjs.cloudflare.com/ajax/libs/izimodal/1.4.2/js/iziModal.min.js',
				array( 'jquery' ),
				false,
				true
			);
			wp_enqueue_style( 'alg-wc-cp-izimodal',
				'//cdnjs.cloudflare.com/ajax/libs/izimodal/1.4.2/css/iziModal.min.css',
				array(),
				false
			);
			// Show comparison list
			if ( 'open' == $this->get_modal_arg() ) {
				Alg_WC_CP_Comparison_List::show_comparison_list();
			}
		}
	}

	/**
	 * Manages buttons.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function handle_buttons() {
		// Single
		if ( 'yes' === get_option( 'alg_wc_cp_default_btn_single', 'yes' ) ) {
			add_action(
				sanitize_text_field( get_option( 'alg_wc_cp_default_btn_single_pos', 'woocommerce_single_product_summary' ) ),
				'alg_wc_cp_load_compare_button_template',
				filter_var( get_option( 'alg_wc_cp_default_btn_single_priority', 31 ), FILTER_VALIDATE_INT )
			);
		}
		// Loop
		if ( 'yes' === get_option( 'alg_wc_cp_default_btn_loop', 'no' ) ) {
			add_action(
				'woocommerce_after_shop_loop_item',
				'alg_wc_cp_load_compare_button_template',
				filter_var( get_option( 'alg_wc_cp_default_btn_loop_priority', 11 ), FILTER_VALIDATE_INT )
			);
		}
	}

}

endif;

return new Alg_WC_Compare_Products_Core();
