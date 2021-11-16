<?php
/** Archivo principal del plugin, Contiene una cabecera estándar con los datos mínimos que WordPress necesita para realizar la instalación del plugin. Además, se definen las constantes y se realizan acciones iniciales.  */
/**
 * @package wispro_integration
 * @version 0.0.1
 */
/*
Plugin Name: Wispro Integration
Plugin URI: http://dominatecode-co.com/wispro_api_worpress_plugin/
Description: Este es un plugin que permite la integracion de wordpress con la api de wispro. permite convertir a wordpress integrarse con algunas de las capacidades de wispro.
Author: DominateCode
Version: 0.0.1
Author URI: http://DominateCode-co.com/
Licence: 
*/
defined('ABSPATH') or die("Bye bye");
define('PATH_WISPINTEG',plugin_dir_path(__FILE__));

include(PATH_WISPINTEG.'/includes/opciones.php');
include(PATH_WISPINTEG.'/includes/actions.php');

require_once PATH_WISPINTEG.'class.wisprointegrationRestApi.php';

function wispro_integration_activar(){
   add_option('wisprointegration_api_token', '', NULL, 'yes');
} //activar
register_activation_hook(__FILE__, 'wispro_integration_activar');

function wispro_integration_desactivar(){

} //desactivar
register_deactivation_hook(__FILE__, 'wispro_integration_desactivar');

function scripts(){
   wp_enqueue_style('wispro_integration_css', plugins_url('/css/wispro_integration.css', __FILE__));
   wp_enqueue_script('wispro_integration_js', plugins_url('/js/wispro_integration.js', __FILE__), array('jquery'));
} //scripts
add_action('wp_enqueue_scripts', 'scripts');