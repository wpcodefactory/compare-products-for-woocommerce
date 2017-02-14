<?php
/**
 * Compare products for WooCommerce - General Section Settings
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Settings_General' ) ) {

	class Alg_WC_CP_Settings_General extends Alg_WC_CP_Settings_Section {

		const OPTION_ENABLE_PLUGIN = 'alg_wc_cp_enable';
		const OPTION_FONT_AWESOME  = 'alg_wc_cp_fontawesome';

		/**
		 * Constructor.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function __construct( $handle_autoload = true ) {
			$this->id   = '';
			$this->desc = __( 'General', 'alg-wc-compare-products' );
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
					'title'    => __( 'General Options', 'alg-wc-compare-products' ),
					'type'     => 'title',
					'id'       => 'alg_wc_cp_opt',
				),
				array(
					'title'    => __( 'Enable Plugin', 'alg-wc-compare-products' ),
					'desc'     => __( 'Enable "Compare Products for WooCommerce" plugin', 'alg-wc-compare-products' ),
					'id'       => self::OPTION_ENABLE_PLUGIN,
					'default'  => 'yes',
					'type'     => 'checkbox',
				),
				array(
					'title'    => __( 'Load FontAwesome', 'alg-wc-compare-products' ),
					'desc'     => __( 'Load most recent version of Font Awesome', 'alg-wc-compare-products' ),
					'desc_tip' => __( 'Only mark this if you are not loading Font Awesome nowhere else. Font Awesome is responsible for creating icons', 'alg-wc-compare-products' ),
					'id'       => self::OPTION_FONT_AWESOME,
					'default'  => 'yes',
					'type'     => 'checkbox',
				),
				array(
					'type'     => 'sectionend',
					'id'       => 'alg_wc_cp_opt',
				),
			);

			return parent::get_settings( array_merge( $settings, $new_settings ) );
		}

	}
}