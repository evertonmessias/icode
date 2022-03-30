<?php

class WPFTS_Utils 
{
	public static function GetRawCache($object_id, $object_type, $mtime, $is_force_reindex, $cb)
	{
		global $wpdb, $wpfts_core;

		if (!$wpfts_core) {
			return array();
		}
	
		$idx = $wpfts_core->GetDBPrefix();

		$q = 'select 
				* 
			from `'.$idx.'rawcache`
			where 
				`object_id` = "'.addslashes($object_id).'" and 
				`object_type` = "'.addslashes($object_type).'"';
		$res = $wpdb->get_results($q, ARRAY_A);

		if ((count($res) < 1) || ($res[0]['cached_dt'] != $mtime) || ($is_force_reindex)) {
			// use callback to extract text data
			if ($cb && is_callable($cb)) {

				$v = $cb();

				if ($v) {
				
					$dbarr = array(
						'object_id' => $object_id,
						'object_type' => $object_type,
						'data' => serialize(isset($v['raw_data']) ? $v['raw_data'] : 'No raw data provided'),
						'insert_dt' => date('Y-m-d H:i:s', current_time('timestamp')),
						'cached_dt' => isset($v['modified_time']) ? $v['modified_time'] : '1970-01-01 00:00:00',
						'error' => isset($v['error']) ? $v['error'] : '',
						'filename' => isset($v['filename']) ? $v['filename'] : '',
						'method_id' => isset($v['method_id']) ? $v['method_id'] : '',
					);

					if (count($res) > 0) {
						// Update
						$wpdb->update(
							$idx.'rawcache', 
							$dbarr,
							array(
								'id' => $res[0]['id']
							));
					} else {
						// Insert
						$wpdb->insert(
							$idx.'rawcache', ///
							$dbarr
						);
					}

					return $v['raw_data'];

				} else {
					// Something went wrong!
					return array(
						'extract_error' => 'The callback returned false',
					);
				}

			} else {
				// Not callable
				return array(
					'extract_error' => 'The callback not set or not callable',
				);
			}
		} else {
			// Return from cache
			return @unserialize($res[0]['data']);
		}
	}

	public static function GetURLInfo($url, $is_local_file = false)
	{
		$ret = array(
			'is_valid' => false,
			'is_local' => false,
			'local_path' => '',
			'file_ext' => '',
		);

		if ($is_local_file) {
			// Local file
			if (strlen($url) > 0) {
				$ret['is_valid'] = true;
				$ret['is_local'] = true;
				$ret['local_path'] = $url;

				$rem = basename($url);
				$ext = (($p = strrpos($rem, '.')) !== false) ? str_replace(array('/', "\\"), '', substr($rem, $p + 1)) : '';
				$ret['file_ext'] = $ext;
			}
		} else {
			// URL
			$hurl = home_url();

			$p_hurl = parse_url($hurl);
			$purl = parse_url($url);
	
			if (isset($purl['host']) && (strlen($purl['host']) > 0)) {
				$ret['is_valid'] = true;
	
				// Get extension of the file (if present)
				$rem = basename($purl['path']);
				$ext = (($p = strrpos($rem, '.')) !== false) ? str_replace(array('/', "\\"), '', substr($rem, $p + 1)) : '';
				$ret['file_ext'] = $ext;

				// Check if URL local
				if (isset($p_hurl['host']) && (strlen($p_hurl['host']) > 0)) {
					if (mb_strtolower($p_hurl['host']) == mb_strtolower($purl['host'])) {
						// Same domain, ok. Now check path
						$url_path = isset($purl['path']) ? trim(trim($purl['path']), '/') : '';
						$hurl_path = isset($p_hurl['path']) ? trim(trim($p_hurl['path']), '/') : '';
	
						if ((strlen($hurl_path) < 1) || (substr($url_path, 0, strlen($hurl_path)) == $hurl_path)) {
							// Okay, subpath is the same
							$ret['is_local'] = true;
	
							$ret['local_path'] = rtrim(trim(ABSPATH), '/').'/'.ltrim(substr($url_path, strlen($hurl_path)), '/');
						}
					}
				}
			}	
		}

		return $ret;
	}

	/**
	 * This method with return cached content of the local file by it's given LINK or direct PATH.
	 * If no cache exists yet, it will extract the content and create the cache first.
	 * The modify timestamp of the file is checked, so if the file was reloaded, it will be re-extracted.
	 * 
	 * @param $url The URL of the file (file should be located on the same domain) or the direct full path to the file
	 * @param $is_force_reindex Setting this TRUE will reset cache and re-extract the file content
	 * @param $is_local_file Setting this to TRUE allows to set $url to the LOCAL PATH instead of URL
	 * 
	 */
	public static function GetCachedFileContent_ByLocalLink($url, $is_force_reindex = false, $is_local_file = false, $is_enable_external_links = false)
	{
		$chunks = array();

		if (strlen($url) > 0) {

			$url_info = self::GetURLInfo($url, $is_local_file);

			if ($url_info['is_valid']) {
				if ($url_info['is_local']) {

					// URL is the local link

					$local = $url_info['local_path'];
	
					if ($local && is_file($local) && file_exists($local)) {
	
						// It's time to check the cache
						$mtime = date('Y-m-d H:i:s', filemtime($local));
						$hash = 'localurl-'.md5('localurl-hash-'.$url);
						
						$chunks = self::GetRawCache(-1, $hash, $mtime, $is_force_reindex, function() use ($url, $local, $mtime)
						{
							global $wpfts_core;
	
							if (!$wpfts_core) {
								return false;
							}
						
							$chunks = array(
								'post_title' => '',
								'post_content' => '',
							);
	
							if (function_exists('wpfts_extract_text')) {
								$t = wp_check_filetype($local, wp_get_mime_types());
	
								if (isset($t['type'])) {
									$t2 = wpfts_extract_text($local, $t['type']);
			
									if (isset($t2['content'])) {
										$chunks['post_content'] = $t2['content'];
									}
			
									$ch2 = $chunks;
									$method = isset($t2['method']) ? $t2['method'] : '';
									unset($ch2['method']);
			
									return array(
										'raw_data' => $ch2,
										'modified_time' => $mtime,
										'error' => $t2['error'],
										'filename' => $url,
										'method_id' => $method,
									);
		
								}
							}
	
							return false;
						});
	
					} else {
						$chunks['extract_error'] = 'Local file not exists: '.$local;
					}
	
				} else {
					// URL is the remote link, try to download to local temp folder
					if (!$is_enable_external_links) {
						// External links are disabled
						$chunks['extract_error'] = 'Disabled to process external link: '.$url;

						return $chunks;
					}

					$fake_modified_dt = '1970-02-02 00:00:00';

					// It's time to check the cache
					$mtime = $fake_modified_dt;
					$hash = 'externalurl-'.md5('externalurl-hash-'.$url);
						
					$chunks = self::GetRawCache(-1, $hash, $mtime, $is_force_reindex, function() use ($url, $mtime, $url_info)
						{
							global $wpfts_core;
	
							if (!$wpfts_core) {
								return false;
							}
						
							$chunks = array(
								'post_title' => '',
								'post_content' => '',
							);

							// Download the file to the temp folder
							$fn = uniqid('tempfile', true);

							$tempfn = wp_tempnam($fn);
							if ($url_info['file_ext']) {
								$tempfn = $tempfn.'.'.$url_info['file_ext'];
							}

							$timeout = 300;

							// Go download the file
							$response = wp_safe_remote_get(
								$url,
								array(
									'timeout'  => $timeout,
									'stream'   => true,
									'filename' => $tempfn,
								)
							);
						 
							if ( is_wp_error( $response ) ) {
								unlink( $tempfn );
								
								return array(
									'raw_data' => '',
									'modified_time' => $mtime,
									'error' => $response->get_error_message(),
									'filename' => $url,
									'method_id' => 0,
								);
							} else {
								$response_code = wp_remote_retrieve_response_code( $response );

								if ($response_code == 200) {
									// Extract from this file

								} else {
									unlink( $tempfn );

									return array(
										'raw_data' => '',
										'modified_time' => $mtime,
										'error' => 'HTTP Response code = '.$response_code,
										'filename' => $url,
										'method_id' => 0,
									);
	
								}
							}

							if (function_exists('wpfts_extract_text')) {
								$t = wp_check_filetype($tempfn, wp_get_mime_types());
	
								if (isset($t['type'])) {
									$t2 = wpfts_extract_text($tempfn, $t['type']);
			
									if (isset($t2['content'])) {
										$chunks['post_content'] = $t2['content'];
									}
			
									$ch2 = $chunks;
									$method = isset($t2['method']) ? $t2['method'] : '';
									unset($ch2['method']);
			
									unlink( $tempfn );

									return array(
										'raw_data' => $ch2,
										'modified_time' => $mtime,
										'error' => $t2['error'],
										'filename' => $url,
										'method_id' => $method,
									);
		
								}
							}

							unlink( $tempfn );
	
							return false;
						});					
				}
	
			} else {
				$chunks['extract_error'] = 'file link is not correct: '.$url;				
			}

		} else {
			$chunks['extract_error'] = 'file url is empty';
		}					

		return $chunks;
	}
}