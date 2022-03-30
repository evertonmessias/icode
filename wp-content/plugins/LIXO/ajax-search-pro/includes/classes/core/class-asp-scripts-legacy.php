<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

/**
 * @deprecated Will be removed @2022 Q1
 */
class WD_ASP_Scripts_Legacy  {
	private static $_instance;
	private function __construct() {}

	public function enqueue() {
		$comp_settings = wd_asp()->o['asp_compatibility'];
		$load_in_footer = w_isset_def($comp_settings['load_in_footer'], 1) == 1;
		$css_async_load = w_isset_def($comp_settings['css_async_load'], 0) == 1;
		$media_query = ASP_DEBUG == 1 ? asp_gen_rnd_str() : get_option("asp_media_query", "defn");

		$js_source = w_isset_def($comp_settings['js_source'], 'min');
		$load_mcustom = w_isset_def($comp_settings['load_mcustom_js'], "yes") == "yes" && asp_is_asset_required('simplebar');
		$load_lazy = w_isset_def($comp_settings['load_lazy_js'], 0);

		$load_noui = asp_is_asset_required('noui');
		$load_isotope = asp_is_asset_required('isotope');
		$load_chosen = asp_is_asset_required('select2');
		$load_polaroid = asp_is_asset_required('polaroid');

		$minify_string = (($load_noui == 1) ? '-noui' : '') . (($load_isotope == 1) ? '-isotope' : '') . (($load_mcustom == 1) ? '-sb' : '');

		if (ASP_DEBUG) $js_source = 'nomin';

		if ( $load_polaroid ) {
			wp_register_script('wd-asp-photostack', ASP_URL . 'js/legacy/nomin/photostack.js', array("jquery"), $media_query, $load_in_footer);
			wp_enqueue_script('wd-asp-photostack');
		}

		if ( $css_async_load ) {
			wp_register_script('wd-asp-async-loader', ASP_URL . 'js/legacy/nomin/async.css.js', array("jquery"), $media_query, $load_in_footer);
			wp_enqueue_script('wd-asp-async-loader');
		}

		if ( $load_chosen ) {
			if ( ASP_DEBUG == 1 || defined('WP_ASP_TEST_ENV') ) {
				wp_register_script('wd-asp-select2', ASP_URL . 'js/legacy/nomin/jquery.select2.js', array('jquery'), $media_query, $load_in_footer);
				wp_enqueue_script('wd-asp-select2');
			} else if ( strpos($js_source, 'scoped') !== false ) {
				wp_register_script('wd-asp-select2', ASP_URL . 'js/legacy/min-scoped/jquery.select2.min.js', array('wd-asp-ajaxsearchpro'), $media_query, $load_in_footer);
				wp_enqueue_script('wd-asp-select2');
			} else {
				wp_register_script('wd-asp-select2', ASP_URL . 'js/legacy/min/jquery.select2.min.js', array('jquery'), $media_query, $load_in_footer);
				wp_enqueue_script('wd-asp-select2');
			}
		}

		if ( $load_lazy ) {
			if ( ASP_DEBUG == 1 || defined('WP_ASP_TEST_ENV') ) {
				wp_register_script('wd-asp-lazy', ASP_URL . 'js/legacy/nomin/jquery.lazy.js', array('jquery'), $media_query, $load_in_footer);
				wp_enqueue_script('wd-asp-lazy');
			} else if ( strpos($js_source, 'scoped') !== false ) {
				wp_register_script('wd-asp-lazy', ASP_URL . 'js/legacy/min-scoped/jquery.lazy.min.js', array('wd-asp-ajaxsearchpro'), $media_query, $load_in_footer);
				wp_enqueue_script('wd-asp-lazy');
			} else {
				wp_register_script('wd-asp-lazy', ASP_URL . 'js/legacy/min/jquery.lazy.min.js', array('jquery'), $media_query, $load_in_footer);
				wp_enqueue_script('wd-asp-lazy');
			}
		}

		if ($js_source == 'nomin' || $js_source == 'nomin-scoped') {
			$prereq = "jquery";
			if ($js_source == "nomin-scoped") {
				$prereq = "wd-asp-aspjquery";
				wp_register_script('wd-asp-aspjquery', ASP_URL . 'js/legacy/' . $js_source . '/aspjquery.js', array(), $media_query, $load_in_footer);
				wp_enqueue_script('wd-asp-aspjquery');
			}

			wp_register_script('wd-asp-gestures', ASP_URL . 'js/legacy/' . $js_source . '/jquery.gestures.js', array($prereq), $media_query, $load_in_footer);
			wp_enqueue_script('wd-asp-gestures');
			wp_register_script('wd-asp-mousewheel', ASP_URL . 'js/legacy/' . $js_source . '/jquery.mousewheel.js', array($prereq), $media_query, $load_in_footer);
			wp_enqueue_script('wd-asp-mousewheel');

			if ( $load_mcustom ) {
				wp_register_script('wd-asp-scroll-simple', ASP_URL . 'js/legacy/' . $js_source . '/simplebar.js', array($prereq), $media_query, $load_in_footer);
				wp_enqueue_script('wd-asp-scroll-simple');
			}
			wp_register_script('wd-asp-highlight', ASP_URL . 'js/legacy/' . $js_source . '/jquery.highlight.js', array($prereq), $media_query, $load_in_footer);
			wp_enqueue_script('wd-asp-highlight');
			if ($load_noui) {
				wp_register_script('wd-asp-nouislider', ASP_URL . 'js/legacy/' . $js_source . '/jquery.nouislider.all.js', array($prereq), $media_query, $load_in_footer);
				wp_enqueue_script('wd-asp-nouislider');
			}
			if ($load_isotope) {
				wp_register_script('wd-asp-rpp-isotope', ASP_URL . 'js/legacy/' . $js_source . '/rpp_isotope.js', array($prereq), $media_query, $load_in_footer);
				wp_enqueue_script('wd-asp-rpp-isotope');
			}
			wp_register_script('wd-asp-inviewport', ASP_URL . 'js/legacy/' . $js_source . '/jquery.inviewport.js', array($prereq), $media_query, $load_in_footer);
			wp_enqueue_script('wd-asp-inviewport');

			wp_register_script('wd-asp-ajaxsearchpro', ASP_URL . 'js/legacy/' . $js_source . '/jquery.ajaxsearchpro.js', array($prereq), $media_query, $load_in_footer);
			wp_enqueue_script('wd-asp-ajaxsearchpro');

			wp_register_script('wd-asp-ajaxsearchpro-widgets', ASP_URL . 'js/legacy/' . $js_source . '/asp_widgets.js', array($prereq, "wd-asp-ajaxsearchpro"), $media_query, $load_in_footer);
			wp_enqueue_script('wd-asp-ajaxsearchpro-widgets');

			wp_register_script('wd-asp-ajaxsearchpro-wrapper', ASP_URL . 'js/legacy/' . $js_source . '/asp_wrapper.js', array($prereq, "wd-asp-ajaxsearchpro"), $media_query, $load_in_footer);
			wp_enqueue_script('wd-asp-ajaxsearchpro-wrapper');
		} else {
			wp_enqueue_script('jquery');
			wp_register_script('wd-asp-ajaxsearchpro', ASP_URL . "js/legacy/" . $js_source . "/jquery.ajaxsearchpro" . $minify_string . ".min.js", array('jquery'), $media_query, $load_in_footer);
			wp_enqueue_script('wd-asp-ajaxsearchpro');
		}
	}

	/**
	 * Get the instane
	 *
	 * @return self
	 */
	public static function getInstance() {
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}