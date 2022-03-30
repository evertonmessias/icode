<?php

/**  
 * Copyright 2013-2018 Epsiloncool
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 ******************************************************************************
 *  I am thank you for the help by buying PRO version of this plugin 
 *  at https://fulltextsearch.org/ 
 *  It will keep me working further on this useful product.
 ******************************************************************************
 * 
 *  @copyright 2013-2018
 *  @license GPL v3
 *  @package Wordpress Fulltext Search Pro
 *  @author Epsiloncool <info@e-wm.org>
 */

function wpfts_get_extracted_content_block($post_id)
{
	global $wpdb, $wpfts_core;
	
	ob_start();

	$idx = $wpfts_core->GetDBPrefix();

	// Read attachment content
	$q = 'select * from `'.$idx.'rawcache` where (`object_id` = "'.addslashes($post_id).'") and (`object_type` = "wp_post")';
	$res = $wpdb->get_results($q, ARRAY_A);

	if (count($res) > 0) {
		// Attachment content is present
		$data = @unserialize($res[0]['data']);

		$content = isset($data['post_content']) ? $data['post_content'] : '';

		$cached_dt = strtotime($res[0]['insert_dt']);
		$error = trim($res[0]['error']);
		if (strlen($error) < 1) {
			$error = '-';
		}

		$method = __('(not set)', 'fulltext-search');
		if (isset($res[0]['method_id']) && (strlen($res[0]['method_id']) > 0)) {
			switch ($res[0]['method_id']) {
				case 'textmill':
					$method = 'TextMill.io';
					break;
				case 'nativephp':
					$method = 'Native PHP';
					break;
				default:
					$method = ' (id): '.$res[0]['method_id'].'';
			}
		}

		?>
		<label for="attachment_extracted_content"><strong><?php echo __('WPFTS Extracted Content', 'fulltext-search'); ?></strong></label><br>
		<div id="wp-extracted_content-wrap" class="wp-core-ui wp-editor-wrap html-active">
			<link rel="stylesheet" id="editor-buttons-css" href="/wp-includes/css/editor.min.css?ver=4.9.5" type="text/css" media="all">
			<div id="wp-attachment_content-editor-container" class="wp-editor-container">
				<div id="qt_attachment_content_toolbar" class="quicktags-toolbar">
					<p>
					<span><b>Status</b>: Extracted on <b><?php echo date_i18n( get_option('date_format'), $cached_dt, false ); ?> <?php echo date('H:i:s', $cached_dt); ?></b> using <b><?php echo $method; ?></b></span><br>
					<span><b>Error</b>: <?php echo $error; ?></span><br>
					</p>
					<input type="button" class="wpfts_attachment_extracted_content_reindex ed_button button button-small" title="Re-extract the text again and reindex the post" value="Reindex Now" data-postid="<?php echo $post_id; ?>">&nbsp;<span class="wpfts_waiter_place"></span>
				</div>
				<?php
				if (mb_strlen($content) > 0) {
				?>
				<textarea class="widefat" name="extracted_content" id="attachment_extracted_content" rows="8" readonly="readonly">
				<?php 
					echo htmlspecialchars($content);
				?>
				</textarea>
				<?php
				}
				?>
			</div>
		</div>

		<?php

	} else {
		// No content for this attachment
		?>
		<label for="attachment_extracted_content"><strong><?php echo __('WPFTS Extracted Content', 'fulltext-search'); ?></strong></label><br>
		<div id="wp-extracted_content-wrap" class="wp-core-ui wp-editor-wrap html-active">
			<link rel="stylesheet" id="editor-buttons-css" href="/wp-includes/css/editor.min.css?ver=4.9.5" type="text/css" media="all">
			<div id="wp-attachment_content-editor-container" class="wp-editor-container">
				<div id="qt_attachment_content_toolbar" class="quicktags-toolbar">
					<p>
					<span><b>Status</b>: The content of this file was not yet extracted. <b>Be sure the indexer is not paused and try to refresh the page!</b> <a href="#" onclick="document.location.reload(); return false;">Refresh Now</a></span><br>
					</p>
					<input type="button" class="wpfts_attachment_extracted_content_reindex ed_button button button-small" title="Extract and index the content of this file" value="Extract Now" data-postid="<?php echo $post_id; ?>">&nbsp;<span class="wpfts_waiter_place"></span>
				</div>
			</div>
		</div>

		<?php
	}

	return ob_get_clean();
}

add_action('edit_form_after_editor', 'wpfts_edit_form_after_editor');
function wpfts_edit_form_after_editor($post) 
{
	global $wpdb, $wpfts_core;

	$screen = get_current_screen();
	if($screen->post_type=='attachment' && $screen->id=='attachment' && $post->post_type == 'attachment') {
		//echo "This is the edit post screen.";

		?>
		<div class="wpfts_extracted_content_block">
		<?php

		echo wpfts_get_extracted_content_block($post->ID);

		?>
		</div>
		<?php
	}
}