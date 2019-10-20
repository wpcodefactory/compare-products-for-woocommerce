<?php
/**
 * Compare products for WooCommerce - Default button
 *
 * @version 1.2.0
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
				$default_btn_single_prod_position = sanitize_text_field( get_option( Alg_WC_CP_Settings_Buttons::OPTION_DEFAULT_BTN_SINGLE_POSITION, 'woocommerce_single_product_summary' ) );
				$default_btn_single_prod_priority = filter_var( get_option( Alg_WC_CP_Settings_Buttons::OPTION_DEFAULT_BTN_SINGLE_PRIORITY, 31 ), FILTER_VALIDATE_INT );
				add_action( $default_btn_single_prod_position, array(
					self::get_class_name(),
					'load_default_button_template',
				), $default_btn_single_prod_priority );
			}

			$show_default_btn_loop_product = get_option( Alg_WC_CP_Settings_Buttons::OPTION_DEFAULT_BTN_LOOP_ENABLE,false );
			if ( filter_var( $show_default_btn_loop_product, FILTER_VALIDATE_BOOLEAN ) !== false ) {
				$default_btn_loop_prod_position = 'woocommerce_after_shop_loop_item';
				$default_btn_loop_prod_priority = get_option( Alg_WC_CP_Settings_Buttons::OPTION_DEFAULT_BTN_LOOP_PRIORITY, 11 );
				add_action( $default_btn_loop_prod_position, array(
					self::get_class_name(),
					'load_default_button_template',
				), filter_var( $default_btn_loop_prod_priority, FILTER_VALIDATE_INT ) );
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
		 * @version 1.2.0
		 * @since   1.0.0
		 */
		public static function load_default_button_template() {
			global $wp;
			$permalink_structure = get_option('permalink_structure') ;
			if(empty($permalink_structure)){
				if(is_shop()){
					$current_url =  get_post_type_archive_link('product');
				}else{
					$current_url = get_permalink(add_query_arg( array(), $wp->request ));
				}
			}else{
				$current_url = home_url( add_query_arg( array(), $wp->request ) ) . '/';
			}

			$btn_href_params =  array(
				Alg_WC_CP_Query_Vars::ACTION             => 'compare',
				Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID => get_the_ID(),
			);

			if ( true === filter_var( get_option( Alg_WC_CP_Settings_Comparison_List::OPTION_USE_MODAL, true ), FILTER_VALIDATE_BOOLEAN ) ) {
				$btn_href_params[Alg_WC_CP_Query_Vars::MODAL] = 'open';
			}

			$params = array(
				'btn_data_action' => 'compare',
				'btn_class'       => 'alg-wc-cp-btn alg-wc-cp-default-btn button',
				'btn_label'       => __( 'Compare', 'compare-products-for-woocommerce' ),
				'btn_icon_class'  => 'fa fa-exchange-alt alg-wc-cp-icon',
				'btn_href'        => add_query_arg( $btn_href_params, $current_url ),
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