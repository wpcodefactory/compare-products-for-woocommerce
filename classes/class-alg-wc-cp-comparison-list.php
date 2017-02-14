<?php
/**
 * Compare products for WooCommerce - Comparison list
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Comparison_list' ) ) {

	class Alg_WC_CP_Comparison_list {

		public static $add_product_response    = false;
		public static $remove_product_response = false;

		/**
		 * Adds a product to comparison list.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @param array $args
		 * @return array|bool
		 */
		public static function add_product_to_comparison_list( $args = array() ) {
			$args = wp_parse_args( $args, array(
				Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID => null,  // integer
			) );
			$product_id = filter_var( $args[ Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID ], FILTER_VALIDATE_INT );
			if ( ! is_numeric( $product_id ) || get_post_type( $product_id ) != 'product' ) {
				self::$add_product_response=false;
				return false;
			}

			$compare_list = self::get_list();
			array_push( $compare_list, $product_id );
			$compare_list = array_unique( $compare_list );
			self::set_list( $compare_list );
			self::$add_product_response = $compare_list;
			return $compare_list;
		}

		/**
		 * Gets comparison list fields
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @param bool $getWcAttributes
		 * @return array
		 */
		public static function get_fields( $getWcAttributes = true, $reorder_based_on_db = true ) {
			// Default fields
			$default_fields = array(
				'image'       => __( 'Image', 'alg-wc-compare-products' ),
				'price'       => __( 'Price', 'alg-wc-compare-products' ),
				'weight'      => __( 'Weight', 'alg-wc-compare-products' ),
			);

			// Other fields
			$fields = array(
				'add-to-cart' => __( 'Add to cart button', 'alg-wc-compare-products' ),
				'description' => __( 'Description', 'alg-wc-compare-products' ),
				'stock'       => __( 'Availability', 'alg-wc-compare-products' ),
				'dimensions'  => __( 'Dimensions', 'alg-wc-compare-products' ),
			);
			$fields = array_merge( $default_fields, $fields );

			// WooCommerce attributes
			if ( $getWcAttributes ) {
				$attributes_pretty = self::get_woocommerce_fields();
				$fields = array_merge( $fields, $attributes_pretty );
			}

			// Reorder options if needed
			if( $reorder_based_on_db ){
				$db_fields = get_option( self::OPTION_FIELDS );
				if ( ! empty( $db_fields ) ) {
					$fields = array_merge( array_flip( $db_fields ), $fields );
				}
			}

			return $fields;
		}

		/**
		 * Gets only the WooCommerce attributes that will be in Comparison List
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @return array
		 */
		public static function get_woocommerce_fields(){
			// WooCommere attributes
			$attributes        = wc_get_attribute_taxonomies();
			$attributes_pretty = array();
			foreach ( $attributes as $attribute ) {
				$attributes_pretty[ wc_attribute_taxonomy_name( $attribute->attribute_name ) ] = $attribute->attribute_label;
			}
			return $attributes_pretty;
		}

		/**
		 * Removes a product from compare list.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @param array $args
		 * @return array|bool
		 */
		public static function remove_product_from_comparison_list( $args = array() ) {
			$args = wp_parse_args( $args, array(
				Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID => null,  // integer
			) );
			$product_id = filter_var( $args[ Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID ], FILTER_VALIDATE_INT );
			if ( ! is_numeric( $product_id ) || get_post_type( $product_id ) != 'product' ) {
				self::$remove_product_response=false;
				return false;
			}

			$compare_list = self::get_list();
			$index        = array_search( $product_id, $compare_list );
			unset( $compare_list[ $index ] );
			self::$remove_product_response=$compare_list;
			self::set_list( $compare_list );
		}

		/**
		 * Show notification to user after comparing
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @param $compare_response
		 */
		public static function show_notification_after_comparing( $args ) {
			if ( self::$add_product_response !== false ) {
				$product           = new WC_Product( $args[ Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID ] );
				$message           = __( "<strong>{$product->get_title()}</strong> was successfully added to comparison list.", 'alg-wc-compare-products' );
				$compare_list_link = __( "<a class='alg-wc-cp-open-modal button wc-forward' href='#'>View comparison list</a>", 'alg-wc-compare-products' );
				wc_add_notice( "{$message}{$compare_list_link}", 'success' );
			} else if ( self::$remove_product_response !== false ) {
				$product           = new WC_Product( $args[ Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID ] );
				$message           = __( "<strong>{$product->get_title()}</strong> was successfully removed from comparison list.", 'alg-wc-compare-products' );
				$compare_list_link = __( "<a class='alg-wc-cp-open-modal button wc-forward' href='#'>View comparison list</a>", 'alg-wc-compare-products' );
				wc_add_notice( "{$message}{$compare_list_link}", 'success' );
			} else {
				wc_add_notice( __( 'Sorry, Some error occurred. Please, try again later.', 'alg-wc-compare-products' ), 'error' );
			}
		}

		/**
		 * Sets the compare list
		 *
		 * @version 1.0.0
		 * @since   1.0.0
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
		 * @version 1.0.0
		 * @since   1.0.0
		 * @return array
		 */
		public static function get_list(){
			$compare_list = isset( $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] ) ? $_SESSION[ Alg_WC_CP_Session::VAR_COMPARE_LIST ] : array();
			return $compare_list;
		}

		/**
		 * Creates compare list.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public static function create_comparison_list(){
			$compare_list = Alg_WC_CP_Comparison_list::get_list();

			$the_query = null;
			if ( ! empty( $compare_list ) ) {
				$the_query = new WP_Query( array(
					'post_type'      => 'product',
					'posts_per_page' => - 1,
					'post__in'       => $compare_list,
					'orderby'        => 'post__in',
					'order'          => 'asc',
				) );
			}

			$fields = array(
				'image'       => __( 'Image', 'alg-wc-compare-products' ),
				'price'       => __( 'Price', 'alg-wc-compare-products' ),
				'add-to-cart' => __( 'Add to cart button', 'alg-wc-compare-products' ),
				'description' => __( 'Description', 'alg-wc-compare-products' ),
				'stock'       => __( 'Availability', 'alg-wc-compare-products' ),
				'weight'      => __( 'Weight', 'alg-wc-compare-products' ),
				'dimensions'  => __( 'Dimensions', 'alg-wc-compare-products' ),
			);

			$fields = get_option( Alg_WC_CP_Settings_Comparison_List::OPTION_FIELDS );
			$params = array(
				'the_query' => $the_query,
				'fields'    => array_flip( $fields ),
			);
			return alg_wc_cp_locate_template( 'comparison-list.php', $params );
		}

		/**
		 * Show compare list
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @param $response
		 */
		public static function show_comparison_list() {

			$compare_list_label          = __( "Comparison list", "alg-wc-compare-products" );
			$compare_list_subtitle_label = __( "Compare your items", "alg-wc-compare-products" );

			$js=
			"			
				jQuery(document).ready(function($){
					var isModalCreated=false;
					function openModal(){
						if(!isModalCreated){
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
					        isModalCreated=true;
						}else{
							$('#iziModal').iziModal('open');
						}						
					}
					$('.alg-wc-cp-open-modal').on('click',function(e){
						e.preventDefault();
						openModal();
					});
					openModal();
				});
			
			";

			wp_add_inline_script( 'alg-wc-cp-izimodal', $js );
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