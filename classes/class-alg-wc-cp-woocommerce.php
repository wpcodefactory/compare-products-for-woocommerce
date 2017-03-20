<?php
/**
 * Compare Products for WooCommerce - WooCommerce functions
 *
 * @version 1.1.3
 * @since   1.1.3
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Woocommerce' ) ) {

	class Alg_WC_CP_Woocommerce {

		/**
		 * Add and store a notice.
		 *
		 * @version 1.1.3
		 * @since   1.1.3
		 *
		 * @param string $message     The text to display in the notice.
		 * @param string $notice_type The singular name of the notice type - either error, success or notice. [optional]
		 */
		public static function add_notice( $message, $notice_type = 'success' ) {
			if ( ! wc_has_notice( $message, $notice_type ) ) {
				wc_add_notice( $message, $notice_type = 'success' );
			}
		}
	}
}