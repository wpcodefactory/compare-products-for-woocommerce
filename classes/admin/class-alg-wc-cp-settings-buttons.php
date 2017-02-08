<?php
/**
 * Compare products for WooCommerce - Buttons settings
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Settings_Buttons' ) ) {

	class Alg_WC_CP_Settings_Buttons extends Alg_WC_CP_Settings_Section {

		const OPTION_DEFAULT_BTN_SHOW_ON_SINGLE_PAGE = 'alg_wc_cp_default_btn_single';
		const OPTION_DEFAULT_BTN_SHOW_ON_LOOP_PAGE   = 'alg_wc_cp_default_btn_single_loop';
		const OPTION_DEFAULT_BTN_SINGLE_POSITION     = 'alg_wc_cp_default_btn_single_pos';
		const OPTION_DEFAULT_BTN_SINGLE_PRIORITY     = 'alg_wc_cp_default_btn_single_priority';

		const OPTION_DEFAULT_BTN_LOOP_ENABLE         = 'alg_wc_cp_default_btn_loop';
		const OPTION_DEFAULT_BTN_LOOP_PRIORITY       = 'alg_wc_cp_default_btn_loop_priority';

		/**
		 * Constructor.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function __construct( $handle_autoload = true ) {
			$this->id   = 'buttons';
			$this->desc = __( 'Buttons', 'alg-wc-compare-products' );
			parent::__construct( $handle_autoload );
		}

		/**
		 * get_settings.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function get_settings( $settings = null ) {
			$new_settings = array(
				array(
					'title' => __( 'General options', 'alg-wc-compare-products' ),
					'type'  => 'title',
					'id'    => 'alg_wc_cp_btn_opt',
				),
				array(
					'title'    => __( 'Single page', 'alg-wc-compare-products' ),
					'desc'     => __( 'Enables a default button on single product page', 'alg-wc-compare-products' ),
					'id'       => self::OPTION_DEFAULT_BTN_SHOW_ON_SINGLE_PAGE,
					'default'  => 'yes',
					'type'     => 'checkbox',
				),
				array(
					'title'      => __( 'Position on single', 'alg-wc-compare-products' ),
					'desc'       => __( 'Where the button will appear on single product page?', 'alg-wc-compare-products' ),
					'desc_tip'   => __( 'Default is On single product summary', 'alg-wc-compare-products' ),
					'id'         => self::OPTION_DEFAULT_BTN_SINGLE_POSITION,
					'default'    => 'woocommerce_single_product_summary',
					'type'       => 'select',
					'options'    => array(
						'woocommerce_single_product_summary'        => __( 'On single product summary', 'alg-wc-compare-products' ),
						'woocommerce_before_single_product_summary' => __( 'Before single product summary', 'alg-wc-compare-products' ),
						'woocommerce_after_single_product_summary'  => __( 'After single product summary', 'alg-wc-compare-products' ),
						'woocommerce_product_thumbnails'            => __( 'After product thumbnail', 'alg-wc-compare-products' ),
					),
				),
				array(
					'title'      => __( 'Priority on single', 'alg-wc-compare-products' ),
					'desc'       => __( 'More precise control of where the button will appear on single product page', 'alg-wc-compare-products' ),
					'desc_tip'   => __( 'Default is 31, right after "add to cart" button ', 'alg-wc-compare-products' ),
					'id'         => self::OPTION_DEFAULT_BTN_SINGLE_PRIORITY,
					'default'    => 31,
					'type'       => 'number',
					'attributes' => array( 'type' => 'number' ),
				),
				array(
					'title'      => __( 'Product loop', 'alg-wc-compare-products' ),
					'desc'       => __( 'Enable button on product loop', 'alg-wc-compare-products' ),
					'id'         => self::OPTION_DEFAULT_BTN_LOOP_ENABLE,
					'default'    => 'no',
					'type'       => 'checkbox',
				),
				array(
					'title'      => __( 'Priority on loop', 'alg-wc-compare-products' ),
					'desc'       => __( 'More precise control of where the button will appear on product loop', 'alg-wc-compare-products' ),
					'id'         => self::OPTION_DEFAULT_BTN_LOOP_PRIORITY,
					'options'    => array(
						'9'  => __( 'Before add to cart button', 'alg-wc-compare-products' ),
						'11' => __( 'After add to cart button', 'alg-wc-compare-products' ),
					),
					'default'    => '11',
					'type'       => 'select',
				),
				array(
					'type' => 'sectionend',
					'id'   => 'alg_wc_cp_btn_opt',
				),
			);

			return parent::get_settings( array_merge( $settings, $new_settings ) );
		}
	}
}