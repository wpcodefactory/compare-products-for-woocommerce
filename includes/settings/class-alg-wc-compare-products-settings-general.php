<?php
/**
 * Compare Products for WooCommerce - General Section Settings
 *
 * @version 2.0.1
 * @since   2.0.0
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Compare_Products_Settings_General' ) ) :

class Alg_WC_Compare_Products_Settings_General extends Alg_WC_Compare_Products_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'General', 'compare-products-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.0.1
	 * @since   2.0.0
	 */
	function get_settings() {

		$plugin_settings = array(
			array(
				'title'    => __( 'Compare Products Options', 'compare-products-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_compare_products_plugin_options',
			),
			array(
				'title'    => __( 'Compare Products', 'compare-products-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable plugin', 'compare-products-for-woocommerce' ) . '</strong>',
				'id'       => 'alg_wc_cp_enable',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_compare_products_plugin_options',
			),
		);

		$general_settings = array(
			array(
				'title'    => __( 'General Options', 'compare-products-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_compare_products_general_options',
			),
			array(
				'title'    => __( 'Load Font Awesome', 'compare-products-for-woocommerce' ),
				'desc'     => __( 'Load most recent version of Font Awesome', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Only mark this if you are not loading Font Awesome nowhere else. Font Awesome is responsible for creating icons.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_fontawesome',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => 'Pro version',
				'enable'   => apply_filters( 'alg_wc_compare_products_settings', true ),
				'type'     => 'wccso_metabox',
				'show_in_pro' => false,
				'accordion' => array(
					'title' => __( 'Take a look on some of its features:', 'compare-products-for-woocommerce' ),
					'items' => array(
						array(
							'trigger'     => __( 'Choose in real time which comparison list columns will be displayed on front-end', 'compare-products-for-woocommerce' ),
							'img_src'     => plugins_url( '../../assets/images/real-time-columns.gif', __FILE__ ),
						),
						array(
							'trigger'     => __( 'Sort products on the comparison list by any field', 'compare-products-for-woocommerce' ),
							'img_src'     => plugins_url( '../../assets/images/sorter.gif', __FILE__ ),
						),
						array(
							'trigger'     => __( 'Style your buttons easily', 'compare-products-for-woocommerce' ),
							'description' => __( 'Customize button icon, color, background, margin and more', 'compare-products-for-woocommerce' ),
						),
					),
				),
				'call_to_action' => array(
					'href'   => 'https://wpfactory.com/item/compare-products-woocommerce/',
					'label'  => 'Upgrade to Pro version now',
				),
				'description' => __( 'Do you like the free version of this plugin? Imagine what the Pro version can do for you!', 'compare-products-for-woocommerce' ) . '<br />' .
					sprintf( __( 'Check it out <a target="_blank" href="%1$s">here</a> or on this link: <a target="_blank" href="%1$s">%1$s</a>', 'compare-products-for-woocommerce' ),
						esc_url( 'https://wpfactory.com/item/compare-products-woocommerce/' ) ),
				'id'       => 'alg_wc_cp_cmb_pro',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_compare_products_general_options',
			),
		);

		return array_merge( $plugin_settings, $general_settings );
	}

}

endif;

return new Alg_WC_Compare_Products_Settings_General();
