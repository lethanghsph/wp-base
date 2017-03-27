
(function( document, $ ){
	'use strict';

	window.WPBase = window.WPBase || {};

	var Extra = {
		initExtra: function() {
			this.mobileMenu();
			this.getSlick();
			this.tooltip();
			this.flyAddToCard();
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
		},

		flyAddToCard: function() {

			var $body = $('body');
			var $cart = $('.thangle');

			var getProductImage = function($el) {
				var $thumbs = $el.find('.wp-post-image');
				var $images = $el.find('img');
				console.log( $images.length );
				if ($images.length) {
					var $thumb = $thumbs.find('img');
					return $thumb.length ? $thumb.eq(0) : $images.eq(0);
				}

				return false;
			};

			$body.on('adding_to_cart', function(e, $button) {
				var $product = $button.parents('.product-type-simple');
				console.log( $product );
				var $imgDrag = getProductImage($product);

				if ($imgDrag) {
					var $imgClone = $imgDrag.clone();

					$imgClone.offset({
						top: $imgDrag.offset().top,
						left: $imgDrag.offset().left
					});

					$imgClone.css({
						'opacity': '0.75',
						'position': 'absolute',
						'height': '150px',
						'width': '150px',
						'z-index': '999999'
					});

					$imgClone.appendTo($body);

					$imgClone.animate({
						'top': $cart.offset().top + 10,
						'left': $cart.offset().left + 10,
						'width': 75,
						'height': 75
					}, 1000);

					$imgClone.animate({
						'width': 0,
						'height': 0
					}, function () {
						$(this).detach();
					});
				}
			});
		},

	};

	$(document).ready(function(){
		// Extend WPBase method.
		$.extend(true, WPBase, Extra);

		// Run.
		WPBase.initExtra();
	});	
})( document, jQuery );


