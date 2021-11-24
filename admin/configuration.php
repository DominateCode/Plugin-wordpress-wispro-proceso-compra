<?php
if (! current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.'));
?>
<div class="wrap">
   <h2><?php _e( 'Wispro integration','Wispro_integraton' ) ?></h2>
   Bienvenido a la configuración de Wispro integration
   <?php actions(); ?>
   <div class="">
      <form method="post" action="<?php echo admin_url('admin.php?page=wisprointegration%2Fadmin%2Fconfiguration.php'); ?>">
         <?php settings_fields( 'wispro_integration_settings' ); ?>
         <?php do_settings_sections( 'wispro_integration_settings' ); ?>
         <table class="form-table">
            <!-- input llenar option api token -->
            <tr valign="top">
               <th scope="row">API Token</th>
               <td><input type="text" name="api_token" value="<?php echo esc_attr( get_option('wisprointegration_api_token') ); ?>" /></td>
            </tr>
            <!-- input llenar option url api token -->
            <tr valign="top">
               <th scope="row">URL API Token</th>
               <td><input type="text" name="url_api_token" value="<?php echo esc_attr( get_option('wisprointegration_api_url') ); ?>" /></td>
            </tr>
         </table>
         <?php submit_button(); ?>
      </form>
      <?php 
      //comprobar option wisprointegration_api_token
      $wispro_class = new wisprointegration();
      if(!$wispro_class->check()){
         echo '<div class="error"><p>'.__('Para utilizar el plugin porfavor termine de configurar el plugin en la pagina de configuracion.').'</p></div>';
      }else{
         ?>
         <!-- llenar tabla planes desde wispro cloud -->
         <form method="post" action="<?php echo admin_url('admin.php?page=wisprointegration%2Fadmin%2Fconfiguration.php&action=importar_planes_wispro_cloud'); ?>">
            <?php settings_fields( 'wispro_integration_settings' ); ?>
            <?php do_settings_sections( 'wispro_integration_settings' ); ?>
            <table class="form-table">
               <tr valign="top">
                  <th scope="row">Llenar tabla planes desde wispro cloud</th>
                  <td><input type="submit" name="wispro_integration_llenar_tabla_planes" value="Llenar tabla planes desde wispro cloud" /></td>
               </tr>
            </table>
         </form>
        
         <?php
      }
      ?>
   </div>
</div>
<?php


function actions(){
   //get actions 
   if(isset($_GET['action'])){
      switch($_GET['action']){
            case 'importar_planes_wispro_cloud':
               wispro_cloud_importar_planes();
               break;
      }
   }
  
   //post actions
   //action llenar api_token
   if (isset ($_POST['api_token'])) {
      update_option ('wisprointegration_api_token', $_POST['api_token']);
      echo '<div class="updated"><p>' . __('API Token actualizado.') . '</p></div>';
   }

   // action llenar wisprointegration_api_url
   if (isset ($_POST['url_api_token'])) {
      update_option ('wisprointegration_api_url', $_POST['url_api_token']);
      echo '<div class="updated"><p>' . __('URL API Token actualizado.') . '</p></div>';
   }
}

//llenar tabla planes desde wispro cloud
function wispro_cloud_importar_planes(){
   global $wpdb;
   $wispro = new WisproIntegrationRestApi();
   $planes = $wispro->getPlans();
   echo '<script> console.log('.$planes.')</script>';
   foreach ($planes->data as $key) {
      //comprobar si existe el plan en la tabla sql
      $plan = $key->id;
      $sql = "SELECT * FROM wispro_planes WHERE plan_id = '$plan'";
      $result = $wpdb->get_results($sql);
      //error al realizar la consulta
      if ($result === false) {
         return 'error';
      }

      //si no existe el plan en la tabla sql
      if(count($result) == 0){
         //insertar plan
         $insert = $wpdb->insert(
            $wpdb->prefix . 'wispro_integration_planes', array(
               'id' => $key->id,
               'nombre' => $key->name,
               'estrato' => '',
               'descripcion' => '',
               'precio' => $key->price,
               'subida_kb' => $key->ceil_down_kbps,
               'descarga_kb' => $key->ceil_up_kbps
            )
         );
         if( !$insert ) {
            echo '<div class="error"><p>' . __('Error al importar plan.'). $key->name . $wpdb->last_error . '</p></div>';
            return 'error';
         }
      } else {
         //actualizar plan
         $update = $wpdb->update('wispro_planes', array(
            'nombre' => $key->name,
            'precio' => $key->price,
            'subida_kb' => $key->ceil_down_kbps,
            'descarga_kb' => $key->ceil_up_kbps
         ), array('plan_id' => $key->id));
         if( !$update ) {
            echo '<div class="error"><p>' . __('Error al actualizar plan.'). $key->name . $wpdb->last_error  . '</p></div>';
            return 'error';
         }
      }
   }
   echo '<div class="updated"><p>' . __ ('Planes importados correctamente.') . '</p></div>';
}