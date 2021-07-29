<?php
/**
 * Compare Products for WooCommerce - Style Section Settings
 *
 * @version 2.0.1
 * @since   2.0.0
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Compare_Products_Settings_Style' ) ) :

class Alg_WC_Compare_Products_Settings_Style extends Alg_WC_Compare_Products_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function __construct() {
		$this->id   = 'style';
		$this->desc = __( 'Style', 'compare-products-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.0.1
	 * @since   2.0.0
	 * @todo    [dev] recheck all titles, descriptions etc. (e.g. 'Default button' to 'Button'?)
	 * @todo    [feature] add (modal) comparison list styling options (e.g. header color etc.)
	 */
	function get_settings() {

		$general_settings = array(
			array(
				'title'    => __( 'Style Options', 'compare-products-for-woocommerce' ),
				'type'     => 'title',
				'desc'     => __( 'Options that can be used to create a custom style.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_general_style_opt',
			),
			array(
				'title'    => __( 'Custom style', 'compare-products-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable section', 'compare-products-for-woocommerce' ) . '</strong>',
				'desc_tip' => __( 'Enables custom style section.', 'compare-products-for-woocommerce' ) .
					apply_filters( 'alg_wc_compare_products_settings', ' ' . sprintf( 'You will need %s plugin to enable this section.',
						'<a target="_blank" href="https://wpfactory.com/item/compare-products-woocommerce/">Compare Products for WooCommerce Pro</a>' ) ),
				'id'       => 'alg_wc_cp_style_enable',
				'default'  => 'no',
				'type'     => 'checkbox',
				'custom_attributes' => apply_filters( 'alg_wc_compare_products_settings', array( 'disabled' => 'disabled' ) ),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_cp_general_style_opt',
			),
		);

		$comparison_list_settings = array(
			array(
				'title'    => __( 'Comparison List', 'compare-products-for-woocommerce' ),
				'type'     => 'title',
				'desc'     => __( 'Comparison list style.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_cl_style_opt',
			),
			array(
				'title'    => __( 'Responsiveness', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'The responsive behaviour of the comparison list.', 'compare-products-for-woocommerce' ) . ' ' .
					__( 'How comparison list will behave when window width is smaller than 768px.', 'compare-products-for-woocommerce' ) .
					'<br /><br />' . __( '* The sorter feature does not work well with List style.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_style_cl_responsiveness',
				'default'  => 'responsive-style-2',
				'class'    => 'chosen_select',
				'options'  => array(
					'responsive-style-1' => __( 'List style', 'compare-products-for-woocommerce' ),
					'responsive-style-2' => __( 'Default table', 'compare-products-for-woocommerce' ),
				),
				'type'     => 'select',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_cp_cl_style_opt',
			),
		);

		$button_settings = array(
			array(
				'title'    => __( 'Default Button', 'compare-products-for-woocommerce' ),
				'type'     => 'title',
				'desc'     => __( 'Default button style.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_style_default_btn_opt',
			),
			array(
				'title'    => __( 'Icon', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Click on input field to choose icon.', 'compare-products-for-woocommerce' ) . ' ' .
					__( 'Choose an Icon from font awesome. Leave it empty if you do not want icons.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_style_default_btn_icon',
				'default'  => 'fas fa-exchange-alt',
				'class'    => 'alg-wc-cp-icon-picker',
				'type'     => 'text',
			),
			array(
				'title'    => __( 'Background color', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Background color for default button.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_style_default_btn_bkg',
				'default'  => '#919191',
				'type'     => 'color',
			),
			array(
				'title'    => __( 'Background color hover', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Background color when mouse is over default button.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_style_default_btn_bkg_hover',
				'default'  => '#bfbfbf',
				'type'     => 'color',
			),
			array(
				'title'    => __( 'Text color', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Color for text and icon of default button.' ),
				'id'       => 'alg_wc_cp_style_default_btn_txt_color',
				'default'  => '#ffffff',
				'type'     => 'color',
			),
			array(
				'title'    => __( 'Font weight', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Font weight for default button text.' ),
				'id'       => 'alg_wc_cp_style_default_btn_txt_weight',
				'default'  => 600,
				'type'     => 'number',
			),
			array(
				'title'    => __( 'Border radius', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Use it to make a rounded button.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_style_default_btn_border_radius',
				'default'  => '0',
				'type'     => 'number',
			),
			array(
				'title'    => __( 'Font size', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Default button font size (in pixels).', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_style_default_btn_font_size',
				'default'  => '15',
				'type'     => 'number',
			),
			array(
				'title'    => __( 'Margin - single', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Distance between button and other adjacent elements on single product page.', 'compare-products-for-woocommerce' ) . ' <br /><br />' .
					__( 'E.g: 5px 15px 15px 20px. <br /><br />There are 4 space separated numbers, each one pointing to a direction:<br /><br /> top right bottom left <br /><br /> Do not forget to write px after each number.', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_style_default_btn_margin_single',
				'default'  => '0 0 15px 0',
				'type'     => 'text',
			),
			array(
				'title'    => __( 'Margin - loop', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Distance between button and other adjacent elements on product loop.', 'compare-products-for-woocommerce' ) . ' <br /><br />' .
					__( 'E.g: 5px 15px 15px 20px. <br /><br />There are 4 space separated numbers, each one pointing to a direction:<br /><br /> top right bottom left <br /><br /> Do not forget to write px after each number. ', 'compare-products-for-woocommerce' ),
				'id'       => 'alg_wc_cp_style_default_btn_margin_loop',
				'default'  => '10px 0 0 0',
				'type'     => 'text',
			),
			array(
				'title'    => __( 'Alignment - single ', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Default button alignment on single product page.' ),
				'id'       => 'alg_wc_cp_style_default_btn_align_single',
				'default'  => 'left',
				'type'     => 'select',
				'class'    => 'chosen_select',
				'options'  => array(
					'left'   => __( 'Left', 'compare-products-for-woocommerce' ),
					'right'  => __( 'Right', 'compare-products-for-woocommerce' ),
					'center' => __( 'Center', 'compare-products-for-woocommerce' ),
				)
			),
			array(
				'title'    => __( 'Alignment - loop', 'compare-products-for-woocommerce' ),
				'desc_tip' => __( 'Default button alignment on product loop.' ),
				'id'       => 'alg_wc_cp_style_default_btn_align_loop',
				'default'  => 'center',
				'type'     => 'select',
				'class'    => 'chosen_select',
				'options'  => array(
					'left'   => __( 'Left', 'compare-products-for-woocommerce' ),
					'right'  => __( 'Right', 'compare-products-for-woocommerce' ),
					'center' => __( 'Center', 'compare-products-for-woocommerce' ),
				)
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_cp_style_default_btn_opt',
			),
		);

		return array_merge( $general_settings, $comparison_list_settings, $button_settings );
	}

}

endif;

return new Alg_WC_Compare_Products_Settings_Style();
