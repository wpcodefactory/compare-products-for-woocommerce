<?php
/**
 * Compare products for WooCommerce - Buttons settings
 *
 * @version 1.1.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Settings_Comparison_List' ) ) {

	class Alg_WC_CP_Settings_Comparison_List extends Alg_WC_CP_Settings_Section {

		const OPTION_COLUMNS       = 'alg_wc_cp_cl_cols';
		const OPTION_FIELD_IMAGE  = 'alg_wc_cp_cl_field_image';
		const OPTION_FIELD_TITLE  = 'alg_wc_cp_cl_field_title';


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
		 * @version 1.1.0
		 * @since   1.0.0
		 */
		function get_settings( $settings = null ) {
			$fields = Alg_WC_CP_Comparison_list::get_fields();
			$default_fields = array_slice($fields, 0, 3);

			// Settings
			$new_settings = array(

				// General
				array(
					'title'     => __( 'General options', 'alg-wc-compare-products' ),
					'type'      => 'title',
					'id'        => 'alg_wc_cp_cl_opt',
				),
				array(
					'title'     => __( 'Image', 'alg-wc-compare-products' ),
					'desc'      => __( 'Enables product image on product column', 'alg-wc-compare-products' ),
					'id'        => self::OPTION_FIELD_IMAGE,
					'default'   => 'yes',
					'type'      => 'checkbox',
				),
				array(
					'title'     => __( 'Title', 'alg-wc-compare-products' ),
					'desc'      => __( 'Enables product title on product column', 'alg-wc-compare-products' ),
					'id'        => self::OPTION_FIELD_TITLE,
					'default'   => 'yes',
					'type'      => 'checkbox',
				),
				array(
					'type'      => 'sectionend',
					'id'        => 'alg_wc_cp_cl_opt',
				),

				// Columns
				array(
					'title'     => __( 'Columns', 'alg-wc-compare-products' ),
					'desc'      => __( 'Columns of the comparison table', 'alg-wc-compare-products' ),
					'type'      => 'title',
					'id'        => 'alg_wc_cp_cl_cols_opt',
				),
				array(
					'title'     => __( 'Columns', 'alg-wc-compare-products' ),
					'desc'      => __( 'What columns do you want to show on comparison list?', 'alg-wc-compare-products' ),
					'desc_tip'  =>  __( 'You can drag and drop columns to put them in any order you want', 'alg-wc-compare-products' ),
					'id'        => self::OPTION_COLUMNS,
					'options'   => $fields,
					'default'   => array_keys($default_fields),
					'class'     => 'selectize_drag_drop',
					'type'      => 'multiselect',
				),
				array(
					'type'      => 'sectionend',
					'id'        => 'alg_wc_cp_cl_cols_opt',
				),
			);

			return parent::get_settings( array_merge( $settings, $new_settings ) );
		}
	}

}