<?php defined('ABSPATH') or die("Bye bye");

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
