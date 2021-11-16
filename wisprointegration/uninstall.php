<?php
/** Es el fichero que define los métodos y acciones de limpieza para una correcta desinstalación del plugin.  */
defined('ABSPATH') or die("Bye bye");


if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}


delete_option('wisprointegration_api_token');
delete_site_option('wisprointegration_api_token');