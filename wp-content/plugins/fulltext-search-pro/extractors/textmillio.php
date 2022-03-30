<?php

add_action('wpfts_extractors_init', function($exts)
{
	global $wpfts_core;

	$exts = $wpfts_core->extractors;
	if (!isset($exts['textmill'])) {
		// Add Textmill.io extractor
		$tm_data = $wpfts_core->get_option('tm_data');

		$mimetypes = array();
		$is_ok = 0;
		if ($tm_data && isset($tm_data['supported_exts'])) {

			$is_ok = 1;

			$lic = isset($tm_data['license']['enabled_exts']) ? $tm_data['license']['enabled_exts'] : array();

			foreach ($tm_data['supported_exts'] as $level => $list) {
				foreach ($list as $k_ext => $k_mimes) {
					$t_ena = 2;
					if (isset($lic[$k_ext])) {
						$t_ena = 0;
					}
					// Unpack extensions
					$mimelist = explode(',', $k_mimes);
					$extlist = explode('|', $k_ext);
					foreach ($mimelist as $dd) {
						$t_mime = mb_strtolower(trim($dd));
						$mimetypes[$t_mime] = array($t_ena, $extlist);
					}
				}
			}
		}

		$data = array(
			'title' => 'TextMill.io',
			'is_ok' => $is_ok,
			'mimetypes' => $mimetypes,
			'notices' => array(),
			'ord' => 20,
			'execute' => "WPFTS_Extract_TextMill",
		);

		$exts['textmill'] = $data;
	}
	$wpfts_core->extractors = $exts;
});

function WPFTS_Extract_TextMill($filepath, $mimetype)
{
	global $wpfts_core;

	$ret = array(
		'content' => '',
		'error' => '',
		'method' => 'textmill',
	);
	$target_url = 'https://textmill.io/api/index.php';

	if (!file_exists($filepath)) {
		$ret['error'] = 'File '.$filepath.' do not exist.';
		$ret['content'] = '';
		
		return $ret;
	}

	// Check if this filetype/mimetype supported by TextMill.io current license (to avoid data send)


	/*
	$post = array (
		'license_key' => $this->get_option('subscription_key'),
		'file_contents' => new CURLFile ($filepath),
	);

	$ch = curl_init ($target_url);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec ($ch);
	curl_close ($ch); 
	*/

	/*
	// CURL is buggy with utf-8 filenames, thus we are using this patch instead.
	$context = $wpfts_core->MakePOSTFileContext(array(
		'license_key' => $wpfts_core->get_option('subscription_key'),
	), array(
		'file_contents' => $filepath,
	));

	if (is_array($context) && isset($context['error'])) {
		// Error!
		$ret['error'] = $context['error'];
		$ret['content'] = '';
		return $ret;
	}

	$result = @file_get_contents($target_url, false, $context);
	*/

	$encbody = $wpfts_core->EncodePOSTBody(array(
		'license_key' => $wpfts_core->get_option('subscription_key'),
	), array(
		'file_contents' => $filepath,
	));

	$wpres = wp_remote_post($target_url, array(
		'headers' => $encbody['headers'],
		'body' => $encbody['body'],
		'timeout' => 300,
	));

	if (is_wp_error($wpres)) {
		// Error happen
		$ret['error'] = 'remote POST failed: '.$wpres->get_error_message();
		$ret['content'] = '';
		return $ret;
	}

	if (isset($wpres['response']['code'])) {
		if ($wpres['response']['code'] == 200) {
			// Seems to be OK
			$rr = @json_decode($wpres['body'], true);
	
			if (isset($rr['code'])) {
				if ($rr['code'] == 0) {
					// Service is ok
					if (isset($rr['output'])) {
						$ret['error'] = isset($rr['output']['error']) ? $rr['output']['error'] : '';
						$ret['content'] = isset($rr['output']['content']) ? $rr['output']['content'] : '';
					} else {
						$ret['error'] = 'TextMill.io output is empty';
						$ret['content'] = '';
					}
				} else {
					$ret['error'] = 'TextMill.io response error: '.(isset($rr['error']) ? $rr['error'] : '');
					$ret['content'] = '';
				}
			} else {
				$ret['error'] = 'TextMill.io did\'t respond correctly';
				$ret['content'] = '';
			}
		} else {
			$ret['error'] = 'TextMill.io did\'t respond correctly: error '.$wpres['response']['code'];
			$ret['content'] = '';
		}
	} else {
		$ret['error'] = 'TextMill.io did\'t respond correctly: no response code';
		$ret['content'] = '';
	}

	return $ret;
}
