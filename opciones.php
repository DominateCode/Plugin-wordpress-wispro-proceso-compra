<?php defined('ABSPATH') or die("Bye bye");

/** Funciones relacionadas con el menu de administracion */

function prefijo_menu_admin() {
    add_menu_page(
        'Wispro integration',
        'Wispro integration',
        'manage_options',
        WISPROINTEGRATION_PLUGIN_DIR.'/modulos/general/general.php'
    );
    
    add_submenu_page(
        WISPROINTEGRATION_PLUGIN_DIR.'/modulos/general/general.php',
        'Planes',
        'Planes',
        'manage_options',
        WISPROINTEGRATION_PLUGIN_DIR.'/modulos/planes/planes.php'
    );

   /* add_submenu_page(
        WISPROINTEGRATION_PLUGIN_DIR.'/modulos/general/general.php',
        'Pagos',
        'Pagos',
        'manage_options',
        WISPROINTEGRATION_PLUGIN_DIR.'/modulos/pagos/pagos.php'
    );*/
    
    add_submenu_page(
        WISPROINTEGRATION_PLUGIN_DIR.'/modulos/general/general.php',
        'Clientes',
        'Clientes',
        'manage_options',
        WISPROINTEGRATION_PLUGIN_DIR.'/modulos/clientes/clientes.php'
    );

    add_submenu_page(
        WISPROINTEGRATION_PLUGIN_DIR.'/modulos/general/general.php',
        'Configuration',
        'Configuration',
        'manage_options',
        WISPROINTEGRATION_PLUGIN_DIR.'/modulos/configuracion/configuracion.php'
    );
    
}
add_action( 'admin_menu', 'prefijo_menu_admin' );

//notices
function wispro_integration_admin_notice__info() {
    $class = 'notice notice-info';
    $message = __( 'Recuerada que para utilizar este plugin debes tener instalado y activado el thema Elkinetco o uno similar.', 'wisprointegration' );
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}
add_action( 'admin_notices', 'wispro_integration_admin_notice__info' );