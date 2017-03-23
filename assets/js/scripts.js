
(function( document, $ ){
	'use strict';

	window.WPBase = window.WPBase || {};

	var Extra = {
		initExtra: function() {
			this.mobileMenu();
			this.getSlick();
			this.tooltip();
		},
		mobileMenu: function() {
			$( '.side-slide__menu' ).tl_menu();
		},

		// Slick slider
		getSlick: function() {
			$('[data-init="slick"]').each(function (){
				var el = $(this);

				var breakpointsWidth = {tn: 319, xs: 479, ss: 519, sm: 767, md: 991, lg: 1199};

				var slickDefault = {
					// fade: true,
					infinite: true,
					autoplay: true,
					pauseOnHover: true,
					speed: 1000,
					adaptiveHeight: true,

					slidesToShow: 1,
					slidesToScroll: 1,

					mobileFirst: true
				};

				// Merge settings.
				var settings = $.extend(slickDefault, el.data());
				delete settings.init;

				// Build breakpoints.
				if (settings.breakpoints) {
					var _responsive = [];
					var _breakpoints = settings.breakpoints;

					var buildBreakpoints = function (key, show, scroll) {
						_responsive.push({
							breakpoint: breakpointsWidth[key],
							settings: {
								slidesToShow: parseInt(show),
								slidesToScroll: 1
							}
						});
					};

					if (typeof _breakpoints === "object") {
						$.each(_breakpoints, buildBreakpoints);
					}

					delete settings.breakpoints;
					settings.responsive = _responsive;
				};

				el.slick(settings);
			 });
		},

		tooltip: function() {
			 $('[data-toggle="tooltip"]').tooltip();
		}

	};

	$(document).ready(function(){
		// Extend WPBase method.
		$.extend(true, WPBase, Extra);

		// Run.
		WPBase.initExtra();
	});	
})( document, jQuery );


