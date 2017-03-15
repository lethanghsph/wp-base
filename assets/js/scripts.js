/**
 *
 * -----------------------------------------------------------
 *
 * WPBase js
 *
 * -----------------------------------------------------------
 *
 */
(function( document, $ ){
	'use strict';
	/**
	 * WPBASE object.
	 */
	$.WPBASE = $.WPBASE || {};
	
	var $body = $('body');

  // ======================================================
  // TL MENU JS.
  // ------------------------------------------------------
	$.fn.TL_MENU = function( options ) {

		var defaults = {
			responsive_point : 768,
		};
		var options = $.extend( defaults, options );

		return this.each(function(){
			var $this = $(this);

			var setMenu = function() {
				$('li:has(ul) > a', $this).append('<span class="tl-menu-toggle"><i class="fa fa-sort-desc"></i></span>');
			};

			var toggleSubmenu = function() {
				$('.tl-menu-toggle', $this).off('click').on('click', function(e){

					e.preventDefault();

					var $this = $(this),
							ul = $this.closest('li').find('ul:first'),
							ul_next = $this.closest('li').siblings().find('ul');

					// Toggle.
					ul_next.stop(true, true).slideUp('1000');
					ul.stop(true, true).slideToggle('1000');

				});

			};

			var toggleMenu = function() {
				var side_header = $( '#site-header' ),
						slide       = $( '#side-slide' ),
						overlay     = $( '#body_overlay' ),
						menu_icon   = $( '.header-icon__menu' );

				// Open/Close side slide.
				var menu_toggle = function() {
					if ( ! menu_icon.hasClass('open')  ) {

						menu_icon.addClass('open');
						slide.animate({ 'right':0 }, 300);
						$('body').animate({ 'left':-125 }, 300);
						overlay.fadeIn(300);

					} else {

						menu_icon.removeClass('open');
						slide.animate({ 'right': -250 }, 300);
						$('body').animate({ 'left':0 }, 300);
						overlay.fadeOut(300);

					}
				};

				menu_icon.off('click');

				$( menu_icon, side_header ).click(function(e){
					e.preventDefault();
					menu_toggle();
				})

				overlay.off('click');
				$( overlay, side_header ).click(function(e){
					menu_toggle();
				})

			};

			// Run menu.
			if ( $(window).width() <= options.responsive_point ) {
				setMenu();
				toggleMenu();
				toggleSubmenu();
			}

		});
	}

	// Run.
	$(document).ready(function(){
		$( '.side-slide__menu' ).TL_MENU();
	});


})( document, jQuery );
