<?php defined('ABSPATH') or die("Bye bye");
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
		<form method="post" action="<?php echo admin_url('admin.php?page=wisprointegration%2fmodulos%2Fgeneral%2Fgeneral.php'); ?>">
			<?php settings_fields( 'wisprointegration_options' ); ?>
			<?php do_settings_sections( 'wisprointegration_options' ); ?>
			<table class="form-table">
				<!-- option costo instalacion -->
				<tr valign="top">
					<th scope="row"><?php _e( 'Costo de instalación','Wispro_integraton' ) ?></th>
					<td>
						<input type="text" name="costo_instalacion" value="<?php echo esc_attr( get_option('wisprointegration_costo_instalacion') ); ?>" />
					</td>
				</tr>
				<!-- option select pagina del proceso de compras -->
				<tr valign="top">
					<th scope="row"><?php _e( 'Página del proceso de compras','Wispro_integraton' ) ?></th>
					<td>
						<select name="page_compras">
							<option value="0"><?php _e( 'Seleccione una página','Wispro_integraton' ) ?></option>
							<?php 
							$pages = get_pages();
							foreach ( $pages as $page ) {
								$selected = (get_option('wisprointegration_pagina_proceso_compras') == $page->ID) ? 'selected' : '';
								echo '<option value="'.$page->ID.'" '.$selected.'>'.$page->post_title.'</option>';
							}
							?>
						</select>
					</td>
				</tr>
				<!-- option whatsapp number -->
				<tr valign="top">
					<th scope="row"><?php _e( 'Número de whatsapp','Wispro_integraton' ) ?></th>
					<td>
						<input type="text" name="whatsapp_number" value="<?php echo esc_attr( get_option('wisprointegration_whatsapp_number') ); ?>" />
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
	if (isset($_POST['page_compras'])) {
		update_option ('wisprointegration_pagina_proceso_compras', $_POST['page_compras']);
		echo '<div class="updated"><p>' . __('Página del proceso de compras actualizada.') . '</p></div>';
	}
	if (isset($_POST['whatsapp_number'])) {
		$number = str_replace(" ", "", $_POST['whatsapp_number']); 
		$number = str_replace("+", "", $number); 
		update_option ('wisprointegration_whatsapp_number', $number);
		echo '<div class="updated"><p>' . __('Número de whatsapp actualizado.') . '</p></div>';
	}
} 