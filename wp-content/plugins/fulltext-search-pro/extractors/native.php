<?php

add_action('wpfts_extractors_init', function($exts)
{
	global $wpfts_core;

	$exts = $wpfts_core->extractors;
	if (!isset($exts['native-php'])) {
		// Add Native PHP extractor
		$data = array(
			'title' => 'Native PHP',
			'is_ok' => true,
			'mimetypes' => array(
				'text/plain' => array(0, 'txt'),
				'application/pdf' => array(1, 'pdf'),
			),
			'notices' => array(1 => 'Average Quality - Some PDF files may be converted wrongly or not converted at all'),
			'ord' => 10,
			'execute' => "WPFTS_Extract_NativePHP",
		);

		$exts['native-php'] = $data;
	}
	$wpfts_core->extractors = $exts;
});

function WPFTS_Extract_NativePHP($filepath, $mimetype)
{
	$ret = array(
		'content' => '',
		'error' => '',
		'method' => 'nativephp'
	);

	if (file_exists($filepath) && is_file($filepath)) {
		// Check if this post has parseable file
		switch ($mimetype) {
			case 'application/pdf':
				// PDF
				ob_start();
				require_once dirname(__FILE__).'/../classes/pdftotext/PdfToText.class.php';
				try {
					@ini_set('pcre.backtrack_limit', 10000000);

					$pdf = new PdfToText($filepath);
					$ret['content'] = mb_convert_encoding($pdf->Text, 'UTF-8', 'UTF-8');	// Guarantee a valid UTF-8 string!
					
					//file_put_contents(dirname(__FILE__).'/2log.txt', print_r($chunks, true)."\n", FILE_APPEND);
				} catch (Exception $exc) {
					// Expression was catched
					$ret['error'] = '## Content extraction error: '.$exc->getMessage().' ##';
						
					//file_put_contents(dirname(__FILE__).'/2log.txt', print_r($chunks, true)."\n", FILE_APPEND);
				}
				$ze = ob_get_clean();	// We don't need for PdfToText output
				if (strlen($ze) > 0) {
					$ret['error'] .= "\n\n## Raw output: ".$ze;
				}
				break;
			case 'text/plain':
				// TXT
				// Plaintext file
				$ret['content'] = file_get_contents($filepath);
				break;
			default:
				// Not supported mimetype
				$ret['error'] = 'Mime-type "'.$mimetype.'" is not currently supported';
		}
	} else {
		// No file presents
		$ret['error'] = 'Specified file "'.$filepath.'" do not exist';
	}

	return $ret;	
}