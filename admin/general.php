<?php
if (! current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.'));

$wispro_class = new wisprointegration();

?>
<div class="wrap">
	<h2><?php _e( 'Wispro integration','Wispro_integraton' ) ?></h2>
	<?php 
	//comprobar option wisprointegration_api_token
	if(!$wispro_class->check()){
		echo '<div class="error"><p>'.__('Para utilizar el plugin porfavor termine de configurar el plugin en la pagina de configuracion.').'</p></div>';
	}else{
		actions();
		?>
		<!-- html content -->
		<!-- begind: form opcion costo instalacion -->
		<form method="post" action="<?php echo admin_url('admin.php?page=wisprointegration%2Fadmin%2Fgeneral.php'); ?>">
			<?php settings_fields( 'wisprointegration_options' ); ?>
			<?php do_settings_sections( 'wisprointegration_options' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e( 'Costo de instalación','Wispro_integraton' ) ?></th>
					<td>
						<input type="text" name="costo_instalacion" value="<?php echo esc_attr( get_option('wisprointegration_costo_instalacion') ); ?>" />
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

	//post actions
	if (isset($_POST['costo_instalacion'])) {
		update_option ('wisprointegration_costo_instalacion', $_POST['costo_instalacion']);
		echo '<div class="updated"><p>' . __('Costo de instalación actualizado.') . '</p></div>';
	 }
} 