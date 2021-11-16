<?php
if (! current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.'));
?>
	<div class="wrap">
    <h2><?php _e( 'Wispro integration','Wispro_integraton' ) ?></h2>
		Bienvenido a la configuración de Wispro integration
	</div>
<?php
 ?>