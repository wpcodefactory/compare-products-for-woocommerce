<?php
/**
 * Compare Products for WooCommerce - Functions
 *
 * @version 2.0.0
 * @since   2.0.0
 * @author  Algoritmika Ltd
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'alg_wc_cp_on_install' ) ) {
	/**
	 * Called when the plugin is activated.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function alg_wc_cp_on_install() {
		Alg_WC_CP_Comparison_List::create_page();
	}
}

if ( ! function_exists( 'alg_wc_cp_on_uninstall' ) ) {
	/**
	 * Called when the plugin is uninstalled.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function alg_wc_cp_on_uninstall() {
		Alg_WC_CP_Comparison_List::delete_page();
	}
}

if ( ! function_exists( 'alg_wc_cp_locate_template' ) ) {
	/**
	 * Returns a template.
	 *
	 * Searches for a template on stylesheet directory and if it's not found get this same template on plugin's template folder.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	function alg_wc_cp_locate_template( $path, $params = null ) {
		$final_file  = null;
		$located     = locate_template( array( alg_wc_compare_products()->folder_name() . '/' . $path ) );
		$file_path   = apply_filters( 'alg_wc_cp_locate_template_file_path',
			alg_wc_compare_products()->plugin_path() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $path, $path );
		if ( ! $located && file_exists( $file_path ) ) {
			$final_file = $file_path;
		} elseif ( $located ) {
			$final_file = $located;
		}
		if ( $final_file ) {
			if ( $params ) {
				$params = apply_filters( 'alg_wc_cp_locate_template_params', $params, $final_file, $path );
				set_query_var( 'params', $params );
			}
			ob_start();
			include( $final_file );
			$final_file = apply_filters( 'alg_wc_cp_locate_template', $final_file, $params, $path );
			return ob_get_clean();
		}
	}
}

if ( ! function_exists( 'alg_wc_cp_wc_version_check' ) ) {
	/**
	 * Check if you are running a specified WooCommerce version (or higher).
	 *
	 * @version 2.0.0
	 * @since   1.1.5
	 * @param   string $version
	 * @return  bool
	 */
	function alg_wc_cp_wc_version_check( $version = '3.0' ) {
		if ( class_exists( 'WooCommerce' ) ) {
			global $woocommerce;
			if ( version_compare( $woocommerce->version, $version, ">=" ) ) {
				return true;
			}
		}
		return false;
	}
}

if ( ! function_exists( 'alg_wc_cp_wc_add_notice' ) ) {
	/**
	 * Add and store a notice.
	 *
	 * @version 1.1.3
	 * @since   1.1.3
	 * @param   string $message     The text to display in the notice.
	 * @param   string $notice_type The singular name of the notice type - either error, success or notice (optional).
	 */
	function alg_wc_cp_wc_add_notice( $message, $notice_type = 'success' ) {
		if ( ! wc_has_notice( $message, $notice_type ) ) {
			wc_add_notice( $message, $notice_type = 'success' );
		}
	}
}

if ( ! function_exists( 'alg_wc_cp_load_compare_button_template' ) ) {
	/**
	 * Loads "Compare" button template.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function alg_wc_cp_load_compare_button_template() {
		alg_wc_cp_load_button_template( 'compare' );
	}
}

if ( ! function_exists( 'alg_wc_cp_load_button_template' ) ) {
	/**
	 * Loads button template.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function alg_wc_cp_load_button_template( $button = 'compare' ) {
		// Current URL
		global $wp;
		$permalink_structure = get_option( 'permalink_structure' );
		$current_url = ( empty( $permalink_structure ) ?
			( is_shop() ? get_post_type_archive_link( 'product' ) : get_permalink( add_query_arg( array(), $wp->request ) ) ) :
			home_url( add_query_arg( array(), $wp->request ) ) . '/'
		);
		// Href params
		$btn_href_params = array(
			'alg_wc_cp_action' => $button,
			'alg_wc_cp_pid'    => get_the_ID(),
		);
		if ( 'yes' === get_option( 'alg_wc_cp_cl_use_modal', 'yes' ) ) {
			$btn_href_params['alg_wc_cp_modal'] = 'open';
		}
		// Params
		$params = array(
			'btn_data_action' => 'compare',
			'btn_class'       => 'alg-wc-cp-btn ' . ( 'compare' == $button ? 'alg-wc-cp-default-btn button' : 'alg-wc-cp-remove-btn' ),
			'btn_label'       => ( 'compare' == $button ?
				get_option( 'alg_wc_cp_default_btn_title', __( 'Compare', 'compare-products-for-woocommerce' ) ) : __( 'Remove', 'compare-products-for-woocommerce' ) ),
			'btn_icon_class'  => ( 'compare' == $button ? 'fas fa-exchange-alt' : 'fas fa-trash' ) . ' alg-wc-cp-icon',
			'btn_href'        => add_query_arg( $btn_href_params, $current_url ),
		);
		// Load
		echo alg_wc_cp_locate_template( ( 'compare' == $button ? 'default-button.php' : 'remove-button.php' ), $params );
	}
}
