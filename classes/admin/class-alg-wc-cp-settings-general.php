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

if ( ! class_exists( 'Alg_WC_CP_Settings_General' ) ) {

	class Alg_WC_CP_Settings_General extends Alg_WC_CP_Settings_Section {

		const OPTION_ENABLE_PLUGIN = 'alg_wc_cp_enable';
		const OPTION_FONT_AWESOME  = 'alg_wc_cp_fontawesome';
		const OPTION_METABOX_PRO   = 'alg_wc_cp_cmb_pro';

		/**
		 * Constructor.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function __construct( $handle_autoload = true ) {
			$this->id   = '';
			$this->desc = __( 'General', 'alg-wc-compare-products' );
			parent::__construct( $handle_autoload );
		}

		/**
		 * get_settings.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		function get_settings( $settings = null ) {
			$new_settings = array(
				array(
					'title'    => __( 'General Options', 'alg-wc-compare-products' ),
					'type'     => 'title',
					'id'       => 'alg_wc_cp_opt',
				),
				array(
					'title'       => __( 'Pro', 'alg-wc-compare-products' ),
					'type'        => 'meta_box',
					'show_in_pro' => false,
					'title'       => 'Pro version',
					'description' => $this->get_meta_box_pro_description(),
					'id'          => self::OPTION_METABOX_PRO,
				),
				array(
					'title'    => __( 'Enable Plugin', 'alg-wc-compare-products' ),
					'desc'     => __( 'Enable "Compare Products for WooCommerce" plugin', 'alg-wc-compare-products' ),
					'id'       => self::OPTION_ENABLE_PLUGIN,
					'default'  => 'yes',
					'type'     => 'checkbox',
				),
				array(
					'title'    => __( 'Load FontAwesome', 'alg-wc-compare-products' ),
					'desc'     => __( 'Load most recent version of Font Awesome', 'alg-wc-compare-products' ),
					'desc_tip' => __( 'Only mark this if you are not loading Font Awesome nowhere else. Font Awesome is responsible for creating icons', 'alg-wc-compare-products' ),
					'id'       => self::OPTION_FONT_AWESOME,
					'default'  => 'yes',
					'type'     => 'checkbox',
				),
				array(
					'type'     => 'sectionend',
					'id'       => 'alg_wc_cp_opt',
				),
			);

			return parent::get_settings( array_merge( $settings, $new_settings ) );
		}

		/**
		 * Gets meta box description.
		 *
		 * The description is about the pro version of the plugin
		 *
		 * @version 1.1.2
		 * @since   1.1.2
		 */
		function get_meta_box_pro_description() {
			$presentation   = __( 'Do you like the free version of this plugin? Imagine what the Pro version can do for you!', 'alg-wc-compare-products' );
			$url            = 'https://coder.fm/item/compare-products-woocommerce/';
			$links          = sprintf( wp_kses( __( 'Check it out <a target="_blank" href="%s">here</a> or on this link: <a target="_blank" href="%s">%s</a>', 'alg-wc-compare-products' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( $url ), esc_url( $url ), esc_url( $url ) );
			$features_title = __( 'Take a look on some of its features:', 'alg-wc-compare-products' );
			$features       = array(
				__( 'Style your buttons easily', 'alg-wc-compare-products' ),
				__( 'Choose in real time which comparison list columns will be displayed on front-end', 'alg-wc-compare-products' ),
				__( 'Sort products on the comparison list by any field', 'alg-wc-compare-products' ),
			);
			$features_str   =
				"<ul style='list-style:square inside'>" .
				"<li>" . implode( "</li><li>", $features ) . "</li>" .
				"</ul>";

			$call_to_action = sprintf( __( '<a target="_blank" style="margin:9px 0 15px 0;" class="button-primary" href="%s">Upgrade to Pro version now</a> ', 'alg-wc-compare-products' ), esc_url( $url ) );

			return "
				<p>{$presentation}<br/>
				{$links}</p>
				<strong>{$features_title}</strong>
				{$features_str}
				{$call_to_action}
			";
		}

	}
}