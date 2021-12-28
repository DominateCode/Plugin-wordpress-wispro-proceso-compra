<?php defined('ABSPATH') or die("adios adios"); 

  echo '<script type="text/javascript"> console.log('.json_encode($_POST).'); </script>';
 
  $proceso = proceso_compra();
  $message = $proceso['message'];

  function proceso_compra(){
    $respuesta = array();
    $wispro_api = new WisproIntegrationRestApi();

    if(isset($_POST['form_compra'])){
      //variables
      $planid = $_POST['plan'];

      $client = array(
        'email' => $_POST['email'],
        'name' => $_POST['name'],
        'city' => $_POST['city'], 
        'address' => $_POST['address'],
        'phone_mobile' => $_POST['phone_mobile'],
        'national_identification_number' => $_POST['national_identification_number'],
        'state' => function(){
          $ciudad = $_POST['city'];
          if ($ciudad = 'Miranda') { 
            return 'Cauca';
          }
          if ($ciudad = 'Padilla') { 
            return 'Cauca';
          }
          if ($ciudad = 'Florida') { 
            return 'Valle';
          }
        }
      );

      //comprobar por cedula si existe el cliente
      $client_exist = $wispro_api->remote_GET('/clients',[
        'national_identification_number_eq' => $client['national_identification_number']
      ]);

      if(!empty($client_exist) && $client_exist->meta->pagination->total_records != 0){
        $respuesta['message'] = '<div class="alert alert-danger" role="alert">
         El cliente con el numero de documento '.$client['national_identification_number'].' ya se encuentra registrado.<br>
         Accede desde <a href="'.get_option('wisprointegration_url_portal_cliente').'">aqui</a> al portal de cliente.
        </div>';
      }else{
        //crear cliente
       // $client = $wispro_api->remote_POST('/clients',$client);

        $respuesta['message'] = '<div class="alert alert-success" role="alert">
        A simple success alert—check it out!
        </div>';

        //crear contrato 
        ////generar factura inicial
        //realizar pago de la factura inicial por gateway de pago
      }
    }
    return $respuesta;
  }
?>

<div class="wrap color-secundario-bg px-2 pb-2 pt-5">
  <h2 class="has-text-align-center text-white mx-3">Compra tu Plan en 3 pasos</h2>
  <!-- Pills navs -->
  <ul class="nav nav-pills justify-content-center text-center py-3 mb-3 mx-auto" id="ex1" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link link-white" aria-current="page" id="ex1-tab-1" data-mdb-toggle="pill" href="#ex1-pills-1" role="tab"
        aria-controls="ex1-pills-1" aria-selected="true">
        <div class="rounded-circle mx-auto circulo-contenedor-border-left">
          <div class="color-terciario rounded-circle mx-auto circulo-contenedor <?php echo (isset($_GET['paso']) && $_GET['paso'] == 1)? 'circulo-contenedor-selected' : ''; echo(isset($_GET['paso']) && $_GET['paso'] != 1)?'bg-light': ''; echo (!isset($_GET['paso'])) ? 'circulo-contenedor-selected' : ''; ?> fs-3">1</div> 
        </div>  
        <span class="BwSurcoDemo-Regular">Elige tu plan</span>
      </a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link link-white" id="ex1-tab-2" data-mdb-toggle="pill" href="#ex1-pills-2" role="tab"
        aria-controls="ex1-pills-2" aria-selected="false">
        <div class="rounded-circle mx-auto circulo-contenedor-border-left">
          <div class="color-terciario rounded-circle mx-auto circulo-contenedor <?php echo (isset($_GET['paso']) && $_GET['paso'] == 2)? 'circulo-contenedor-selected' : 'bg-light'; ?> fs-3">2</div>
        </div>
        <span class="BwSurcoDemo-Regular">Datos de compra </span>
      </a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link link-white" id="ex1-tab-3" data-mdb-toggle="pill" href="#ex1-pills-3" role="tab"
        aria-controls="ex1-pills-3" aria-selected="false"> 
        <div class="rounded-circle mx-auto circulo-contenedor-border-left">
          <div class="color-terciario rounded-circle mx-auto circulo-contenedor <?php echo (isset($_GET['paso']) && $_GET['paso'] == 3)? 'circulo-contenedor-selected' : 'bg-light'; ?> fs-3">3</div>
        </div>
        <span class="BwSurcoDemo-Regular">Finalizar compra</span>
      </a>
    </li>
  </ul>
  <!-- Pills navs -->

  <!-- Pills content -->
  <div class="tab-content" id="ex1-content">
    <div class="tab-pane fade <?php echo (isset($_GET['paso']) && $_GET['paso'] == '1' ) ? 'show active' : ''; echo (!isset($_GET['paso'])) ? 'show active' : ''; ?> container-fluid" id="ex1-pills-1" role="tabpanel" aria-labelledby="ex1-tab-1"> 
      <p class="has-text-align-center text-black mx-3 fs-2 montserrat-extrabold ">Planes para todos</p>
      <p class="has-text-align-center fs-5 BwSurcoDemo-Regular text-black mx-3">Elige el plan se ajuste a tus necesidades</p>
      <p class="has-text-align-center fs-5 BwSurcoDemo-Regular text-light mx:sm-3">Al contratar el servicio de Internet, podrás navegar en Youtube, Correo electrónico, Redes sociales, Netflix, descargas y mucho más.</p>
      <div class="my-5">
        <!-- BEGIND: COLUMNAS DE PLANES -->
        <div class="row row-cols-1 row-cols-md-3 g-5">
          <?php 
            global $wpdb; 
            $table_name = $wpdb->prefix."wispro_integration_planes";
            $planes = $wpdb->get_results("SELECT * FROM $table_name");
            foreach ($planes as $plan) {
                echo '<div class="col">';
                echo  '<div class="card br-2">';
                echo     '<div class="card-header text-center fw-bold color-primario-bg color-title"
                      style="border-top-left-radius: 2rem !important; border-top-right-radius: 2rem !important; ">
                      <h4 class="fw-bold">';
                        echo $plan->nombre;
                        echo '</h4>';
                    echo '</div>
                    <div class="card-body">
                      <p class="m-0 text-center BwSurcoDemo-Regular">Hasta';
                      echo $plan->num_dispositivos;
                      echo ' dispositivos</p>
                      <p class="m-0 text-center color-secundario montserrat-extrabold fs-2"> Pregúntanos</p>
                      <p class="m-0 text-center BwSurcoDemo-Regular">Estrato';
                      echo $plan->estrato; 
                      echo '</p>
                      <p class="m-0 text-center BwSurcoDemo-Regular"> Instalación en 24 horas</p>
                      <a href="http://wa.me/'.get_option('wisprointegration_whatsapp_number').'" target="_blank"
                        class="btn color-terciario-bg mb-2 BwSurcoDemo-Regular w-75 mx-auto d-block"><svg xmlns="http://www.w3.org/2000/svg"
                          width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                          <path fill-rule="evenodd"
                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z">
                          </path>
                        </svg> Te llamamos</a>
                      <a href="?paso=2&plan='.$plan->id.'" class="btn color-primario-bg text-white mb-2 BwSurcoDemo-Regular w-75 mx-auto d-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-cart-fill text-white" viewBox="0 0 16 16">
                          <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
                          </path>
                        </svg> Comprar </a>
                      <p class="text-center BwSurcoDemo-Regular">
                        <small class="text-muted"><a rel="nofollow" href="javascript:modal_post('.$plan->post_id.')" data-bs-toggle="modal"
                            data-bs-target="#modal25megas">Más especificaciones</a></small>
                      </p>
                    </div>
                  </div>
                </div>';
            }
          ?>
          
          <div class="col" >
            <div class="card br-2">
              <div class="card-header text-center fw-bold color-primario-bg color-title"
                style="border-top-left-radius: 2rem !important; border-top-right-radius: 2rem !important; ">
                <h3>Planes Empresariales</h3>
              </div>
              <div class="card-body">
                <p class="p-0 text-center BwSurcoDemo-Regular  fs-4"> Mega dedicada<br> + IP
                  Pública </p>
                <p class="p-0 text-center BwSurcoDemo-Regular  fs-4"> Desde 10MB </p>
                <a href="http://wa.me/number" target="_blank"
                  class="btn color-terciario-bg mb-2 BwSurcoDemo-Regular w-75 mx-auto d-block"><svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                      d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z">
                     </path>
                  </svg> Pregùntanos</a>
              </div>
            </div>
          </div>
        </div>
        <!-- END: COLUMNAS DE PLANES -->
      </div>
      <p>
        <a class="btn color-primario-bg rounded-pill text-white" class="text-white" href="javascript:collapse_sorteo();">
          A tener en cuenta:
        </a>
      </p>
      <div class="collapse" id="collapseExample">
        <ul class="BwSurcoDemo-Regular text-white">
          <li class="BwSurcoDemo-Regular">La conexión de tu servicio se programará inmediatamente que se compruebe tu pago.</li>
          <li class="BwSurcoDemo-Regular">En caso de realizar el pago en corresponsales bancarias, por favor tomar foto al recibo y compartirlo al whatsapp 3137224211 o al correo contabilidad@elkinet.co y escribir el nombre de la persona que tiene el contrato.</li>
          <li class="BwSurcoDemo-Regular">Todas las dudas serán atendidas en los canales que tenemos dispuestos para tí</li>
          <li class="BwSurcoDemo-Regular">Para confirmar tu cobertura, puedes dejar tus datos para que uno de nuestros asesores te llame y resuelva tu consulta</li>
        </ul>
      </div>
      <!-- BEGIND: MODAL MAS especificaciones -->
      <div class="modal fade" id="modaldetalles" tabindex="-1" aria-labelledby="modal50megaslabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal-title-post" id="modal50megaslabel">50 Megas</h5>
                    <button type="button" class="btn-close btn-close-modaldetalles" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    
                </div>
            </div>
        </div>
      </div>
      <!-- END: modal mas especificaciones -->
    </div>

    <div class="tab-pane fade <?php echo (isset($_GET['paso']) && $_GET['paso'] == '2' ) ? 'show active' : ''; ?> container-fluid" id="ex1-pills-2" role="tabpanel" aria-labelledby="ex1-tab-2">
      <p class="has-text-align-center color-terciario mx-3 fs-2 montserrat-extrabold">Detalles de la compra</p>
      <?php
        if(isset($_GET['plan']) && isset($_GET['paso'])){
          global $wpdb;
          $plan = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->prefix" . "wispro_integration_planes WHERE id = %d", $_GET['plan']));
          $costo_instalacion = get_option('wisprointegration_costo_instalacion');
          $precio_plan = $plan->precio;
          $total = $precio_plan + $costo_instalacion;
          ?>
        <div class="w-75 mx-auto">
          <table class="table table-bordered my-3 text-center br-2 mb-3 fs-3">
            <tbody class="bg-light color-text BwSurcoDemo-Regular">
                <tr>
                  <td  class="align-middle"><p id="text-paquete">Servicio de conexión a internet <?php echo number_format($precio_plan, 0, '.', ',');?></p></td>
                  <td  class="align-middle">$<p class="d-inline" id="value-paquete"><?php echo number_format($precio_plan, 0, '.', ','); ?></p></td>
                </tr>
                <tr>
                  <td class="align-middle">Instalación</td>
                  <td  class="align-middle">$<p class="d-inline" id="value-instalacion"><?php echo number_format($costo_instalacion, 0, '.', ','); ?></p></td>
                </tr>
                <tr>
                  <td></td>
                  <td class="align-middle montserrat-extrabold">Total: $<p id="value-instalacion d-inline"><?php echo number_format($total, 0, '.', ','); ?></p></td>
                </tr>
            </tbody>
          </table>
          <form action="" method="post" id="frm-compra">
            <div class="br-2 bg-light mt-5">
              <!-- formulario de datos del cliente -->
              <input type="hidden" name="plan" value="<?php echo $_GET['plan']; ?>">  
              <input type="hidden" name="form_compra">
              <input class="form-control" type="text" name="name" placeholder="Nombre Completo">  
              <div class="row">
                <div class="col-md-6">
                  <select class="form-control" name="identification_type">
                    <option value="">Tipo de documento</option>
                    <option value="CC">Cédula de Ciudadanía</option>
                    <option value="TI">Tarjeta de Identidad</option>
                    <option value="CE">Cédula de Extranjería</option>
                    <option value="PAS">Pasaporte</option>
                  </select>
                </div>  
                <div class="col-md-6">
                  <input class="form-control" type="number" name="national_identification_number" placeholder="Identificación">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <input class="form-control" type="email" name="email" placeholder="Email">  
                </div>
                <div class="col-md-6">
                  <input class="form-control" type="phone" name="phone_mobile" placeholder="Numero de celular">  
                </div>
              </div>
              <input class="form-control" type="text" name="address" placeholder="Dirección">  
              <select class="form-control" id="ciudad" name="city">
                <option value="">Seleccione una cuidad</option>
                <option value="Miranda">Miranda</option>
                <option value="Padilla">Padilla</option>
                <option value="Florida">Florida</option>
              </select>            
             </div>
            <div class="my-5">
              <?php echo  $message;?>
            </div>
            <div class="my-5 has-text-align-center">
              <button class="btn btn-block color-terciario-bg br-2 p-3" type="submit">Comprar</button>
            </div>
          </form>
        </div> <?php }else{
        //get page url
        echo "<script> 
        jQuery(document).ready(function($){
          $('#ex1-pills-1').addClass('active show');
          $('#ex1-pills-2').removeClass('active show');
          $('#ex1-pills-3').removeClass('active show');
        });
        </script>
        ";
      } ?>
      <div class="row pb-4 px-2 fs-5">
        <div class="col-3 d-inline text-white BwSurcoDemo-Regular ">¿Necesitas ayuda? <br> Siempre estamos para tí</div>
        <div class="col align-middle d-inline">
          <button class="btn btn-block color-terciario-bg br-2 p-3" type="submit">Chatear con un asesor en vivo</button>
        </div>
      </div>
    </div>

    <div class="tab-pane fade <?php echo (isset($_GET['paso']) && $_GET['paso'] == '3' ) ? 'show active' : ''; ?> container-fluid" id="ex1-pills-3" role="tabpanel" aria-labelledby="ex1-tab-3">
      <div class="text-center text-white my-5 py-5">
        <h2 class="has-text-align-center text-white mx-3">¡Gracias por tu compra!</h2>
        <p class="fs-3 BwSurcoDemo-Regular">Uno de nuestros asesores se comunicara contigo en la mayor brevedad</p>
        <p class="fs-3 BwSurcoDemo-Regular">Gracias por preferirnos</p>
      </div>
      <p class="fs-4 BwSurcoDemo-Regular">*Recuerda inscribirte para ganarpremios al pagar tu factura</p>
    </div>
  </div>
  <!-- Pills content -->
</div>
<!-- seleccionar un paquete -->

<!-- scripts -->
<script type='text/javascript'>
  function modal_post(id){
    jQuery(document).ready(function($){
      //obtener contenido del post por api wordpress
      //get domain from site
      $.ajax({
        url: '<?php echo get_site_url(); ?>/wp-json/wp/v2/posts/'+id,
        type: 'GET',
        data: {
          id: id
        },
        success: function(data){
          $('#modaldetalles').modal('show');
          $('#modaldetalles .modal-title').html(data.title.rendered);
          $('#modaldetalles .modal-body').html(data.content.rendered);
        }
      });
    });
  }
</script>
<script type='text/javascript'>
  jQuery(document).ready(function($){
    $('.btn-close-modaldetalles').click(function(){
      $('#modaldetalles').modal('hide');
    });
  });
</script>

<script  type='text/javascript'>
  function collapse_sorteo() {
    var x = document.getElementById("collapseExample");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }
  //funcion seleccion de paquete
  function seleccionar_paquete(paquete){
    jQuery(document).ready(function ($) {
      $('#value-paquete').html('precio');
      $('#value-instalacion').html('instalacion');
      $('#ex1-pills-2').addClass('active show');
      $('#ex1-pills-1').removeClass('active show');
      $('#ex1-pills-3').removeClass('active show');
    });
  }

//funcion realizar compra
  function realizar_compra() {
    var paquete_seleccionado = document.getElementById("paquete_seleccionado");
    var paquete = paquete_seleccionado.value;
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    var email = document.getElementById("email").value;
    var telefono = document.getElementById("telefono").value;
    var direccion = document.getElementById("direccion").value;
    var ciudad = document.getElementById("ciudad").value;
    var estado = document.getElementById("estado").value;
    var codigo_postal = document.getElementById("codigo_postal").value;
    var pais = document.getElementById("pais").value;
    var metodo_pago = document.getElementById("metodo_pago").value;
    var card_name = document.getElementById("card_name").value;
    var card_number = document.getElementById("card_number").value;
    var card_expiration_date = document.getElementById("card_expiration_date").value;
    var card_cvv = document.getElementById("card_cvv").value;
    var remember_card = document.getElementById("remember_card").value;
    var automatic_payment = document.getElementById("automatic_payment").value;

    if (paquete == "") {
      alert("Selecciona un paquete");
    } else if (nombre == "") {
      alert("Ingresa tu nombre");
    } else if (apellido == "") {
      alert("Ingresa tu apellido");
    } else if (email == "") {
      alert("Ingresa tu email");
    } else if (telefono == "") {
      alert("Ingresa tu telefono");
    } else if (direccion == "") {
      alert("Ingresa tu direccion");
    } else if (ciudad == "") {
      alert("Ingresa tu ciudad");
    } else if (estado == "") {
      alert("Ingresa tu estado");
    } else if (codigo_postal == "") {
      alert("Ingresa tu codigo postal");
    } else if (pais == "") {
      alert("Ingresa tu pais");
    } else if (metodo_pago == "") {
      alert("Selecciona un metodo de pago");
    } else if (card_name == "") {
      alert("Ingresa el nombre de la tarjeta");
    } else if (card_number == "") {
      alert("Ingresa el numero de la tarjeta");
    } else if (card_expiration_date == "") {
      alert("Ingresa la fecha de expiracion de la tarjeta");
    } else if (card_cvv == "") {
      alert("Ingresa el cvv de la tarjeta");
    } else if (remember_card == "") {
      alert("Selecciona si quieres recordar tu tarjeta");
    } else if (automatic_payment == "") {
      alert("Selecciona si quieres pagar tu factura automaticamente");
    } else {
      jQuery(document).ready(function ($) {
        $('#ex1-tab-3').click(function () {
          $('#ex1-pills-3').addClass('active show');
          $('#ex1-pills-1').removeClass('active show');
          $('#ex1-pills-2').removeClass('active show');
        });
      });
    }
  }
</script>