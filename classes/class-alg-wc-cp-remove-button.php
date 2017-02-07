<?php
/**
 * Compare products for WooCommerce - Remove button
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Remove_Button' ) ) {

	class Alg_WC_CP_Remove_Button {

		/**
		 * Loads remove button template.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public static function load_remove_button_template() {

			$params = array(
				'btn_data_action' => 'compare',
				'btn_class'       => 'alg-wc-cp-btn alg-wc-cp-remove-btn',
				'btn_label'       => __( 'Remove', 'alg-wc-compare-products' ),
				'btn_icon_class'  => 'fa fa-times-circle alg-wc-cp-icon',
				'btn_href'        => add_query_arg( array(
					Alg_WC_CP_Query_Vars::ACTION             => 'remove',
					Alg_WC_CP_Query_Vars::COMPARE_PRODUCT_ID => get_the_ID(),
				), get_permalink() ),
			);

			echo alg_wc_cp_locate_template( 'remove-button.php', $params );
		}
	}

}