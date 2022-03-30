<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

$real_id = $id;
$id = $id . '_' . self::$perInstanceCount[$real_id];

$ana_options = wd_asp()->o['asp_analytics'];
$comp_options = wd_asp()->o['asp_compatibility'];

if (ASP_DEBUG < 1 && strpos(w_isset_def($comp_options['js_source'], 'min-scoped'), "scoped") !== false) {
    $scope = "aspjQuery";
} else {
    $scope = "jQuery";
}

$extra_class .= $style['box_compact_layout'] == 1 ? ' asp_compact' : ' asp_non_compact';
$extra_class .= $style['box_sett_hide_box'] == 1 ? ' hiddend' : '';
$extra_attrs = $style['box_compact_layout'] == 1 ? ' asp-compact="closed"' : '';
?>
<div class="asp_w_container">
	<div class='asp_w asp_m asp_m_<?php echo $real_id; ?> asp_m_<?php echo $id; ?> wpdreams_asp_sc wpdreams_asp_sc-<?php echo $real_id; ?> ajaxsearchpro asp_main_container <?php echo $extra_class; ?>'
		 data-id="<?php echo $real_id; ?>"
		 data-name="<?php echo esc_attr($search['name']); ?>"
		 <?php echo $extra_attrs; ?>
		 data-instance="<?php echo self::$perInstanceCount[$real_id]; ?>"
		 id='ajaxsearchpro<?php echo $id; ?>'>

		<?php
		/******************** PROBOX INCLUDE ********************/
		include('asp.shortcode.probox.php');
		?>
	</div>
	<div class='asp_data_container' style="display:none !important;">
		<?php
		/******************** SCRIPT INCLUDE (hidden) ********************/
		include('asp.shortcode.script.php');

		/******************** DATA INCLUDE (hidden) ********************/
		include('asp.shortcode.data.php');
		?>
	</div>
	<?php

	/******************** RESULTS INCLUDE ********************/
	include('asp.shortcode.results.php');

	$blocking = w_isset_def($style['frontend_search_settings_position'], 'hover');
	if ($blocking == 'block'): ?>
	<?php include('asp.shortcode.suggested.php'); ?>
	<div id='__original__ajaxsearchprobsettings<?php echo $id; ?>' class="asp_w asp_ss asp_sb asp_sb_<?php echo $real_id; ?> asp_sb_<?php echo $id; ?> asp_sb wpdreams_asp_sc wpdreams_asp_sc-<?php echo $real_id; ?> ajaxsearchpro searchsettings"
		data-id="<?php echo $real_id; ?>"
		data-instance="<?php echo self::$perInstanceCount[$real_id]; ?>">
	<?php else: ?>
	<div id='__original__ajaxsearchprosettings<?php echo $id; ?>' class="asp_w asp_ss asp_s asp_s_<?php echo $real_id; ?> asp_s_<?php echo $id; ?> wpdreams_asp_sc wpdreams_asp_sc-<?php echo $real_id; ?> ajaxsearchpro searchsettings"
		data-id="<?php echo $real_id; ?>"
		data-instance="<?php echo self::$perInstanceCount[$real_id]; ?>">
	<?php endif;

		/******************* SETTINGS INCLUDE *******************/
		include('asp.shortcode.settings.php');
		?>
	</div>

	<?php if ($blocking != 'block'): ?>
	<?php include('asp.shortcode.suggested.php'); ?>
	<?php endif;
	/******************* CLEARFIX *******************/
	if (w_isset_def($style['box_compact_float'], 'none') != 'none') {
		echo '<div class="wpdreams_clear"></div>';
	}

	/**************** USER CUSTOM CSS ECHO ****************/
	if (w_isset_def($style['custom_css'], "") != ""): ?>
		<?php
		if ( base64_decode($style['custom_css'], true) == true )
			$asp_c_css = stripcslashes( base64_decode($style['custom_css']) );
		else
			$asp_c_css = stripcslashes( $style['custom_css'] );
		$asp_c_css = str_replace( "_aspid", $id, $asp_c_css );
		?>
		<style type="text/css">
			/* User defined Ajax Search Pro Custom CSS */
			<?php echo $asp_c_css; ?>
		</style>
		<?php
	endif;

	/************* THEME CUSTOM CSS ECHO ******************/
	if (w_isset_def($style['custom_css_h'], "") != ""): ?>
		<?php
		if ( base64_decode($style['custom_css_h'], true) == true )
			$asp_c_css = stripcslashes( base64_decode($style['custom_css_h']) );
		else
			$asp_c_css = stripcslashes( $style['custom_css_h'] );
		$asp_c_css = str_replace( "_aspid", $id, $asp_c_css );
		?>
		<style type="text/css">
			/* Theme defined Ajax Search Pro Custom CSS */
			<?php echo $asp_c_css; ?>
		</style>
		<?php
	endif;
	?>
</div>
