<?php
/** Es el fichero que define los métodos y acciones de limpieza para una correcta desinstalación del plugin.  */
defined('ABSPATH') or die("Bye bye");

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$options = [
    'elkinet_tools_api_url',
    'elkinet_tools_api_token',
    'elkinet_tools_whatsapp_number',
    'elkinet_tools_url_portal_cliente'
];

foreach ($options as $op){
    delete_option($op);
    delete_site_option($op);
}

//remove table sql
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}elkinet_tools_planes");