<?php
/**
 * Compare products for WooCommerce - General Section Settings
 *
 * @version 1.2.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Settings_General' ) ) {

	class Alg_WC_CP_Settings_General extends Alg_WC_CP_Settings_Section {

		const OPTION_ENABLE_PLUGIN = 'alg_wc_cp_enable';
		const OPTION_FONT_AWESOME  = 'alg_wc_cp_fontawesome';
		const OPTION_METABOX_PRO   = 'alg_wc_cp_cmb_pro';

		protected $pro_version_url = 'https://wpfactory.com/item/compare-products-woocommerce/';

		/**
		 * Constructor.
		 *
		 * @version 1.1.2
		 * @since   1.0.0
		 */
		function __construct( $handle_autoload = true ) {
			$this->id   = '';
			$this->desc = __( 'General', 'compare-products-for-woocommerce' );
			parent::__construct( $handle_autoload );
		}

		/**
		 * get_settings.
		 *
		 * @version 1.2.0
		 * @since   1.0.0
		 */
		function get_settings( $settings = null ) {
			$new_settings = array(
				array(
					'title'    => __( 'General Options', 'compare-products-for-woocommerce' ),
					'type'     => 'title',
					'id'       => 'alg_wc_cp_opt',
				),
				array(
					'title'    => __( 'Enable Plugin', 'compare-products-for-woocommerce' ),
					'desc'     => __( 'Enable "Compare Products for WooCommerce" plugin', 'compare-products-for-woocommerce' ),
					'id'       => self::OPTION_ENABLE_PLUGIN,
					'default'  => 'yes',
					'type'     => 'checkbox',
				),
				array(
					'title'    => __( 'Load FontAwesome', 'compare-products-for-woocommerce' ),
					'desc'     => __( 'Load most recent version of Font Awesome', 'compare-products-for-woocommerce' ),
					'desc_tip' => __( 'Only mark this if you are not loading Font Awesome nowhere else. Font Awesome is responsible for creating icons', 'compare-products-for-woocommerce' ),
					'id'       => self::OPTION_FONT_AWESOME,
					'default'  => 'yes',
					'type'     => 'checkbox',
				),
				array(
					'title'          => 'Pro version',
					'enable'         => !defined( 'ALG_WC_CP_PRO_BASENAME' ),
					'type'           => 'wccso_metabox',
					'show_in_pro'    => false,
					'accordion' => array(
						'title' => __( 'Take a look on some of its features:', 'compare-products-for-woocommerce' ),
						'items' => array(
							array(
								'trigger'     => __( 'Choose in real time which comparison list columns will be displayed on front-end', 'compare-products-for-woocommerce' ),
								'img_src'     => plugins_url( '../../assets/images/real-time-columns.gif', __FILE__ ),
							),
							array(
								'trigger'     => __( 'Sort products on the comparison list by any field', 'compare-products-for-woocommerce' ),
								'img_src'     => plugins_url( '../../assets/images/sorter.gif', __FILE__ ),
							),
							array(
								'trigger'     => __( 'Style your buttons easily', 'compare-products-for-woocommerce' ),
								'description' => __( 'Customize button icon, color, background, margin and more', 'compare-products-for-woocommerce' ),
							),
						),
					),
					'call_to_action' => array(
						'href'   => $this->pro_version_url,
						'label'  => 'Upgrade to Pro version now',
					),
					'description'    => __( 'Do you like the free version of this plugin? Imagine what the Pro version can do for you!', 'compare-products-for-woocommerce' ) . '<br />' . sprintf( __( 'Check it out <a target="_blank" href="%1$s">here</a> or on this link: <a target="_blank" href="%1$s">%1$s</a>', 'compare-products-for-woocommerce' ), esc_url( $this->pro_version_url ) ),
					'id'             => self::OPTION_METABOX_PRO,
				),
				array(
					'type'     => 'sectionend',
					'id'       => 'alg_wc_cp_opt',
				),
			);

			return parent::get_settings( array_merge( $settings, $new_settings ) );
		}

	}
}