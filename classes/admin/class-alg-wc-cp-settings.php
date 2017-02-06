<?php
/**
 * Compare products for WooCommerce - Settings
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Settings' ) ) :

	class Alg_WC_CP_Settings extends WC_Settings_Page {

		/**
		 * Constructor.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function __construct() {
			$this->id    = 'alg_wc_cp';
			$this->label = __( 'Compare products', 'alg-wc-compare-products' );
			parent::__construct();
		}

		/**
		 * get_settings.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function get_settings() {
			global $current_section;

			return apply_filters( 'woocommerce_get_settings_' . $this->id . '_' . $current_section, array() );
		}

	}

endif;