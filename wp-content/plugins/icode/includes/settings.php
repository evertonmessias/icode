<?php
//Settings *************************************************
function portal_page_html()
{ ?>
	<div class="settings-icode">
		<h1 class="title">Configurações da Página Inicial</h1>
		<hr>
		<form method="post" action="options.php">
			<?php settings_fields('portal_option_grupo'); ?>

			<!-- Name ********************************** -->
			<label>
				<h3 class="title">Nome do Site: </h3><input type="text" id="portal_input_0" name="portal_input_0" value="<?php echo get_option('portal_input_0'); ?>" />
			</label>		

			<br><br><!-- Colors *************************************** -->
			<hr>

			<label>
				<h3 class="title">Cor do Tema: </h3><input type="color" id="portal_input_3" name="portal_input_3" value="<?php echo get_option('portal_input_3'); ?>" />
			</label>

			<br><br><!-- Logo *************************************** -->
			<hr>

			<?php
			$image2 = get_option('portal_input_2'); ?>
			<h3 class="title">Logo:</h3>
			<table>
				<tr>
					<td><a href="#" onclick="upload_image(1,2);" class="button button-secondary"><?php _e('Upload Image'); ?></a></td>
					<td><input type="text" name="portal_input_2" id="portal_input_2" value="<?php echo $image2; ?>" /></td>
					<td>&emsp;<a href="<?php echo $image2; ?>" target="_blank"><img style="height:30px" id="preview_portal_input_2" alt="preview" title="preview" src="<?php echo $image2; ?>" /></a></td>
				</tr>
			</table>
			<span>(Ideal size: 100x100 px)</span>
			

			<br><br><!-- Slides *************************************** -->
			<hr>

			<h3 class="title">Slide:</h3>

			<?php
			$image111 = get_option('portal_input_111'); ?>			
			<table>
				<tr>
					<td><a href="#" onclick="upload_image(1,111);" class="button button-secondary"><?php _e('Upload Image'); ?></a></td>
					<td><input type="text" name="portal_input_111" id="portal_input_111" value="<?php echo $image111; ?>" /></td>
					<td>&emsp;<a href="<?php echo $image111; ?>" target="_blank"><img style="height:30px" id="preview_portal_input_111" alt="preview" title="preview" src="<?php echo $image111; ?>" /></a></td>
				</tr>
				<tr>
					<td>
						<div>Título</div>
					</td>
					<td><input type="text" id="portal_input_112" name="portal_input_112" value="<?php echo get_option('portal_input_112'); ?>" /></td>
				</tr>
				<tr>
					<td>
						<div>Texto</div>
					</td>
					<td><textarea id="portal_input_113" name="portal_input_113"><?php echo get_option('portal_input_113'); ?></textarea></td>
				</tr>
				<tr>
					<td>
						<div>Botão (Nome,URL)</div>
					</td>
					<td><input type="text" id="portal_input_114" name="portal_input_114" value="<?php echo get_option('portal_input_114'); ?>" /></td>
				</tr>
			</table><br>

			<br><span>(<b>Slide</b>; Tamanho ideal: 1700x500 px)</span>
			<br><span>(<b>Botão</b>; Use <b>Nome,URL</b> separados por vírgulas.)</span>
			
			<br><br><!-- Texto Sobre ********************************** -->
			<hr>

			<label>
				<h3 class="title">Texto Sobre: </h3>
				<?php
				$portal7 = get_option('portal_input_7'); 
				wp_editor($portal7, 'portal_about_box', array('textarea_name' => 'portal_input_7'));
				?>
				
			</label>

			<br><br><!-- Fone *************************************** -->
			<hr>

			<label>
				<h3 class="title">Telefone: </h3><input type="text" id="portal_input_4" name="portal_input_4" value="<?php echo get_option('portal_input_4'); ?>" />
			</label>
			<br><span>(+00 00 00000-0000)</span>

			<br><br><!-- E-Mail *************************************** -->
			<hr>

			<label>
				<h3 class="title">E-Mail: </h3><input type="email" id="portal_input_5" name="portal_input_5" value="<?php echo get_option('portal_input_5'); ?>" />
			</label>
			<br><span>(only one)</span>					
			
			<br><br><!-- *************************************** -->
			<hr>	

			<?php submit_button(); ?>
		</form>
	</div>
<?php
}

function portal_options_page()
{
	add_submenu_page('icode', 'Pagina Inicial', 'Pagina Inicial', 'edit_posts', 'pagina-inicial', 'portal_page_html', 1);
}
add_action('admin_menu', 'portal_options_page');



//************************ DB Fields

function portal_settings0()
{
	add_option('portal_input_0');
	register_setting('portal_option_grupo', 'portal_input_0');
}
add_action('admin_init', 'portal_settings0');


function portal_settings111()
{
	add_option('portal_input_111');
	register_setting('portal_option_grupo', 'portal_input_111');
}
add_action('admin_init', 'portal_settings111');

function portal_settings112()
{
	add_option('portal_input_112');
	register_setting('portal_option_grupo', 'portal_input_112');
}
add_action('admin_init', 'portal_settings112');

function portal_settings113()
{
	add_option('portal_input_113');
	register_setting('portal_option_grupo', 'portal_input_113');
}
add_action('admin_init', 'portal_settings113');

function portal_settings114()
{
	add_option('portal_input_114');
	register_setting('portal_option_grupo', 'portal_input_114');
}
add_action('admin_init', 'portal_settings114');

function portal_settings115()
{
	add_option('portal_input_115');
	register_setting('portal_option_grupo', 'portal_input_115');
}
add_action('admin_init', 'portal_settings115');

function portal_settings116()
{
	add_option('portal_input_116');
	register_setting('portal_option_grupo', 'portal_input_116');
}
add_action('admin_init', 'portal_settings116');

function portal_settings117()
{
	add_option('portal_input_117');
	register_setting('portal_option_grupo', 'portal_input_117');
}
add_action('admin_init', 'portal_settings117');

function portal_settings118()
{
	add_option('portal_input_118');
	register_setting('portal_option_grupo', 'portal_input_118');
}
add_action('admin_init', 'portal_settings118');

function portal_settings119()
{
	add_option('portal_input_119');
	register_setting('portal_option_grupo', 'portal_input_119');
}
add_action('admin_init', 'portal_settings119');

function portal_settings120()
{
	add_option('portal_input_120');
	register_setting('portal_option_grupo', 'portal_input_120');
}
add_action('admin_init', 'portal_settings120');

function portal_settings121()
{
	add_option('portal_input_121');
	register_setting('portal_option_grupo', 'portal_input_121');
}
add_action('admin_init', 'portal_settings121');

function portal_settings122()
{
	add_option('portal_input_122');
	register_setting('portal_option_grupo', 'portal_input_122');
}
add_action('admin_init', 'portal_settings122');

function portal_settings2()
{
	add_option('portal_input_2');
	register_setting('portal_option_grupo', 'portal_input_2');
}
add_action('admin_init', 'portal_settings2');

function portal_settings3()
{
	add_option('portal_input_3');
	register_setting('portal_option_grupo', 'portal_input_3');
}
add_action('admin_init', 'portal_settings3');

function portal_settings4()
{
	add_option('portal_input_4');
	register_setting('portal_option_grupo', 'portal_input_4');
}
add_action('admin_init', 'portal_settings4');

function portal_settings5()
{
	add_option('portal_input_5');
	register_setting('portal_option_grupo', 'portal_input_5');
}
add_action('admin_init', 'portal_settings5');


function portal_settings7()
{
	add_option('portal_input_7');
	register_setting('portal_option_grupo', 'portal_input_7');
}
add_action('admin_init', 'portal_settings7');