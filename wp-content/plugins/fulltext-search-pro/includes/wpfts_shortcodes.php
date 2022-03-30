<?php

/**  
 * Copyright 2013-2021 Epsiloncool
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
 *  @copyright 2013-2021
 *  @license GPL v3
 *  @package Wordpress Fulltext Search
 *  @author Epsiloncool <info@e-wm.org>
 */

add_shortcode('wpfts_widget', function($atts)
{
	$preset_id = isset($atts['preset']) ? trim($atts['preset']) : '';
	//$type = isset($atts['type']) ? trim($atts['type']) : '';
	$class = isset($atts['class']) ? trim($atts['class']) : '';

	$preset_id2 = $preset_id;
	if (strlen($preset_id) < 1) {
		$preset_id2 = 'default';
	}

	// Get preset data
	$preset = array(
		'results_url' => home_url('/'),
		'autocomplete_mode' => 1,
	);
	if ((strlen($preset_id) > 0) && (function_exists('WPFTS_Get_Widget_List'))) {
		$prs = WPFTS_Get_Widget_List();
		if (isset($prs[$preset_id])) {
			$preset = $prs[$preset_id];
		}
	}

	$preset = apply_filters('wpfts_preset_data', $preset, $preset_id, 'widget');

	ob_start();
	?>
	<div class="wpfts_widget wpfts_search_widget presetid-<?php echo $preset_id2; ?><?php echo strlen($class) > 0 ? ' '.$class : ''; ?>">
		<form role="search" class="wpfts_search_form-<?php echo htmlspecialchars($preset_id2); ?> search-form <?php echo $preset['autocomplete_mode'] ? ' wpfts_autocomplete': ''; ?>" action="<?php echo htmlspecialchars($preset['results_url']); ?>" method="get">
			<?php echo (strlen($preset_id) > 0) ? '<input type="hidden" name="wpfts_wdgt" value="'.htmlspecialchars($preset_id).'">' : ''; ?>
			<label>
				<span class="screen-reader-text"><?php echo __('Search for:', 'fulltext-search'); ?></span>
				<input type="search" class="search-field" placeholder="<?php echo __('Search &hellip;', 'fulltext-search'); ?>" value="<?php echo get_search_query(); ?>" name="s">
			</label>
			<input type="submit" class="search-submit" value="<?php echo __('Search', 'fulltext-search'); ?>">
		</form>
	</div>
	<?php
	$out = ob_get_clean();

	$out = apply_filters('wpfts_widget_html', $out, $preset, $preset_id, 'widget');

	return $out;
});