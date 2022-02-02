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

    //check option wisprointegration_api_token
    $option_wisprointegration_api_token = get_option('wisprointegration_api_token');
    $option_wisprointegration_api_url = get_option('wisprointegration_api_url');
    if(!$option_wisprointegration_api_token || !$option_wisprointegration_api_url){ 
        
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
    }

    add_submenu_page(
        WISPROINTEGRATION_PLUGIN_DIR.'/modulos/general/general.php',
        'Configuration',
        'Configuration',
        'manage_options',
        WISPROINTEGRATION_PLUGIN_DIR.'/modulos/configuracion/configuracion.php'
    );
    
}
add_action( 'admin_menu', 'prefijo_menu_admin' );
