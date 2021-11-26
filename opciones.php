<?php defined('ABSPATH') or die("Bye bye");

/** Funciones relacionadas con el menu de administracion */


function prefijo_menu_admin() {
    add_menu_page(
       'Wispro integration',
        'Wispro integration',
        'manage_options',
        WISPROINTEGRATION_PLUGIN_DIR.'admin/general.php'
    );
    
    add_submenu_page(
        WISPROINTEGRATION_PLUGIN_DIR.'admin/general.php',
        'Planes',
        'Planes',
        'manage_options',
        WISPROINTEGRATION_PLUGIN_DIR.'admin/planes.php'
    );

    add_submenu_page(
        WISPROINTEGRATION_PLUGIN_DIR.'admin/general.php',
        'Pagos',
        'Pagos',
        'manage_options',
        WISPROINTEGRATION_PLUGIN_DIR.'admin/pagos.php'
    );

    add_submenu_page(
        WISPROINTEGRATION_PLUGIN_DIR.'admin/general.php',
        'Configuration',
        'Configuration',
        'manage_options',
        WISPROINTEGRATION_PLUGIN_DIR.'admin/configuration.php'
    );
    
}
add_action( 'admin_menu', 'prefijo_menu_admin' );

function shortcode_proceso_compra($atts) {
    ob_start();
    include WISPROINTEGRATION_PLUGIN_DIR.'shortcodes/shortcode-proceso_compra.php';
    return ob_get_clean();
}
add_shortcode( 'wispro_proceso_compra', 'shortcode_proceso_compra' );

function shortcode_planes($atts) {
    ob_start();
    include WISPROINTEGRATION_PLUGIN_DIR.'shortcodes/shortcode-planes.php';
    return ob_get_clean();
}
add_shortcode( 'wisprointegration_planes', 'shortcode_planes' );


//notices
function wispro_integration_admin_notice__info() {
    $class = 'notice notice-info';
    $message = __( 'Recuerada que para utilizar este plugin debes tener instalado y activado el thema Elkinetco o uno similar.', 'Wispro_integraton' );
 
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}
add_action( 'admin_notices', 'wispro_integration_admin_notice__info' );
