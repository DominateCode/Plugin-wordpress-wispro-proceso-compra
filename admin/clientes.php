<?php defined('ABSPATH') or die("Bye bye");
if (! current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.'));

//Pagina de listado y registro de clientes desde la rest api wispro cloud. 

$wispro_class = new wisprointegration();
?>
<div class="wrap">
    <h2><?php _e( 'Planes','Wispro_integraton' ) ?></h2>
    <?php 
	//comprobar option wisprointegration_api_token
	if(!$wispro_class->check()){
		echo '<div class="error"><p>'.__('Para utilizar el plugin porfavor termine de configurar el plugin en la pagina de configuracion.').'</p></div>';
	}else{
        get_table();
    } ?>
</div>

<?php

function get_table(){
    $testListTable = new table_clientes();
    $testListTable->prepare_items();
    $testListTable->display();
}

//clients_payment_gateways

