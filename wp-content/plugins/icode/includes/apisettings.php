<?php
//Settings *************************************************
function icapi_page_html()
{ ?>
	<div class="about-icode">
		<h1 class="title">Configurações do IC-API</h1>
		<hr>
		<form method="post" action="<?php echo admin_url('/options.php'); ?>">
			<?php settings_fields('icapi_option_grup'); ?>
			<!-- URL ********************************** -->
			<label>
				<h4>URL da API 1: </h4><input type="text" id="icapi_1" name="icapi_1" value="<?php echo get_option('icapi_1'); ?>" />&emsp;<span>Uso:&ensp;<b>[icapi1]</b></span>
			</label>
			<br><br><!-- *************************************** -->
			<label>
				<h4>URL da API 2: </h4><input type="text" id="icapi_2" name="icapi_2" value="<?php echo get_option('icapi_2'); ?>" />&emsp;<span>Uso:&ensp;<b>[icapi2]</b></span>
			</label>
			<br><br><!-- *************************************** -->
			<label>
				<h4>URL da API 3: </h4><input type="text" id="icapi_3" name="icapi_3" value="<?php echo get_option('icapi_3'); ?>" />&emsp;<span>Uso:&ensp;<b>[icapi3]</b></span>
			</label>
			<br><br><!-- *************************************** -->
			<label>
				<h4>URL da API 4: </h4><input type="text" id="icapi_4" name="icapi_4" value="<?php echo get_option('icapi_4'); ?>" />&emsp;<span>Uso:&ensp;<b>[icapi4]</b></span>
			</label>
			<br><br><!-- *************************************** -->

			<hr><br>
			<?php submit_button(); ?>
		</form>		
	</div>
<?php
}

function icapi_options_page()
{
	add_submenu_page('icode', 'API Settings', 'API Settings', 'edit_posts', 'apisettings', 'icapi_page_html', 3);
}
add_action('network_admin_menu', 'icapi_options_page');



//************************ DB Fields

function icapi_settings1()
{
	add_option('icapi_1');
	register_setting('icapi_option_grup', 'icapi_1');
}
add_action('admin_init', 'icapi_settings1');

function icapi_settings2()
{
	add_option('icapi_2');
	register_setting('icapi_option_grup', 'icapi_2');
}
add_action('admin_init', 'icapi_settings2');

function icapi_settings3()
{
	add_option('icapi_3');
	register_setting('icapi_option_grup', 'icapi_3');
}
add_action('admin_init', 'icapi_settings3');

function icapi_settings4()
{
	add_option('icapi_4');
	register_setting('icapi_option_grup', 'icapi_4');
}
add_action('admin_init', 'icapi_settings4');
