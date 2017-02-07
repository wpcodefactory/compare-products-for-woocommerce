<?php
/**
 * Compare Products for WooCommerce - Query vars
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Query_Vars' ) ) {

	class Alg_WC_CP_Query_Vars {

		/**
		 * Query var for creating an action.
		 *
		 * Values can be 'compare'
		 *
		 * @since   1.0.0
		 */
		const ACTION = 'alg_wc_cp_action';

		/**
		 * Query var for the product id to compare.
		 *
		 * @since   1.0.0
		 */
		const COMPARE_PRODUCT_ID = 'alg_wc_cp_pid';

	}

}