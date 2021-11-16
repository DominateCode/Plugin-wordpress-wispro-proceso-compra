<?php defined('ABSPATH') or die("Bye bye");

/** Funciones relacionadas con el menu de administracion */

function prefijo_menu_admin() {
    add_menu_page(
       'Wispro integration',
        'Wispro integration',
        'manage_options',
        PATH_WISPINTEG.'admin/general.php'
    );
    add_submenu_page(
        PATH_WISPINTEG.'admin/general.php',
        'Configuration',
        'Configuration',
        'manage_options',
        PATH_WISPINTEG.'admin/configuration.php'
    );
}
add_action( 'admin_menu', 'prefijo_menu_admin' );

function shortcode_proceso_compra($atts) {
    ob_start();
    include PATH_WISPINTEG.'public/page-proceso_compra.php';
    return ob_get_clean();
}
add_shortcode( 'wispro_proceso_compra', 'shortcode_proceso_compra' );

