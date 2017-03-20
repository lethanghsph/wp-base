/**
 *
 * -----------------------------------------------------------
 *
 * Start menu js
 *
 * -----------------------------------------------------------
 *
 */
(function( document, $, undefined ){
	'use strict';

	// Method of plugin.
	var methods = (function() {
		// Menu toggle.
		var menu = {};
		(function() {
			function menuToggle() {
				var	_this = this,
					elements = {
						slide: $( '#side-slide' ),
						overlay: $( '#body_overlay' ),
						side_header: $( '#site-header' ),
						$el: $( '#site-header' ).find('.header-icon__menu').find('i')
					};
			
				elements.$el.off('click');
				$( elements.$el, elements.side_header ).click(function(e){
					e.preventDefault();
					_this.Toggle(elements);
				})

				elements.overlay.off('click');
				$( elements.overlay, elements.side_header ).click(function(){
					_this.Toggle(elements);
				})
			}
			menuToggle.prototype.Toggle = function(elements) {
				if ( elements.$el.hasClass('fa-bars')) {
					elements.$el.removeClass('fa-bars').addClass('fa-times');
					elements.slide.animate({ 'right':0 },300);
					$('body').animate({ 'left':-125 },300);
					elements.overlay.fadeIn(300);
				} else {
					elements.$el.addClass('fa-bars').removeClass('fa-times');
					elements.slide.animate({ 'right': -250 },300);
					$('body').animate({ 'left':0 },300);
					elements.overlay.fadeOut(300);
				}
			}
			menu.menuToggle = menuToggle;
		})();

		var subMenu = {};
		// Submenu.
		(function() {
			function addArrows(options) {
				this.options = options;
				$('li:has(ul) > a').prepend(this.renderArrow.bind(this));
			}
			addArrows.prototype.renderArrow = function() {
				var arrow = '<span class="tl-submenu-toggle">' + this.options.arrows.down + '</span>';
					
					this.$arrow = $(arrow);
					this.$arrow.on('click', this.toggleSubmenu.bind(this));
					return this.$arrow;
			}
			addArrows.prototype.toggleSubmenu = function(event) {
				event.preventDefault();

				var el = event.target,
					ul = $(el).closest('li').find('ul:first'),
					ul_next = $(el).closest('li').siblings().find('ul');
					
				// Toggle.
				ul_next.stop(true, true).slideUp('1000');
				ul.stop(true, true).slideToggle('1000');
			}
			subMenu.addArrows = addArrows;
		})();

		// Publish method.
		return {
			// destroy: function() {

			// },
			init: function(options) {
				return this.each(function () {
					var $this = $(this);
					if ($this.data('tlMenuOptions')) {
						return;
					}
					var op = $.extend({}, $.fn.tl_menu.defaults, options);
						
					$this.data('tlMenuOptions', op);

					var tlmenu = new subMenu.addArrows(op),
						tlsubmenu = new menu.menuToggle;
				});
			}
		};
	
	})();
	// Initialize plugin.
	$.fn.tl_menu = function (method, args) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		}
		else {
			return $.error('Method ' +  method + ' does not exist on jQuery.fn.tl_menu');
		}
	};

	// Declare default option.
	$.fn.tl_menu.defaults = {
		responsive_point : 768,
		arrows: {
			// up: '<i class="fa fa-sort-asc"></i>'
			down: '<i class="fa fa-sort-desc"></i>'
		},
	};
})( document, jQuery );



