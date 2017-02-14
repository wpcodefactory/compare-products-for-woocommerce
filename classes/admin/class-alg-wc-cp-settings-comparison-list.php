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
		const OPTION_FIELDS_STRING = 'alg_wc_cp_cl_fields_str';

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
			$fields = Alg_WC_CP_Comparison_list::get_fields();
			$default_fields = array_slice($fields, 0, 3);

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
					'desc_tip'  =>  __( 'You can drag and drop fields to put it in any order you want', 'alg-wc-compare-products' ),
					'id'        => self::OPTION_FIELDS,
					'options'   => $fields,
					'default'   => array_keys($default_fields),
					'class'     => 'selectize_drag_drop',
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