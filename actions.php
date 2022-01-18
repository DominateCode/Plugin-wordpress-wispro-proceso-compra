<?php defined('ABSPATH') or die("adios adios");

add_action('wp_ajax_nopriv_wispro_integration_registrar_usuario', 'crear_cliente');
add_action('wp_ajax_wispro_integration_registrar_usuario', 'crear_cliente');

function wispro_api(){
    return new WisproIntegrationRestApi();
} 

function crear_cliente(){
    $data = [];
    $errors = [];
    if(empty($_POST['name'])){
        $errors['name'] = 'El nombre es requerido';
    }
    if(empty($_POST['national_identification_number'])){
        $errors['national_identification_number'] = 'El numero de cedula es requerido';
    }
    if(empty($_POST['email'])){
        $errors['email'] = 'El correo es requerido';
    }
    if(empty($_POST['phone_mobile'])){
        $errors['phone_mobile'] = 'El celular es requerido';
    }
    if(empty($_POST['address'])){
        $errors['address'] = 'La dirección es requerida';
    }
    if(empty($_POST['city'])){
        $errors['city'] = 'La ciudad es requerida';
    }

    if (!empty($errors)) {
        $data['status'] = 400;
        $data['errors'] = $errors;
    } else {
        $data['status'] = 200;
        $data['message'] = 'Success!';
    }
    $data_client = [
        'name' => $_POST['name'],
        'national_identification_number' => $_POST['national_identification_number'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'phone_number' => $_POST['phone_mobile'],
        'city' => $_POST['city'],
        'address' => $_POST['address'],
        'details' => 'Cliente registrado a traves de la pagina web',
    ];
    $data['data'] = $data_client;

    if (!empty($data_client)) {
        //comprobar por cedula si existe el cliente
        $client_exist = $this->wispro_api()->remote_GET('/clients',[
                'national_identification_number_eq' => $data_client['national_identification_number']
            ]);

        if(!empty($client_exist) && $client_exist->meta->pagination->total_records != 0){
            $this->respuesta['message'] = '<div class="alert alert-danger" role="alert">
            El cliente con el numero de documento '.$data_client['national_identification_number'].' ya se encuentra registrado.<br>
            Accede desde <a href="'.get_option('wisprointegration_url_portal_cliente').'">aqui</a> al portal de cliente.
            </div>';
            return false;
        }else{
            $data = $this->wispro_api()->remote_POST('/clients',$data_client);
            if($data->status == '200'){
                //crear cliente por rest api wispro 
                $this->respuesta['message'] = '<div class="alert alert-success" role="alert">Client added successfully </div>';
                return true;
            }
        }
        return true;
    }
    echo json_encode($data);
}