<?php
if (!defined('ABSPATH')) die('-1');

if ( !class_exists("ASP_mb") ) {
    /**
     * Class ASP_mb
     *
     * Simple multibite string function wrapper class for easy use
     *
     * @class         ASP_mb
     * @version       1.0
     * @package       AjaxSearchPro/Classes/Etc
     * @category      Class
     * @author        Ernest Marcinko
     */
    class ASP_mb {

        public static function strlen( ) {
            $args = func_get_args();
            if ( function_exists("mb_strlen") )
                return call_user_func_array("mb_strlen", $args);
            else
                return call_user_func_array("strlen", $args);
        }

        public static function strpos( ) {
            $args = func_get_args();
            if ( function_exists("mb_strpos") )
                return call_user_func_array("mb_strpos", $args);
            else
                return call_user_func_array("strpos", $args);
        }

        public static function substr( ) {
            $args = func_get_args();
            if ( function_exists("mb_substr") )
                return call_user_func_array("mb_substr", $args);
            else
                return call_user_func_array("substr", $args);
        }

        public static function strtolower( ) {
            $args = func_get_args();
            if ( function_exists("mb_strtolower") )
                return call_user_func_array("mb_strtolower", $args);
            else
                return call_user_func_array("strtolower", $args);
        }

        public static function convert_case( ) {
            $args = func_get_args();
            if ( function_exists("mb_convert_case") )
                return call_user_func_array("mb_convert_case", $args);
            else
                return isset($args[0]) ? $args[0] : '';
        }

		public static function strrev($string, $encoding = null) {
			if (
				function_exists('mb_detect_encoding') &&
				function_exists('mb_strlen') &&
				function_exists('mb_substr')
			) {
				if ($encoding === null) {
					$encoding = mb_detect_encoding($string);
				}

				$length   = mb_strlen($string, $encoding);
				$reversed = '';
				while ($length-- > 0) {
					$reversed .= mb_substr($string, $length, 1, $encoding);
				}
				return $reversed;
			} else {
				return strrev($string);
			}
		}
    }
}