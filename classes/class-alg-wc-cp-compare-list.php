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

if ( ! class_exists( 'Alg_WC_CP_Compare_list' ) ) {

	class Alg_WC_CP_Compare_list {


		/**
		 * Adds a product to compare list.
		 *
		 * @param array $args
		 *
		 * @return array|bool
		 */
		public static function add_product_to_compare_list( $args = array() ) {
			$args = wp_parse_args( $args, array(
				Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID => null,  // integer
			) );
			$product_id = filter_var( $args[ Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID ], FILTER_VALIDATE_INT );
			if ( ! is_numeric( $product_id ) || get_post_type( $product_id ) != 'product' ) {
				return false;
			}

			$compare_list = isset( $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] ) ? $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] : array();
			array_push( $compare_list, $product_id );
			$_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] = $compare_list;
			return $compare_list;
		}

		/**
		 * Show compare list
		 *
		 * @param $response
		 */
		public static function show_compare_list( $response ) {


			$params = array();
			echo alg_wc_cp_locate_template( 'compare-list.php', $params );

			echo
			"
			<script>
			    jQuery('#iziModal').iziModal({
			    	title: 'Compare list',
			    	subtitle:'Compare your items',
			    	icon:'fa fa-exchange',
			    	headerColor: '#666666',
			    	fullscreen: true,
			    	padding:18,
				    autoOpen: 1,
			    });			
			</script>
			";
		}

		/**
		 * Returns class name
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @return type
		 */
		public static function get_class_name() {
			return get_called_class();
		}

	}

};