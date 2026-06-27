/**
 * PersiaPro Customizer Live Preview
 *
 * @package PersiaPro
 * @since 1.0.0
 */

(function ($) {
	'use strict';

	var cssVars = {
		'persiapro_color_primary': '--pp-primary',
		'persiapro_color_secondary': '--pp-secondary',
		'persiapro_color_accent': '--pp-accent',
		'persiapro_color_text': '--pp-text',
		'persiapro_color_background': '--pp-bg',
		'persiapro_color_header_bg': '--pp-header-bg',
		'persiapro_color_header_text': '--pp-header-text',
		'persiapro_color_footer_bg': '--pp-footer-bg',
		'persiapro_color_footer_text': '--pp-footer-text',
		'persiapro_container_width': '--pp-container-width',
		'persiapro_content_padding': '--pp-content-padding',
		'persiapro_font_size_body': '--pp-font-size-body',
		'persiapro_line_height_body': '--pp-line-height-body',
		'persiapro_font_size_h1': '--pp-font-size-h1',
		'persiapro_font_size_h2': '--pp-font-size-h2',
		'persiapro_font_size_h3': '--pp-font-size-h3',
		'persiapro_font_size_h4': '--pp-font-size-h4'
	};

	$.each(cssVars, function (setting, cssVar) {
		wp.customize(setting, function (value) {
			value.bind(function (newval) {
				var unit = setting.indexOf('width') > -1 ? 'px' :
					setting.indexOf('padding') > -1 ? 'rem' :
					setting.indexOf('font_size') > -1 && setting.indexOf('body') > -1 ? 'px' :
					setting.indexOf('font_size') > -1 ? 'rem' : '';
				document.documentElement.style.setProperty(cssVar, newval + unit);
			});
		});
	});

	wp.customize('persiapro_font_body', function (value) {
		value.bind(function (newval) {
			document.documentElement.style.setProperty(
				'--pp-font-body',
				"'" + newval + "', 'Vazir', 'IRANSans', Tahoma, sans-serif"
			);
		});
	});

	wp.customize('persiapro_font_heading', function (value) {
		value.bind(function (newval) {
			document.documentElement.style.setProperty(
				'--pp-font-heading',
				"'" + newval + "', 'Vazir', 'IRANSans', Tahoma, sans-serif"
			);
		});
	});

	wp.customize('persiapro_hero_height', function (value) {
		value.bind(function (newval) {
			$('.pp-hero').css('min-height', newval + 'px');
		});
	});

	wp.customize('persiapro_hero_overlay', function (value) {
		value.bind(function (newval) {
			$('.pp-hero__overlay').css('background', newval);
		});
	});

})(jQuery);
