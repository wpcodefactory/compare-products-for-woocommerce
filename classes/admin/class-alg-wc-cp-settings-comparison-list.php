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

if ( ! class_exists( 'Alg_WC_CP_Settings_Comparison_List' ) ) {

	class Alg_WC_CP_Settings_Comparison_List extends Alg_WC_CP_Settings_Section {

		const OPTION_FIELDS = 'alg_wc_cp_cl_fields';

		/**
		 * Constructor.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function __construct( $handle_autoload = true ) {
			$this->id   = 'comparison_list';
			$this->desc = __( 'Comparison List', 'alg-wc-compare-products' );
			parent::__construct( $handle_autoload );
		}

		/**
		 * get_settings.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function get_settings( $settings = null ) {
			// Default fields
			$fields = array(
				'image'       => __( 'Image', 'alg-wc-compare-products' ),
				'price'       => __( 'Price', 'alg-wc-compare-products' ),
				'add-to-cart' => __( 'Add to cart button', 'alg-wc-compare-products' ),
				'description' => __( 'Description', 'alg-wc-compare-products' ),
				'stock'       => __( 'Availability', 'alg-wc-compare-products' ),
				'weight'      => __( 'Weight', 'alg-wc-compare-products' ),
				'dimensions'  => __( 'Dimensions', 'alg-wc-compare-products' ),
			);

			// WooCommere attributes
			$attributes = wc_get_attribute_taxonomies();
			$attributes_pretty = array();
			foreach ( $attributes as $attribute ) {
				$attributes_pretty[ wc_attribute_taxonomy_name( $attribute->attribute_name ) ] = $attribute->attribute_label;
			}
			$fields = array_merge( $fields, $attributes_pretty );

			// Settings
			$new_settings = array(
				array(
					'title'     => __( 'General options', 'alg-wc-compare-products' ),
					'type'      => 'title',
					'id'        => 'alg_wc_cp_cl_opt',
				),
				array(
					'title'     => __( 'Fields', 'alg-wc-compare-products' ),
					'desc'      => __( 'What fields do you want to show on comparison list?', 'alg-wc-compare-products' ),
					'id'        => self::OPTION_FIELDS,
					'options'   => $fields,
					'class'     => 'chosen_select',
					'type'      => 'multiselect',
				),
				array(
					'type'      => 'sectionend',
					'id'        => 'alg_wc_cp_cl_opt',
				),
			);

			return parent::get_settings( array_merge( $settings, $new_settings ) );
		}
	}

}