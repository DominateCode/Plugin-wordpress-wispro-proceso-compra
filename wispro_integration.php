<?php
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
define('PATH_WISPINTEG',plugin_dir_path(__FILE__).'wisprointegration/');

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
