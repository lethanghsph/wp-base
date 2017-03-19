/**
 *
 * -----------------------------------------------------------
 *
 * Start menu js
 *
 * -----------------------------------------------------------
 *
 */
(function( document, $ ){
	'use strict';

	// Method of plugin.
	var method = (function() {

		// Protected method.
		var cl = {
				menuIconClass: 'tl-menu-icon',		
				menuArrowClass: 'tl-menu-item'	
			},
			// Menu toggle.
			rederMenuIcon = function() {
				var html = '<div class="' + cl.menuIconClass + '"">\
								<span class="fa fa-bars"></span>\
							</div>';
				this.$menuIconHtml = $(html);
				this.$menuIconHtml.on('click', this.toggleMenu);
				return this.$menuIconHtml;
			},
			toggleMenu = function(event){
				var $el = event.target,
					$iconClass = $el.find('.fa');
				if ($iconClass.hasClass('fa-bars')) {
					$iconClass.removeClass('fa-bars').addClass('fa-times');
					slide.animate({ 'right':0 },300);
					$('body').animate({ 'left':-125 },300);
					overlay.fadeIn(300);
				} else {
					$iconClass.addClass('fa-bars').removeClass('fa-times');
					slide.animate({ 'right': -250 },300);
					$('body').animate({ 'left':0 },300);
					overlay.fadeOut(300);
				};
			},
			addMenuIcon = function($menu) {
				if ( ! custom_menu_icon ) {
					$menu.prepend(this.rederMenuIcon());
				};
			};
			// Menu Item toggle.
			// setCurrentItem = function($menu, $item) {
			// 	$menu.find( '' )
			// },
			// addMenuArrow = function(event, options) {
			// 	var $el = event.target;
			// 	$el.on(event, .arrows.down);
			// },
			// addClassCurrent = function() {

			// },
			// toggleSubmenu = function() {

			// };

	
		// Publish method.
		return {
			// destroy: function() {

			// },
			init: function(options) {
				return this.each(function () {
					var $this = $(this);
					if ($this.data('tlMenuOptions')) {
						return false;
					}
					var op = $.extend({}, $.fn.tl_menu.defaults, options);

					$this.data('tlMenuOptions', op);
					addMenuIcon($this);
					// toggleMenuClasses($this, op, true);
					// toggleAnchorClass($hasPopUp, true);
					// toggleTouchAction($this);
					// applyHandlers($this, op);

					// $hasPopUp.not('.' + c.bcClass).tl_menu('hide', true);

					// op.onInit.call(this);
				});
			}
		};
	
	})();

	// Initialize plugin.
	$.fn.tl_menu = function(method, agrs) {
		if (method[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if (typeof method === 'object' || ! method) {
			return method.init.apply(this, arguments);
		}
		else {
			return $.error('Method ' +  method + ' does not exist on jQuery.fn.tl_menu');
		}
	};

	// Declare default option.
	$.fn.tl_menu.defaults = {
		responsive_point : 768,
		arrows: {
			up: '<i class="fa fa-sort-asc"></i>',
			down: '<i class="fa fa-sort-desc"></i>'
		},
		custom_menu_icon: true
	};
	
})( document, jQuery );
	$(document).ready(function(){
		$( '.side-slide__menu' ).tl_menu();
	});


