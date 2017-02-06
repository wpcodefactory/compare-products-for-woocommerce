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
		const OPTION_DEFAULT_BTN_POSITION            = 'alg_wc_cp_default_btn_pos';
		const OPTION_DEFAULT_BTN_PRIORITY            = 'alg_wc_cp_default_btn_priority';

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
					'type' => 'sectionend',
					'id'   => 'alg_wc_cp_btn_opt',
				),
			);

			return parent::get_settings( array_merge( $settings, $new_settings ) );
		}
	}
}