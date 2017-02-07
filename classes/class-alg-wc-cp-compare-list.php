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

			$compare_list = self::get_list();
			array_push( $compare_list, $product_id );
			$compare_list = array_unique( $compare_list );
			self::set_list( $compare_list );
			return $compare_list;
		}

		/**
		 * Removes a product from compare list.
		 *
		 * @param array $args
		 *
		 * @return array|bool
		 */
		public static function remove_product_from_compare_list( $args = array() ) {
			$args = wp_parse_args( $args, array(
				Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID => null,  // integer
			) );
			$product_id = filter_var( $args[ Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID ], FILTER_VALIDATE_INT );
			if ( ! is_numeric( $product_id ) || get_post_type( $product_id ) != 'product' ) {
				return false;
			}

			$compare_list = self::get_list();
			$index        = array_search( $product_id, $compare_list );
			unset( $compare_list[ $index ] );
			self::set_list( $compare_list );
		}

		/**
		 * Show notification to user after comparing
		 *
		 * @param $compare_response
		 */
		public static function show_notification_after_comparing( $compare_response, $args ){
			if($compare_response!==false){
				$product = new WC_Product( $args[ Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID ] );
				$message = __("<strong>{$product->get_title()}</strong> was successfully added to compare list.", 'alg-wc-compare-products' );
				$compare_list_link = __("<a class='alg-wc-cp-open-modal button wc-forward' href='#'>View Compare list</a>", 'alg-wc-compare-products' );
				wc_add_notice( "{$message}{$compare_list_link}", 'success' );
			}else{
				wc_add_notice( __( 'Sorry, Some error occurred. Please, try again later.', 'alg-wc-compare-products' ), 'error' );
			}
		}

		/**
		 * Sets the compare list
		 *
		 * @return array
		 */
		public static function set_list( $list = array() ) {
			$compare_list = isset( $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] ) ? $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] : array();
			$_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] = $list;
			return $compare_list;
		}

		/**
		 * Gets all products that are in the compare list
		 *
		 * @return array
		 */
		public static function get_list(){
			$compare_list = isset( $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] ) ? $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] : array();
			return $compare_list;
		}

		/**
		 * Show compare list
		 *
		 * @param $response
		 */
		public static function show_compare_list() {
			$compare_list = Alg_WC_CP_Compare_list::get_list();

			$the_query = new WP_Query( array(
				'post_type'      => 'product',
				'posts_per_page' => - 1,
				'post__in'       => $compare_list,
				'orderby'        => 'post__in',
				'order'          => 'asc'
			) );
			$params = array(
				'the_query' => $the_query
			);
			echo alg_wc_cp_locate_template( 'compare-list.php', $params );

			$compare_list_label          = __( "Compare list", "alg-wc-compare-products" );
			$compare_list_subtitle_label = __( "Compare your items", "alg-wc-compare-products" );

			echo
			"
			<script>
				jQuery(function ($) {
					function openModal(){
						$('#iziModal').iziModal({
					        title: '{$compare_list_label}',
					        subtitle:'{$compare_list_subtitle_label}',
					        icon:'fa fa-exchange',
					        headerColor: '#666666',
					        zindex:999999,
					        history:false,
					        fullscreen: true,
					        padding:18,
						    autoOpen: 1,
					    });	
					}
					$('.alg-wc-cp-open-modal').on('click',openModal);
					openModal();
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