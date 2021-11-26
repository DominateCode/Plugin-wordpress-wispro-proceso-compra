<?php
/** Es el fichero que define los métodos y acciones de limpieza para una correcta desinstalación del plugin.  */
defined('ABSPATH') or die("Bye bye");

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

delete_option('wisprointegration_api_url');
delete_site_option('wisprointegration_api_url');

delete_option('wisprointegration_api_token');
delete_site_option('wisprointegration_api_token');

delete_option('wispro_integration_costo_instalacion');
delete_site_option('wispro_integration_costo_instalacion');

delete_option('wisprointegration_pagina_proceso_compras');
delete_site_option('wisprointegration_pagina_proceso_compras');

delete_option('wisprointegration_whatsapp_number');
delete_site_option('wisprointegration_whatsapp_number');

delete_option('wisprointegration_pagina_proceso_compras');
delete_site_option('wisprointegration_pagina_proceso_compras');

//remove table sql
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wispro_integration_planes");