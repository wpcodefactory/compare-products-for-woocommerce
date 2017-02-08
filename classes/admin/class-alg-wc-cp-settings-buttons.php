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
		const OPTION_DEFAULT_BTN_SHOW_ON_LOOP_PAGE   = 'alg_wc_cp_default_btn_loop';
		const OPTION_DEFAULT_BTN_SINGLE_POSITION = 'alg_wc_cp_default_btn_pos';
		const OPTION_DEFAULT_BTN_SINGLE_PRIORITY = 'alg_wc_cp_default_btn_priority';

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
					'title'      => __( 'Position on single', 'alg-wish-list-for-woocommerce' ),
					'desc'       => __( 'Where the button will appear on single product page?', 'alg-wish-list-for-woocommerce' ),
					'desc_tip'   => __( 'Default is On single product summary', 'alg-wish-list-for-woocommerce' ),
					'id'         => self::OPTION_DEFAULT_BTN_SINGLE_POSITION,
					'default'    => 'woocommerce_single_product_summary',
					'type'       => 'select',
					'options'    => array(
						'woocommerce_single_product_summary'        => __( 'On single product summary', 'alg-wish-list-for-woocommerce' ),
						'woocommerce_before_single_product_summary' => __( 'Before single product summary', 'alg-wish-list-for-woocommerce' ),
						'woocommerce_after_single_product_summary'  => __( 'After single product summary', 'alg-wish-list-for-woocommerce' ),
						'woocommerce_product_thumbnails'            => __( 'After product thumbnail', 'alg-wish-list-for-woocommerce' ),
					),
				),
				array(
					'title'      => __( 'Priority on single', 'alg-wish-list-for-woocommerce' ),
					'desc'       => __( 'More precise control of where the button will appear on single product page', 'alg-wish-list-for-woocommerce' ),
					'desc_tip'   => __( 'Default is 31, right after "add to cart" button ', 'alg-wish-list-for-woocommerce' ),
					'id'         => self::OPTION_DEFAULT_BTN_SINGLE_PRIORITY,
					'default'    => 31,
					'type'       => 'number',
					'attributes' => array( 'type' => 'number' ),
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