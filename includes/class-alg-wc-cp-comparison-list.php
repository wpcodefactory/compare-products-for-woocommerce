<?php
/**
 * Compare products for WooCommerce - Comparison list
 *
 * @version 2.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Comparison_List' ) ) :

class Alg_WC_CP_Comparison_List {

	public static $add_product_response    = false;
	public static $remove_product_response = false;

	/**
	 * Adds a product to comparison list.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 * @param   array $args
	 * @return  array|bool
	 */
	static function add_product_to_comparison_list( $args = array() ) {
		// Product ID
		$args       = wp_parse_args( $args, array( 'alg_wc_cp_pid' => null ) ); // integer
		$product_id = filter_var( $args['alg_wc_cp_pid'], FILTER_VALIDATE_INT );
		if ( ! is_numeric( $product_id ) || 'product' != get_post_type( $product_id ) ) {
			self::$add_product_response = false;
			return false;
		}
		// Add
		$compare_list = self::get_list();
		array_push( $compare_list, $product_id );
		$compare_list = array_unique( $compare_list );
		self::set_list( $compare_list );
		self::$add_product_response = $compare_list;
		return $compare_list;
	}

	/**
	 * Gets comparison list default fields.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @return  array
	 */
	static function get_default_fields( $do_return_keys = false ) {
		$default_fields = array(
			'the-product' => __( 'Product', 'compare-products-for-woocommerce' ),
			'price'       => __( 'Price', 'compare-products-for-woocommerce' ),
			'weight'      => __( 'Weight', 'compare-products-for-woocommerce' ),
		);
		return ( $do_return_keys ? array_keys( $default_fields ) : $default_fields );
	}

	/**
	 * Gets comparison list fields.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 * @param   bool $getWcAttributes     Gets WooCommerce attributes too
	 * @param   bool $reorder_based_on_db Reorder fields based on database
	 * @return  array
	 */
	static function get_fields( $getWcAttributes = true, $reorder_based_on_db = true ) {
		// Default fields
		$default_fields = self::get_default_fields();
		// Other fields
		$fields = array(
			'add-to-cart' => __( 'Add to cart button', 'compare-products-for-woocommerce' ),
			'description' => __( 'Description', 'compare-products-for-woocommerce' ),
			'stock'       => __( 'Availability', 'compare-products-for-woocommerce' ),
			'dimensions'  => __( 'Dimensions', 'compare-products-for-woocommerce' ),
		);
		$fields = array_merge( $default_fields, $fields );
		// WooCommerce attributes
		if ( $getWcAttributes ) {
			$attributes_pretty = self::get_woocommerce_fields();
			$fields            = array_merge( $fields, $attributes_pretty );
		}
		// Reorder options if needed
		if ( $reorder_based_on_db ) {
			$db_fields = get_option( 'alg_wc_cp_cl_cols', array_keys( $default_fields ) );
			if ( ! empty( $db_fields ) ) {
				$fields = array_merge( array_flip( $db_fields ), $fields );
			}
		}
		return $fields;
	}

	/**
	 * Gets only the WooCommerce attributes that will be in Comparison List.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  array
	 */
	static function get_woocommerce_fields(){
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
	 * @version 2.0.0
	 * @since   1.0.0
	 * @param   array $args
	 * @return  array|bool
	 */
	static function remove_product_from_comparison_list( $args = array() ) {
		// Product ID
		$args       = wp_parse_args( $args, array( 'alg_wc_cp_pid' => null ) ); // integer
		$product_id = filter_var( $args['alg_wc_cp_pid'], FILTER_VALIDATE_INT );
		if ( ! is_numeric( $product_id ) || 'product' !=  get_post_type( $product_id ) ) {
			self::$remove_product_response=false;
			return false;
		}
		// Remove
		$compare_list = self::get_list();
		$index        = array_search( $product_id, $compare_list );
		unset( $compare_list[ $index ] );
		self::$remove_product_response = $compare_list;
		self::set_list( $compare_list );
	}

	/**
	 * Creates a link pointing to comparison list.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	static function create_comparison_list_link( $args = array() ) {
		$args = wp_parse_args( $args, array( 'link_label' => __( 'View comparison list', 'compare-products-for-woocommerce' ) ) );
		if ( 'yes' === get_option( 'alg_wc_cp_cl_use_modal', 'yes' ) ) {
			global $wp;
			$original_link = ( is_shop() ? get_post_type_archive_link( 'product' ) : get_permalink( get_the_ID() ) );
			$final_link    = add_query_arg( array( 'alg_wc_cp_modal' => 'open' ), $original_link );
		} else {
			$original_link = get_permalink( Alg_WC_CP_Comparison_List::get_comparison_list_page_id() );
			$final_link    = $original_link;
		}
		return sprintf(
			"<a class='alg-wc-cp-open-modal button wc-forward' href='%s'>%s</a>",
			$final_link,
			$args['link_label']
		);
	}

	/**
	 * Show notification to user after comparing.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 * @param   $compare_response
	 */
	static function show_notification_after_comparing( $args ) {
		$page_id = Alg_WC_CP_Comparison_List::get_comparison_list_page_id();

		if ( false !== self::$add_product_response ) {
			$product           = new WC_Product( $args['alg_wc_cp_pid'] );
			$message           = sprintf( __( "%s was successfully added to comparison list.", 'compare-products-for-woocommerce' ), "<strong>{$product->get_title()}</strong>" );
			$compare_list_link = self::create_comparison_list_link();
			if ( ! empty( $page_id ) ) {
				alg_wc_cp_wc_add_notice( "{$message}{$compare_list_link}", 'success' );
			} else {
				alg_wc_cp_wc_add_notice( "{$message}", 'success' );
			}
		} elseif ( false !== self::$remove_product_response ) {
			$product           = new WC_Product( $args['alg_wc_cp_pid'] );
			$message           = sprintf( __( "%s was successfully removed from comparison list.", 'compare-products-for-woocommerce' ), "<strong>{$product->get_title()}</strong>" );
			$compare_list_link = self::create_comparison_list_link();
			if ( ! empty( $page_id ) ) {
				alg_wc_cp_wc_add_notice( "{$message}{$compare_list_link}", 'success' );
			} else {
				alg_wc_cp_wc_add_notice( "{$message}", 'success' );
			}
		} else {
			alg_wc_cp_wc_add_notice( __( 'Sorry, some error occurred. Please try again later.', 'compare-products-for-woocommerce' ), 'error' );
		}
	}

	/**
	 * Sets the compare list.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 * @return  array
	 */
	static function set_list( $list = array() ) {
		$compare_list = isset( $_SESSION['alg-wc-cp-list'] ) ? $_SESSION['alg-wc-cp-list'] : array();
		$_SESSION[ 'alg-wc-cp-list' ] = $list;
		return $compare_list;
	}

	/**
	 * Gets all products that are in the comparison list.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 * @return  array
	 */
	static function get_list(){
		$compare_list = isset( $_SESSION['alg-wc-cp-list'] ) ? $_SESSION['alg-wc-cp-list'] : array();
		return $compare_list;
	}

	/**
	 * Creates a comparison list page.
	 *
	 * Create comparison list page with a shortcode used for displaying items (this page is only created if it doesn't exist).
	 *
	 * @version 2.0.0
	 * @since   1.1.0
	 */
	static function create_page() {
		$previous_page_id = self::get_comparison_list_page_id();
		$previous_page    = null;
		if ( false !== $previous_page_id ) {
			$previous_page = get_post( $previous_page_id );
		}
		if ( null == $previous_page ) {
			$post = array(
				'post_title'     => __( 'Comparison List', 'compare-products-for-woocommerce' ),
				'post_type'      => 'page',
				'post_content'   => '[alg_wc_cp_table]',
				'post_status'    => 'publish',
				'post_author'    => 1,
				'comment_status' => 'closed',
			);
			// Insert the post into the database.
			$page_id = wp_insert_post( $post );
			self::set_comparison_list_page_id( $page_id );
		}
	}

	/**
	 * Set comparison list page id.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @param   $page_id
	 * @return  bool
	 */
	static function set_comparison_list_page_id( $page_id ) {
		return update_option( 'alg_wc_cp_page_id', $page_id );
	}

	/**
	 * Get comparison list page id.
	 *
	 * @version 2.0.0
	 * @since   1.1.0
	 * @return  mixed|void
	 */
	static function get_comparison_list_page_id() {
		return get_option( 'alg_wc_cp_page_id', '' );
	}

	/**
	 * Deletes the comparison list page.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	static function delete_page() {
		$previous_page_id = self::get_comparison_list_page_id();
		$previous_page    = null;
		if ( false !== $previous_page_id ) {
			$previous_page = get_post( $previous_page_id );
		}

		if ( null != $previous_page ) {
			wp_delete_post( $previous_page_id, true );
		}
	}

	/**
	 * Creates compare list.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	static function create_comparison_list( $args = array() ){
		$args         = wp_parse_args( $args, array( 'use_modal' => true ) );
		$compare_list = Alg_WC_CP_Comparison_List::get_list();
		$the_query    = null;
		if ( ! empty( $compare_list ) ) {
			$the_query = new WP_Query( array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
				'post__in'       => $compare_list,
				'orderby'        => 'post__in',
				'order'          => 'asc',
			) );
		}
		$fields = array(
			'image'       => __( 'Image', 'compare-products-for-woocommerce' ),
			'price'       => __( 'Price', 'compare-products-for-woocommerce' ),
			'add-to-cart' => __( 'Add to cart button', 'compare-products-for-woocommerce' ),
			'description' => __( 'Description', 'compare-products-for-woocommerce' ),
			'stock'       => __( 'Availability', 'compare-products-for-woocommerce' ),
			'weight'      => __( 'Weight', 'compare-products-for-woocommerce' ),
			'dimensions'  => __( 'Dimensions', 'compare-products-for-woocommerce' ),
		);
		$fields = get_option( 'alg_wc_cp_cl_cols', self::get_default_fields( true ) );
		$params = array(
			'the_query'  => $the_query,
			'show_image' => ( 'yes' === get_option( 'alg_wc_cp_cl_field_image', 'yes' ) ),
			'show_title' => ( 'yes' === get_option( 'alg_wc_cp_cl_field_title', 'yes' ) ),
			'fields'     => array_flip( $fields ),
			'list_class' => array( 'alg-wc-cp-list' ),
		);
		$params = array_merge( $params, $args );
		return alg_wc_cp_locate_template( 'comparison-list.php', $params );
	}

	/**
	 * Show compare list.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 * @param   $response
	 */
	static function show_comparison_list() {
		$compare_list_label          = get_option( 'alg_wc_cp_cl_modal_title',    __( 'Comparison List', 'compare-products-for-woocommerce' ) );
		$compare_list_subtitle_label = get_option( 'alg_wc_cp_cl_modal_subtitle', __( 'Compare your items.', 'compare-products-for-woocommerce' ) );
		$js = "
			jQuery(document).ready(function($){
				var isModalCreated=false;
				function openModal(){
					if(!isModalCreated){
						$('#iziModal').iziModal({
							title: '{$compare_list_label}',
							subtitle:'{$compare_list_subtitle_label}',
							icon:'fas fa-exchange-alt',
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

}

endif;
