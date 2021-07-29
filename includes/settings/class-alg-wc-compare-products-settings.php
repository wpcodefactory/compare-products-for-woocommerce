<?php
/**
 * Compare Products for WooCommerce - Settings
 *
 * @version 2.1.0
 * @since   2.0.0
 *
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Compare_Products_Settings' ) ) :

class Alg_WC_Compare_Products_Settings extends WC_Settings_Page {

	/**
	 * Constructor.
	 *
	 * @version 2.1.0
	 * @since   2.0.0
	 */
	function __construct() {
		$this->id    = 'alg_wc_cp';
		$this->label = __( 'Compare Products', 'compare-products-for-woocommerce' );
		parent::__construct();
		// Sections
		require_once( 'class-alg-wc-compare-products-settings-helper.php' );
		require_once( 'class-alg-wc-compare-products-settings-section.php' );
		require_once( 'class-alg-wc-compare-products-settings-general.php' );
		require_once( 'class-alg-wc-compare-products-settings-buttons.php' );
		require_once( 'class-alg-wc-compare-products-settings-comparison-list.php' );
		require_once( 'class-alg-wc-compare-products-settings-style.php' );
	}

	/**
	 * get_settings.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function get_settings() {
		global $current_section;
		return array_merge( apply_filters( 'woocommerce_get_settings_' . $this->id . '_' . $current_section, array() ), array(
			array(
				'title'     => __( 'Reset Settings', 'compare-products-for-woocommerce' ),
				'type'      => 'title',
				'id'        => $this->id . '_' . $current_section . '_reset_options',
			),
			array(
				'title'     => __( 'Reset section settings', 'compare-products-for-woocommerce' ),
				'desc'      => '<strong>' . __( 'Reset', 'compare-products-for-woocommerce' ) . '</strong>',
				'desc_tip'  => __( 'Check the box and save changes to reset.', 'compare-products-for-woocommerce' ),
				'id'        => $this->id . '_' . $current_section . '_reset',
				'default'   => 'no',
				'type'      => 'checkbox',
			),
			array(
				'type'      => 'sectionend',
				'id'        => $this->id . '_' . $current_section . '_reset_options',
			),
		) );
	}

	/**
	 * maybe_reset_settings.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function maybe_reset_settings() {
		global $current_section;
		if ( 'yes' === get_option( $this->id . '_' . $current_section . '_reset', 'no' ) ) {
			foreach ( $this->get_settings() as $value ) {
				if ( isset( $value['id'] ) ) {
					$id = explode( '[', $value['id'] );
					delete_option( $id[0] );
				}
			}
			add_action( 'admin_notices', array( $this, 'admin_notices_settings_reset_success' ), PHP_INT_MAX );
		}
	}

	/**
	 * admin_notices_settings_reset_success.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function admin_notices_settings_reset_success() {
		echo '<div class="notice notice-success is-dismissible"><p><strong>' .
			__( 'Your settings have been reset.', 'compare-products-for-woocommerce' ) . '</strong></p></div>';
	}

	/**
	 * save.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function save() {
		parent::save();
		$this->maybe_reset_settings();
	}

}

endif;

return new Alg_WC_Compare_Products_Settings();
