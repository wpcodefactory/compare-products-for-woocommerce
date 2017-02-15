<?php
/**
 * Compare Products for WooCommerce - Shortcodes
 *
 * @version 1.1.0
 * @since   1.1.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Shortcodes' ) ) {

	class Alg_WC_CP_Shortcodes {

		/**
		 * Creates a comparison list table.
		 *
		 * @version 1.1.0
		 * @since   1.1.0
		 */
		public static function create_comparison_list() {
			echo Alg_WC_CP_Comparison_list::create_comparison_list( array(
				'use_modal' => false,
			) );
		}

		/**
		 * Returns class name
		 *
		 * @version 1.1.0
		 * @since   1.1.0
		 * @return type
		 */
		public static function get_class_name() {
			return get_called_class();
		}
	}

}