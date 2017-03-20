
(function( document, $ ){
	'use strict';

	window.WPBase = window.WPBase || {};

	var Extra = {
		initExtra: function() {
			this.mobileMenu();
		},
		mobileMenu: function() {
			$( '.side-slide__menu' ).tl_menu();
		}

	};

	$(document).ready(function(){
		// Extend WPBase method.
		$.extend(true, WPBase, Extra);

		// Run.
		WPBase.initExtra();
	});	
})( document, jQuery );


