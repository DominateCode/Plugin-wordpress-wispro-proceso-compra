<?php
/** Archivo principal del plugin, 
 * Contiene una cabecera estándar con los datos mínimos que WordPress necesita 
 * para realizar la instalación del plugin. Además, se definen las constantes y 
 * se realizan acciones iniciales.  
*/
/**
 * @package elkinet_tools
 * @version 0.0.1
 */
/*
Plugin Name: Elkinet Tools
Plugin URI: http://dominatecode-co.com/wispro_api_worpress_plugin/
Description: Este es un plugin que permite la integracion de wordpress con la api de wispro. permite convertir a wordpress integrarse con algunas de las capacidades de wispro.
Author: DominateCode
Version: 0.0.1
Author URI: http://DominateCode-co.com/
Licence: 
*/
defined('ABSPATH') or die("Bye bye");
define('elkinet_tools_PLUGIN_DIR', plugin_dir_path(__FILE__));

//cargar classes 
if(!class_exists('WP_List_Table')){
   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
require_once(elkinet_tools_PLUGIN_DIR.'/includes/class.elkinet_tools_RestApi.php');
require_once(elkinet_tools_PLUGIN_DIR.'/includes/class.elkinet_tools.php');

include(elkinet_tools_PLUGIN_DIR.'/opciones.php');
include(elkinet_tools_PLUGIN_DIR.'/actions.php');
require_once(elkinet_tools_PLUGIN_DIR.'/shortcodes.php');

//Función que se ejecuta cuando el plugin es activado
function elkinet_tools_activar(){
   load_plugin_textdomain('elkinet_tools');
   //crear options para el plugin.
  // add_option('elkinet_tools_costo_instalacion','',NULL,'yes');
   add_option('elkinet_tools_api_token', '', NULL, 'yes');
   add_option('elkinet_tools_api_url', '', NULL, 'yes');
   add_option('elkinet_tools_whatsapp_number', '', NULL, 'yes');
   add_option('elkinet_tools_url_portal_cliente','', NULL, 'yes');

   //crear tabla de planes
   global $wpdb;
   $tabla_planes = $wpdb->prefix . 'elkinet_tools_planes';
   if ( $wpdb->get_var("SHOW TABLES LIKE '$tabla_planes'") != $tabla_planes ) {
      // Table was not created !!
      $charset_collate = $wpdb->get_charset_collate();
      $sql = "CREATE TABLE $tabla_planes (
         id INT(4) NOT NULL AUTO_INCREMENT,
         nombre VARCHAR(255) NOT NULL,
         estrato varchar(16),
         subida_kb int(3) NOT NULL,
         descarga_kb int(3) NOT NULL,
         num_dispositivos int(2),
         woocomerce_product_id bigint(20),
         PRIMARY KEY (id)
      ) $charset_collate;";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
   }
}
register_activation_hook(__FILE__, 'elkinet_tools_activar');

//función que se ejecuta cuando el plugin es desactivado
function elkinet_tools_desactivar(){

} 
register_deactivation_hook(__FILE__, 'elkinet_tools_desactivar');

//scripts para el frontend
function scripts(){
   wp_enqueue_style('elkinet_tools_css', plugins_url('/css/elkinet_tools.css', __FILE__));
   wp_enqueue_script('elkinet_tools_js', plugins_url('/js/elkinet_tools.js', __FILE__), array('jquery'));
   wp_localize_script('elkinet_tools_js', 'elkinet_tools_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'scripts');
