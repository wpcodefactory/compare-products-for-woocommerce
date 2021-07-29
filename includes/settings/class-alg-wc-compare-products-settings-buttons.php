<?php
/**
 * Compare Products for WooCommerce - Buttons Section Settings
 *
 * @version 2.0.1
 * @since   2.0.0
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Compare_Products_Settings_Buttons' ) ) :

class Alg_WC_Compare_Products_Settings_Buttons extends Alg_WC_Compare_Products_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function __construct() {
		$this->id   = 'buttons';
		$this->desc = __( 'Buttons', 'compare-products-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.0.1
	 * @since   2.0.0
	 */
	function get_settings() {

		$buttons_settings = array(
			array(
				'title'    => __( 'General Options', 'compare-products-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_compare_products_buttons_general_options',
			),
			array(
				'title'    => __( 'Button title', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_default_btn_title',
				'default'  => __( 'Compare', 'compare-products-for-woocommerce' ),
				'type'     => 'text',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_compare_products_buttons_general_options',
			),
			array(
				'title'    => __( 'Singe Product Page Options', 'compare-products-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_compare_products_buttons_single_options',
			),
			array(
				'title'    => __( 'Single product page', 'compare-products-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable', 'compare-products-for-woocommerce' ) . '</strong>',
				'desc_tip' => __( 'Enables button on single product page.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_default_btn_single',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Position', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Where the button will appear on single product page?', 'compare-products-for-woocommerce' ) . ' ' .
					__( 'Default is "On single product summary".', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_default_btn_single_pos',
				'default'  => 'woocommerce_single_product_summary',
				'type'     => 'select',
				'options'  => array(
					'woocommerce_single_product_summary'        => __( 'On single product summary', 'compare-products-for-woocommerce' ),
					'woocommerce_before_single_product_summary' => __( 'Before single product summary', 'compare-products-for-woocommerce' ),
					'woocommerce_after_single_product_summary'  => __( 'After single product summary', 'compare-products-for-woocommerce' ),
					'woocommerce_product_thumbnails'            => __( 'After product thumbnail', 'compare-products-for-woocommerce' ),
				),
			),
			array(
				'title'    => __( 'Priority', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'More precise control of where the button will appear on single product page.', 'compare-products-for-woocommerce' ) . ' ' .
					__( 'Default is 31, right after "add to cart" button.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_default_btn_single_priority',
				'default'  => 31,
				'type'     => 'number',
				'attributes' => array( 'type' => 'number' ),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_compare_products_buttons_single_options',
			),
			array(
				'title'    => __( 'Product Loop Options', 'compare-products-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_compare_products_buttons_loop_options',
			),
			array(
				'title'    => __( 'Product loop', 'compare-products-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable', 'compare-products-for-woocommerce' ) . '</strong>',
				'desc_tip' => __( 'Enables button on product loop.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_default_btn_loop',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Position', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'More precise control of where the button will appear on product loop.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_default_btn_loop_priority',
				'options'  => array(
					'9'  => __( 'Before add to cart button', 'compare-products-for-woocommerce' ),
					'11' => __( 'After add to cart button', 'compare-products-for-woocommerce' ),
				),
				'default'  => '11',
				'type'     => 'select',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_compare_products_buttons_loop_options',
			),
		);

		return array_merge( $buttons_settings );
	}

}

endif;

return new Alg_WC_Compare_Products_Settings_Buttons();
