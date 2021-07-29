/**
 * alg-wc-cp-admin-iconpicker.js.
 *
 * @version 2.0.0
 */
jQuery( function( $ ) {
	var alg_wc_cp_pro_admin_iconpicker = {
		init: function () {
			var icon_input = $( '.alg-wc-cp-icon-picker' );
			this.createIconNextToInput( icon_input );
			if ( icon_input.length ) {
				this.callIconPicker( icon_input );
			}
		},
		createIconNextToInput:function( input ) {
			jQuery( '<span style="margin:0px 7px 0 10px" class="input-group-addon"></span>' ).insertAfter( input );
		},
		callIconPicker:function( element ) {
			element.iconpicker( {
				selectedCustomClass: 'alg-wc-cp-iconpicker-selected',
				hideOnSelect: true,
				placement: 'top',
			} );
		}
	};
	alg_wc_cp_pro_admin_iconpicker.init();
} );
