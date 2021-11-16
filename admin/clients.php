<?php
if (! current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.'));

?>
	<div class="wrap">
		<h2><?php _e( 'Clientes','Wispro_integraton' ) ?></h2>.
	</div>
<?php