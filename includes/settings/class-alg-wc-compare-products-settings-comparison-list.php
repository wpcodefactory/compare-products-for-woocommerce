<?php
/**
 * Compare Products for WooCommerce - Comparison List Section Settings
 *
 * @version 2.1.0
 * @since   2.0.0
 *
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Compare_Products_Settings_Comparison_List' ) ) :

class Alg_WC_Compare_Products_Settings_Comparison_List extends Alg_WC_Compare_Products_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function __construct() {
		$this->id   = 'comparison_list';
		$this->desc = __( 'Comparison List', 'compare-products-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function get_settings() {

		$fields         = Alg_WC_CP_Comparison_List::get_fields();
		$default_fields = array_slice( $fields, 0, 3 );

		$pages_pretty   = array( '' => __( 'None', 'compare-products-for-woocommerce' ) );
		$pages          = get_pages( array() );
		foreach ( $pages as $page ) {
			$pages_pretty[ $page->ID ] = $page->post_title;
		}

		$comparison_list_settings = array(
			array(
				'title'    => __( 'Comparison List Options', 'compare-products-for-woocommerce' ),
				'desc'     => __( 'Options regarding the comparison list.', 'compare-products-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_compare_products_comparison_list_options',
			),
			array(
				'title'    => __( 'Modal', 'compare-products-for-woocommerce' ),
				'desc'     => __( 'Enable', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Enables a popup that shows the comparison list.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_cl_use_modal',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'desc'     => __( 'Title', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Title for the modal comparison list.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_cl_modal_title',
				'default'  => __( 'Comparison List', 'compare-products-for-woocommerce' ),
				'type'     => 'text',
			),
			array(
				'desc'     => __( 'Subtitle', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Subtitle for the modal comparison list.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_cl_modal_subtitle',
				'default'  =>  __( 'Compare your items.', 'compare-products-for-woocommerce' ),
				'type'     => 'text',
			),
			array(
				'title'    => __( 'Page', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'A page that displays the comparison list.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_page_id',
				'default'  => Alg_WC_CP_Comparison_List::get_comparison_list_page_id(),
				'options'  => $pages_pretty,
				'class'    => 'chosen_select',
				'type'     => 'select',
			),
			array(
				'title'    => __( 'Widget', 'compare-products-for-woocommerce' ),
				'desc'     => __( 'Create', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Creates a widget showing a link pointing to the comparison list.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_cl_widget_link',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Empty list text', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Text displayed when comparison list is empty.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_cl_empty_text',
				'default'  => __( 'The comparison list is empty', 'compare-products-for-woocommerce' ),
				'type'     => 'textarea',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_compare_products_comparison_list_options',
			),
		);

		$comparison_list_columns_settings = array(
			array(
				'title'    => __( 'Columns', 'compare-products-for-woocommerce' ),
				'desc'     => __( 'Options regarding comparison table columns.', 'compare-products-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_compare_products_comparison_list_columns_options',
			),
			array(
				'title'    => __( 'Image', 'compare-products-for-woocommerce' ),
				'desc'     => __( 'Enable', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Enables product image on product column.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_cl_field_image',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Title', 'compare-products-for-woocommerce' ),
				'desc'     => __( 'Enable', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Enables product title on product column.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_cl_field_title',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Columns', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'What columns do you want to show on comparison list?', 'compare-products-for-woocommerce' ) . ' ' .
					__( 'You can drag and drop columns to put them in any order you want.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_cl_cols',
				'options'  => $fields,
				'default'  => array_keys( $default_fields ),
				'class'    => 'selectize_drag_drop',
				'type'     => 'multiselect',
			),
			array(
				'title'    => __( 'Sorter', 'compare-products-for-woocommerce' ),
				'desc'     => __( 'Enable', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Enables a column sorter button on front-end allowing users to sort based in any field.', 'compare-products-for-woocommerce' ) .
					apply_filters( 'alg_wc_compare_products_settings', ' ' . sprintf( 'You will need %s plugin to enable this option.',
						'<a target="_blank" href="https://wpfactory.com/item/compare-products-woocommerce/">Compare Products for WooCommerce Pro</a>' ) ),
				'id'       => 'alg_wc_cp_cl_fields_sorter',
				'default'  => 'no',
				'type'     => 'checkbox',
				'custom_attributes' => apply_filters( 'alg_wc_compare_products_settings', array( 'disabled' => 'disabled' ) ),
			),
			array(
				'title'    => __( 'Organizer', 'compare-products-for-woocommerce' ),
				'desc'     => __( 'Enable', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Allows users on front-end to choose what columns will be visible.', 'compare-products-for-woocommerce' ) .
					apply_filters( 'alg_wc_compare_products_settings', ' ' . sprintf( 'You will need %s plugin to enable this option.',
						'<a target="_blank" href="https://wpfactory.com/item/compare-products-woocommerce/">Compare Products for WooCommerce Pro</a>' ) ),
				'id'       => 'alg_wc_cp_cl_fields_organizer',
				'default'  => 'no',
				'type'     => 'checkbox',
				'custom_attributes' => apply_filters( 'alg_wc_compare_products_settings', array( 'disabled' => 'disabled' ) ),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_compare_products_comparison_list_columns_options',
			),
		);

		return array_merge( $comparison_list_settings, $comparison_list_columns_settings );
	}

}

endif;

return new Alg_WC_Compare_Products_Settings_Comparison_List();
