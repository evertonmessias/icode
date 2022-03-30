<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("WD_ASP_StyleSheets_Action")) {
    /**
     * Class WD_ASP_StyleSheets_Action
     *
     * Handles the non-ajax searches if activated.
     *
     * @class         WD_ASP_StyleSheets_Action
     * @version       1.0
     * @package       AjaxSearchPro/Classes/Actions
     * @category      Class
     * @author        Ernest Marcinko
     */
    class WD_ASP_StyleSheets_Action extends WD_ASP_Action_Abstract {
        /**
         * Static instance storage
         *
         * @var self
         */
        protected static $_instance;

        /**
         * Holds the inline CSS
         *
         * @var string
         */
        private static $inline_css = "";

        /**
         * This function is bound as the handler
         */
        public function handle()
        {

            if (function_exists('get_current_screen')) {
                $screen = get_current_screen();
                if (isset($screen) && isset($screen->id) && $screen->id == 'widgets')
                    return;
            }

            // If no instances exist, no need to load any of the stylesheets
            if (wd_asp()->instances->exists()) {

                $comp_settings = wd_asp()->o['asp_compatibility'];
                $force_inline = w_isset_def($comp_settings['forceinlinestyles'], false);
                $async_load = w_isset_def($comp_settings['css_async_load'], false);
                $media_query = get_option("asp_media_query", "defncss");

                $exit1 = apply_filters('asp_load_css_js', false);
                $exit2 = apply_filters('asp_load_css', false);
                if ($exit1 || $exit2)
                    return false;

                add_action('wp_head', array($this, 'inlineCSS'), 10);
                add_action('wp_head', array($this, 'fonts'), 10);

                if ($force_inline == 1) {

                    $css = asp_generate_the_css(false);
                    // If it's still false, we have a problem
                    if ($css === false || $css == '') return;

                    self::$inline_css = $css;
                    return;

                } else if (
                    !file_exists(wd_asp()->upload_path . asp_get_css_filename('instances')) ||
                    @filesize(wd_asp()->upload_path . asp_get_css_filename('instances')) < 1025
                ) {
                    /* Check if the CSS exists, if not, then try to force-create it */
                    asp_generate_the_css();
                    // Check again, if doesn't exist, we need to force inline styles
                    if (
                        !file_exists(wd_asp()->upload_path . asp_get_css_filename('instances')) ||
                        @filesize(wd_asp()->upload_path . asp_get_css_filename('instances')) < 1025
                    ) {
                        $css = asp_generate_the_css();
                        // Still no CSS? Problem.
                        if ($css === false || $css == '')
                            return;
                        self::$inline_css = $css;

                        // Save the force inline
                        $comp_settings['forceinlinestyles'] = 1;
                        update_option('asp_compatibility', $comp_settings);

                        return;
                    }
                }

                // Asynchronous loader enabled, load the basic only, then abort
                if (ASP_DEBUG != 1 && $force_inline != 1 && $async_load) {
                    self::$inline_css = ".asp-try{visibility:hidden;}.wpdreams_asp_sc{display: none; max-height: 0; overflow: hidden;}";
                    return;
                } else {
                    // Basic FOUC prevention
                    self::$inline_css = ".asp_m{height: 0;}";
                }

                // If everything went ok, and the async loader not enabled, get the files
                wp_enqueue_style('wpdreams-ajaxsearchpro-instances', asp_get_css_url('instances'), array(), $media_query);
            }
        }

        /**
         * Echos the inline CSS if available
		 *
		 * Because inline CSS is highly discouraged, this only prints user defined custom CSS
		 * and very basic FOUC prevention one liners when applicable.
         */
        public function inlineCSS() {
        	?>
			<link rel="preload" href="<?php echo str_replace('http:',"",plugins_url()); ?>/ajax-search-pro/css/fonts/icons/icons2.woff2" as="font" crossorigin="anonymous" />
            <?php if ( self::$inline_css != '' ): ?>
			<style>
                <?php echo self::$inline_css; ?>
            </style>
			<?php endif; ?>
            <?php
        }

		public function fonts( $style = "" ) {
			// If custom font loading is disabled, exit
			$comp_options = wd_asp()->o['asp_compatibility'];
			if ( $comp_options['load_google_fonts'] != 1 )
				return false;

			$imports = array();
			$font_sources = array("inputfont", "descfont", "titlefont", 'fe_sb_font',
				"authorfont", "datefont", "showmorefont", "groupfont",
				"exsearchincategoriestextfont", "groupbytextfont", "settingsdropfont",
				"prestitlefont", "presdescfont", "pressubtitlefont", "search_text_font");


			if ($style != "") {
				foreach($font_sources as $fs) {
					if (isset($style["import-".$fs]) && !in_array(trim($style["import-".$fs]), $imports))
						$imports[] = trim($style["import-".$fs]);
				}
			} else {
				foreach (wd_asp()->instances->get() as $instance) {
					foreach($font_sources as $fs) {
						if (isset($instance['data']["import-".$fs]) && !in_array(trim($instance['data']["import-".$fs]), $imports))
							$imports[] = trim($instance['data']["import-".$fs]);
					}
				}
			}

			foreach ( $imports as $ik => $im )
				if ( $im == '' )
					unset($imports[$ik]);

			$imports = apply_filters('asp_custom_fonts', $imports);
			$fonts = array();
			foreach ($imports as $import) {
				$import = trim(str_replace(array("@import url(", ");", "https:", "http:"), "", $import));
				$import = trim(str_replace("//fonts.googleapis.com/css?family=", "", $import));
				if ( $import != '' ) {
					$fonts[] = $import;
				}
			}
			if ( count($fonts) > 0 ) {
				?>
				<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
				<link rel="preload" as="style" href="//fonts.googleapis.com/css?family=<?php echo implode('|', $fonts); ?>&display=swap" />
				<link rel="stylesheet" href="//fonts.googleapis.com/css?family=<?php echo implode('|', $fonts); ?>&display=swap" media="all" />
				<?php
			}
		}

        public function shouldLoadAssets() {
            $comp_settings = wd_asp()->o['asp_compatibility'];

            $exit = false;

            if ( $comp_settings['selective_enabled'] ) {
                if ( is_front_page() ) {
                    if ( $comp_settings['selective_front'] == 0 ) {
                        $exit = true;
                    }
                } else if ( is_archive() ) {
                    if ( $comp_settings['selective_archive'] == 0 ) {
                        $exit = true;
                    }
                } else if ( is_singular() ) {
                    if ( !$exit && $comp_settings['selective_exin'] != '' ) {
                        global $post;
                        if ( isset($post, $post->ID) ) {
                            $_ids = wpd_comma_separated_to_array($comp_settings['selective_exin']);
                            if ( !empty($_ids) ) {
                                if ( $comp_settings['selective_exin_logic'] == 'exclude' && in_array($post->ID, $_ids) ) {
                                    $exit = true;
                                } else if ( $comp_settings['selective_exin_logic'] == 'include' && !in_array($post->ID, $_ids) ) {
                                    $exit = true;
                                }
                            }
                        }
                    }
                }
            }

            return $exit;
        }

        // ------------------------------------------------------------
        //   ---------------- SINGLETON SPECIFIC --------------------
        // ------------------------------------------------------------
        public static function getInstance() {
            if ( ! ( self::$_instance instanceof self ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }
    }
}