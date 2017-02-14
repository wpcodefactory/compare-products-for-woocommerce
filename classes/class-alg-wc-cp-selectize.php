<?php
/**
 * Compare products for WooCommerce - http://selectize.github.io/selectize.js/ .
 *
 * Responsible for creating drag and order dropdowns
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_CP_Selectize' ) ) {

	class Alg_WC_CP_Selectize {

		/**
		 * Enqueues scripts.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public static function enqueue_scripts(){
			wp_register_script( 'selectize', 'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.min.js', array( 'jquery','jquery-ui-sortable' ), false, true );
			wp_enqueue_script( 'selectize' );
			wp_register_style( 'selectize', 'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.default.min.css', array(), false );
			wp_enqueue_style( 'selectize' );
		}

		/**
		 * Style customize to prevent WooCommerce override
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public static function customize_selectize_style() {
			$css = "
				.selectize-control a.remove{
					text-indent:0 !important;
					line-height:auto !important;
				}
				.selectize-control a.remove:before{
					display:none !important;
					content:none !important;
				}
			";
			wp_add_inline_style( 'selectize', $css );
		}

		/**
		 * Loads selectize.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @param array $args
		 */
		public static function load_selectize( $args = array() ) {
			$opts = wp_parse_args( $args, array(
				'plugins' => array( 'drag_drop', 'remove_button' ),
				'persist' => false,
			) );

			$js = "
				var opts = '" . wp_json_encode( $opts ) . "';
				opts = JSON.parse(opts);
				jQuery(document).ready(function($){
					var selectize_inputs = $('.selectize_drag_drop');
					selectize_inputs.each(function(){						
						var select = jQuery(this).selectize(opts);								
					});
				})
			";
			wp_add_inline_script( 'selectize', $js );
		}
	}

}