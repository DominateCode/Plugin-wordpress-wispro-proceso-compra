<?php
if (! current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.'));
$wispro_class = new wisprointegration();
$wispro_api = new wisprointegrationRestApi();

?>
<div class="wrap">
    <h2><?php _e( 'Planes','Wispro_integraton' ) ?></h2>
    <?php 
	//comprobar option wisprointegration_api_token
	if(!$wispro_class->check()){
		echo '<div class="error"><p>'.__('Para utilizar el plugin porfavor termine de configurar el plugin en la pagina de configuracion.').'</p></div>';
	}else{
		actions();
        get_table();

        //echo script console
        echo '<script> console.log('. json_encode($wispro_api->getPlans()). '); </script>'; 
        
        add_thickbox(); 
    } ?>
</div>

<?php

function get_table(){
    $testListTable = new table_planes();
    $testListTable->prepare_items();
    $testListTable->display();
}

function actions(){
    //actions get method
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'add':
                add_plan();
                break;
            case 'edit':
                edit_plan();
                break;
        }
    }
    //actions post method
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case 'delete':
                delete_plan();
                break;
        }
    }
}

function add_plan(){    
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $subida_kb = $_POST['subida_kb'];
    $bajada_kb = $_POST['descarga_kb'];

    $wpdb->insert($wpdb->prefix . 'planes', array (
        'id' => $id, 
        'nombre' => $nombre, 
        'precio' => $precio, 
        'descripcion' => $descripcion, 
        'subida_kb' => $subida_kb, 
        'descarga_kb' => $descarga_kb
    ));

    $message = '<div class="updated"><p>Plan agregado correctamente.</p></div>';
    echo $message;
}

function edit_plan(){
    // action post editar plan
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $subida_kb = $_POST['subida_kb'];
    $descarga_kb = $_POST['descarga_kb'];

    $wpdb->update($wpdb->prefix . 'planes', array (
        'nombre' => $nombre, 
        'precio' => $precio, 
        'descripcion' => $descripcion, 
        'subida_kb' => $subida_kb, 
        'descarga_kb' => $descarga_kb
    ), array ('id' => $id));

    $message = '<div class="updated"><p>Plan editado correctamente.</p></div>';
    echo $message;
}

function delete_plan(){
//action post eliminar plan
    $id = $_POST['id'];
    $wpdb->delete($wpdb->prefix . 'planes', array ('id' => $id));
    $message = '<div class="updated"><p>Plan eliminado correctamente.</p></div>';
    echo $message;
}