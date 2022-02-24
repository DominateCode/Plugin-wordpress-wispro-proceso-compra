<?php defined('ABSPATH') or die("Bye bye");
if (! current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.'));

$wispro_class = new elkinet_tools();

	//comprobar option elkinet_tools_api_token
	if(!$wispro_class->check()){
		echo '<div class="error"><p>'.__('Para utilizar el plugin porfavor termine de configurar el plugin en la pagina de configuracion.').'</p></div>';
	}else{
		actions();
		?>
		<!-- html content -->
		<!-- begind: form opcion costo instalacion -->
		<form method="post" action="<?php echo admin_url('admin.php?page=elkinet_tools'); ?>">
			<?php settings_fields( 'elkinet_tools_options' ); ?>
			<?php do_settings_sections( 'elkinet_tools_options' ); ?>
			<table class="form-table">
				<!-- option whatsapp number -->
				<tr valign="top">
					<th scope="row"><?php _e( 'Número de whatsapp','Wispro_integraton' ) ?></th>
					<td>
						<input type="text" name="whatsapp_number" value="<?php echo esc_attr( get_option('elkinet_tools_whatsapp_number') ); ?>" />
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
		<!-- end form opcion costo instalacion --> 
	<?php } ?>
</div>
<?php

function actions(){
	//get actions
	if (isset($_POST['whatsapp_number'])) {
		$number = str_replace(" ", "", $_POST['whatsapp_number']); 
		$number = str_replace("+", "", $number); 
		update_option ('elkinet_tools_whatsapp_number', $number);
		echo '<div class="updated"><p>' . __('Número de whatsapp actualizado.') . '</p></div>';
	}
} 