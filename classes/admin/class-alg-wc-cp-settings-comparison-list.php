<?php
/**
 * Compare products for WooCommerce - Buttons settings
 *
 * @version 1.1.2
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Settings_Comparison_List' ) ) {

	class Alg_WC_CP_Settings_Comparison_List extends Alg_WC_CP_Settings_Section {

		const OPTION_COLUMNS              = 'alg_wc_cp_cl_cols';
		const OPTION_FIELD_IMAGE          = 'alg_wc_cp_cl_field_image';
		const OPTION_FIELD_TITLE          = 'alg_wc_cp_cl_field_title';
		const OPTION_USE_MODAL            = 'alg_wc_cp_cl_use_modal';
		const OPTION_COMPARISON_LIST_PAGE = 'alg_wc_cp_page_id';
		const OPTION_WIDGET_LINK          = 'alg_wc_cp_cl_widget_link';

		/**
		 * Constructor.
		 *
		 * @version 1.1.2
		 * @since   1.0.0
		 */
		function __construct( $handle_autoload = true ) {
			$this->id   = 'comparison_list';
			$this->desc = __( 'Comparison List', 'compare-products-for-woocommerce' );
			parent::__construct( $handle_autoload );
		}

		/**
		 * get_settings.
		 *
		 * @version 1.1.2
		 * @since   1.0.0
		 */
		function get_settings( $settings = null ) {
			$fields = Alg_WC_CP_Comparison_list::get_fields();
			$default_fields = array_slice($fields, 0, 3);

			$pages_pretty = array( '' => __( 'None', 'compare-products-for-woocommerce' ) );
			$pages = get_pages(array(
			));
			foreach ($pages as $page){
				$pages_pretty[$page->ID] = $page->post_title;
			}

			// Settings
			$new_settings = array(

				// General
				array(
					'title'     => __( 'Comparison List Options', 'compare-products-for-woocommerce' ),
					'desc'      => __( 'Options regarding the comparison list', 'compare-products-for-woocommerce' ),
					'type'      => 'title',
					'id'        => 'alg_wc_cp_cl_opt',
				),
				array(
					'title'     => __( 'Modal', 'compare-products-for-woocommerce' ),
					'desc'      => __( 'Enables a popup that shows the comparison list', 'compare-products-for-woocommerce' ),
					'id'        => self::OPTION_USE_MODAL,
					'default'   => 'yes',
					'type'      => 'checkbox',
				),
				array(
					'title'     => __( 'Page', 'compare-products-for-woocommerce' ),
					'desc'      => __( 'A page that displays the comparison list', 'compare-products-for-woocommerce' ),
					'id'        => self::OPTION_COMPARISON_LIST_PAGE,
					'default'   => Alg_WC_CP_Comparison_list::get_comparison_list_page_id(),
					'options'   => $pages_pretty,
					'class'     => 'chosen_select',
					'type'      => 'select',
				),
				array(
					'title'     => __( 'Widget', 'compare-products-for-woocommerce' ),
					'desc'      => __( 'Creates a widget showing a link pointing to the comparison list', 'compare-products-for-woocommerce' ),
					'id'        => self::OPTION_WIDGET_LINK,
					'default'   => 'yes',
					'type'      => 'checkbox',
				),
				array(
					'type'      => 'sectionend',
					'id'        => 'alg_wc_cp_cl_opt',
				),

				// Columns
				array(
					'title'     => __( 'Columns', 'compare-products-for-woocommerce' ),
					'desc'      => __( 'Options regarding comparison table columns', 'compare-products-for-woocommerce' ),
					'type'      => 'title',
					'id'        => 'alg_wc_cp_cl_cols_opt',
				),
				array(
					'title'     => __( 'Image', 'compare-products-for-woocommerce' ),
					'desc'      => __( 'Enables product image on product column', 'compare-products-for-woocommerce' ),
					'id'        => self::OPTION_FIELD_IMAGE,
					'default'   => 'yes',
					'type'      => 'checkbox',
				),
				array(
					'title'     => __( 'Title', 'compare-products-for-woocommerce' ),
					'desc'      => __( 'Enables product title on product column', 'compare-products-for-woocommerce' ),
					'id'        => self::OPTION_FIELD_TITLE,
					'default'   => 'yes',
					'type'      => 'checkbox',
				),
				array(
					'title'     => __( 'Columns', 'compare-products-for-woocommerce' ),
					'desc'      => __( 'What columns do you want to show on comparison list?', 'compare-products-for-woocommerce' ),
					'desc_tip'  =>  __( 'You can drag and drop columns to put them in any order you want', 'compare-products-for-woocommerce' ),
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