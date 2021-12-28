<?php
/** Es el fichero que define los métodos y acciones de limpieza para una correcta desinstalación del plugin.  */
defined('ABSPATH') or die("Bye bye");

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$options = [
    'wisprointegration_api_url',
    'wisprointegration_api_token',
    'wispro_integration_costo_instalacion',
    'wisprointegration_pagina_proceso_compras',
    'wisprointegration_whatsapp_number',
    'wisprointegration_url_portal_cliente'
];

foreach ($options as $op){
    delete_option($op);
    delete_site_option($op);
}

//remove table sql
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wispro_integration_planes");