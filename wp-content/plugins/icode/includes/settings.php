<?php
//Settings *************************************************
function portal_page_html()
{ ?>
	<div class="settings-icode">
		<h1 class="title">Configurações da Página Inicial</h1>
		<hr>
		<form method="post" action="<?php echo admin_url('/options.php'); ?>">
			<?php settings_fields('portal_option_grupo'); ?>

			<!-- Name ********************************** -->
			<label>
				<h3 class="title">Nome do Site: </h3><input type="text" id="portal_input_0" name="portal_input_0" value="<?php echo get_option('portal_input_0'); ?>" />
			</label>		

			<br><br><!-- Colors *************************************** -->
			<hr>

			<label>
				<h3 class="title">Cor do Tema: </h3><input type="color" id="portal_input_1" name="portal_input_1" value="<?php echo get_option('portal_input_1'); ?>" />
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
			$image3 = get_option('portal_input_3'); ?>			
			<table>
				<tr>
					<td><a href="#" onclick="upload_image(1,3);" class="button button-secondary"><?php _e('Upload Image'); ?></a></td>
					<td><input type="text" name="portal_input_3" id="portal_input_3" value="<?php echo $image3; ?>" /></td>
					<td>&emsp;<a href="<?php echo $image3; ?>" target="_blank"><img style="height:30px" id="preview_portal_input_3" alt="preview" title="preview" src="<?php echo $image3; ?>" /></a></td>
				</tr>
				<tr>
					<td>
						<div>Título</div>
					</td>
					<td><input type="text" id="portal_input_4" name="portal_input_4" value="<?php echo get_option('portal_input_4'); ?>" /></td>
				</tr>
				<tr>
					<td>
						<div>Texto</div>
					</td>
					<td><textarea id="portal_input_5" name="portal_input_5"><?php echo get_option('portal_input_5'); ?></textarea></td>
				</tr>
				<tr>
					<td>
						<div>Botão (Nome,URL)</div>
					</td>
					<td><input type="text" id="portal_input_6" name="portal_input_6" value="<?php echo get_option('portal_input_6'); ?>" /></td>
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
				<h3 class="title">Telefone: </h3><input type="text" id="portal_input_8" name="portal_input_8" value="<?php echo get_option('portal_input_8'); ?>" />
			</label>
			<br><span>(+00 00 00000-0000)</span>

			<br><br><!-- E-Mail *************************************** -->
			<hr>

			<label>
				<h3 class="title">E-Mail: </h3><input type="email" id="portal_input_9" name="portal_input_9" value="<?php echo get_option('portal_input_9'); ?>" />
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
	add_submenu_page('themes.php', 'Pagina Inicial', 'Pagina Inicial', 'edit_posts', 'pagina-inicial', 'portal_page_html', 2);
}
add_action('admin_menu', 'portal_options_page');



//************************ DB Fields

function portal_settings0()
{
	add_option('portal_input_0');
	register_setting('portal_option_grupo', 'portal_input_0');
}
add_action('admin_init', 'portal_settings0');


function portal_settings1()
{
	add_option('portal_input_1');
	register_setting('portal_option_grupo', 'portal_input_1');
}
add_action('admin_init', 'portal_settings1');

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

function portal_settings6()
{
	add_option('portal_input_6');
	register_setting('portal_option_grupo', 'portal_input_6');
}
add_action('admin_init', 'portal_settings6');

function portal_settings7()
{
	add_option('portal_input_7');
	register_setting('portal_option_grupo', 'portal_input_7');
}
add_action('admin_init', 'portal_settings7');

function portal_settings8()
{
	add_option('portal_input_8');
	register_setting('portal_option_grupo', 'portal_input_8');
}
add_action('admin_init', 'portal_settings8');


function portal_settings9()
{
	add_option('portal_input_9');
	register_setting('portal_option_grupo', 'portal_input_9');
}
add_action('admin_init', 'portal_settings9');