<?php defined('ABSPATH') or die("adios adios");

//crear cliente en wispro
add_action( 'admin_post_wisprointegration_create_client', 'wisprointegration_create_client' );
add_action( 'admin_post_nopriv_wisprointegration_create_client', 'wisprointegration_create_client' );

add_action( 'admin_post_wisprointegration_create_contract', 'wisprointegration_create_contract' );
add_action( 'admin_post_nopriv_wisprointegration_create_contract', 'wisprointegration_create_contract' );


//funciones de wisprointegration

function wisprointegration_create_client(){
        
        //obtener datos del formulario
        $client_name = $_POST['name'];
        $client_email = $_POST['email'];
        $client_phone = $_POST['phone'];
        $client_address = $_POST['address'];
        $client_city = $_POST['city'];
        $client_state = $_POST['state'];
        $client_plan = $_POST['plan'];

        //crear cliente en wispro
        $wispro_api = new wisprointegrationRestApi();

        $client_response = $wispro_api->createclient([
            'name' => $client_name,
            'email' => $client_email, 
            'phone' => $client_phone, 
            'phone_mobile' => $client_phone,
            'address' => $client_address, 
            'city' => $client_city, 
            'state' => $client_state, 
        ]);

        //IMPRIMIR POR CONSOLA
        echo '<script type="text/javascript">console.log('.json_encode($client_response).');</script>';

        if($client_response->status == 200){
            $client_data = $client_response->data;

            //crear pago
            $payment_response = $wispro_api->createpayment([
                'client_id' => $client_data->id,
                'plan_id' => $client_plan,
                'payment_method' => 'credit_card',
                'payment_type' => 'installment',
                'payment_amount' => '100',
                'payment_currency' => 'MXN',
                'payment_installments' => '1',
                'payment_description' => 'Pago de prueba',
                'payment_reference' => 'Pago de prueba',
                'payment_date' => date('Y-m-d'),
                'payment_time' => date('H:i:s'),
                'payment_status' => 'paid',
                'payment_method_id' => '1',
                'payment_method_name' => 'Tarjeta de crédito',
                'payment_method_type' => 'credit_card',
                'payment_method_brand' => 'Visa',
                'payment_method_last4' => '1111',
                'payment_method_expiration_month' => '12',
                'payment_method_expiration_year' => '2020',
                'payment_method_holder_name' => 'Juan Perez',
                'payment_method_holder_identification' => '123456789',
                'payment_method_holder_identification_type' => 'CC',
                'payment_method_holder_identification_country' => 'MX',
                'payment_method_holder_identification_state' => 'DF',
                'payment_method_holder_identification_city' => 'Ciudad de México',
                'payment_method_holder_identification_address' => 'Calle de prueba',
                'payment_method_holder_identification_zip' => '12345',
                'payment_method_holder_identification_phone' => '123456789',

            ]);

            //IMPRIMIR POR CONSOLA
            echo '<script type="text/javascript">console.log('.json_encode($payment_response).');</script>';

            }else{
            echo '<script type="text/javascript">console.log(Cliente no creado.);</script>';
        }

        //redireccionar a la pagina de clientes
        //wp_redirect(admin_url('admin.php?page=wisprointegration/admin/clients.php'));
}

function wisprointegration_create_contract(){

}