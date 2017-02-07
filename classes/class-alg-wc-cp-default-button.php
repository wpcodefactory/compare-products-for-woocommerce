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

if ( ! class_exists( 'Alg_WC_CP_Default_Button' ) ) {

	class Alg_WC_CP_Default_Button {

		/**
		 * Manages buttons loading based on admin settings.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public static function manage_button_loading() {
			$show_default_btn_single_product = get_option( Alg_WC_CP_Settings_Buttons::OPTION_DEFAULT_BTN_SHOW_ON_SINGLE_PAGE, false );
			if ( filter_var( $show_default_btn_single_product, FILTER_VALIDATE_BOOLEAN ) !== false ) {
				$default_btn_single_prod_position = sanitize_text_field( get_option( Alg_WC_CP_Settings_Buttons::OPTION_DEFAULT_BTN_POSITION, 'woocommerce_single_product_summary' ) );
				$default_btn_single_prod_priority = filter_var( get_option( Alg_WC_CP_Settings_Buttons::OPTION_DEFAULT_BTN_PRIORITY, 31 ), FILTER_VALIDATE_INT );
				add_action( $default_btn_single_prod_position, array(
					self::get_class_name(),
					'load_default_button_template',
				), $default_btn_single_prod_priority );
			}
		}

		/**
		 * Manages query vars
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public static function handle_query_vars($vars){
			$vars[] = Alg_WC_CP_Query_Vars::ACTION;
			$vars[] = Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID;
			return $vars;
		}

		/**
		 * Loads default button template.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public static function load_default_button_template() {

			$params = array(
				'btn_data_action' => 'alg_wc_cp_compare',
				'btn_class'       => 'alg_wc_cp_default_btn button',
				'btn_label'       => __( 'Compare', 'alg-wc-compare-products' ),
				'btn_icon_class'  => 'fa fa-exchange alg-wc-cp-icon',
				'btn_href'        => add_query_arg( array(
					Alg_WC_CP_Query_Vars::ACTION             => 'compare',
					Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID => get_the_ID(),
				), get_permalink() ),
			);

			echo alg_wc_cp_locate_template( 'default-button.php', $params );
		}

		/**
		 * Returns class name
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @return type
		 */
		public static function get_class_name() {
			return get_called_class();
		}
	}

}