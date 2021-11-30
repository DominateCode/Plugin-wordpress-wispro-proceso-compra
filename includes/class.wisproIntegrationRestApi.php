<?php

class wisproIntegrationRestApi {
    
    private $api_url = 'https://www.cloud.wispro.co/api/v1/';
    private $api_key = '';
    private $api_secret = '';
    private $api_token = '';
   
    //public function __construct($api_key, $api_secret) {
    public function __construct() {
        //$this->api_key = $api_key;
        //$this->api_secret = $api_secret;
        $this->api_url = $this->get_api_url();
        $this->api_token = $this->getToken();
    }

    public function get_api_url() {
        $this->api_token = get_option('wisprointegration_api_url');
        return $this->api_token;
    }

    public function getToken() {
        $this->api_token = get_option('wisprointegration_api_token');
        //if(empty($this->api_token)) {
          //  $this->api_token = $this->getNewToken();
        //}
        return $this->api_token;
    }

    public function getClients() {
        $url = $this->api_url . 'clients';
        $args = array(
            'headers' => array(
                'Authorization' => $this->api_token,
                'Content-Type' => 'application/json'
            )
        );
        $response = wp_remote_get($url, $args);
        $response_body = json_decode($response['body']);
        return $response_body;
    }

    public function getPlans() {
        $url = $this->api_url . 'plans';
        $args = array(
            'headers' => array(
                'Authorization' => $this->api_token,
                'Content-Type' => 'application/json'
            )
        );
        $response = wp_remote_get($url, $args);
        $response_body = json_decode($response['body']);
        return $response_body;
    }

    public function getClient($client_id) {
        $url = $this->api_url . 'clients/' . $client_id;
        $args = array(
            'headers' => array(
                'Authorization' =>  $this->api_token,
                'Content-Type' => 'application/json'
            )
        );
        $response = wp_remote_get($url, $args);
        $response_body = json_decode($response['body']);
        return $response_body;
    }

    public function getPlan($plan_id) {
        $url = $this->api_url . 'plans/' . $plan_id;
        $args = array(
            'headers' => array(
                'Authorization' =>  $this->api_token,
                'Content-Type' => 'application/json'
            )
        );
        $response = wp_remote_get($url, $args);
        $response_body = json_decode($response['body']);
        return $response_body;
    }

    public function createClient($client_data) {
        $url = $this->api_url . 'clients';
        $args = array(
            'headers' => array(
                'Authorization' =>  $this->api_token,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode($client_data)
        );
        $response = wp_remote_post($url, $args);
        $response_body = json_decode($response['body']);
        return $response_body;
    }

    public function createpayment($payment_data) {
        $url = $this->api_url . '/invoicing/payments';
        $args = array(
            'headers' => array(
                'Authorization' =>  $this->api_token,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode($payment_data)
        );
        $response = wp_remote_post($url, $args);
        $response_body = json_decode($response['body']);
        return $response_body;
    }
    //clients_payment_gateways
    public function getPaymentGateways() {
        $url = $this->api_url . 'clients/payment-gateways';
        $args = array(
            'headers' => array(
                'Authorization' =>  $this->api_token,
                'Content-Type' => 'application/json'
            )
        );
        $response = wp_remote_get($url, $args);
        $response_body = json_decode($response['body']);
        return $response_body;
    }
    //obtener todos los pagos
    public function getPayments() {
        $url = $this->api_url . 'invoicing/payments';
        $args = array(
            'headers' => array(
                'Authorization' =>  $this->api_token,
                'Content-Type' => 'application/json'
            )
        );
        $response = wp_remote_get($url, $args);
        $response_body = json_decode($response['body']);
        return $response_body;
    }
}