<?php
if (! current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.'));

?>
	<div class="wrap">
		<h2><?php _e( 'Wispro integration','Wispro_integraton' ) ?></h2>
		Bienvenido a la Plugin de integracion con Wispro Cloud.
	</div>
<?php

$wispro_api = new wisproIntegrationRestApi();
$planes = $wispro_api->getPlans();

//form crear cliente
echo '<form action="'.admin_url('admin-post.php').'" method="post">';
echo '<input type="hidden" name="action" value="wisprointegration_create_client">';
echo '<input type="text" name="name" placeholder="Nombre del cliente">';
echo '<input type="text" name="email" placeholder="Email del cliente">';
echo '<input type="text" name="phone" placeholder="Telefono del cliente">';
echo '<input type="text" name="address" placeholder="Direccion del cliente">';
echo '<input type="text" name="city" placeholder="Ciudad del cliente">';
echo '<input type="text" name="state" placeholder="Estado del cliente">';
echo '<select name="plan" placeholder="Plan del cliente">';
if(!empty($planes->data)){
	foreach ($planes->data as $plan) {
		echo '<option value="'.$plan->id.'">'.$plan->name.'</option>';
	}
}else{
	echo '<option value="">No se encontraron planes</option>';
}
echo '<input type="submit" value="Crear cliente">';
echo '</form>';

