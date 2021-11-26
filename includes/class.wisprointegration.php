<?php

class wisprointegration {

    //funcion para comprobar requisitos del plugin
    public function check(){
        //comprobar option wisprointegration_api_token
        if(!get_option('wisprointegration_api_token')){
            return false;
        }
        //comprobar option wisprointegration_api_url
        if(!get_option('wisprointegration_api_url')){
            return false;
        }
        //comprobar option wisprointegration_pagina_proceso_compras
        if(!get_option('wisprointegration_pagina_proceso_compras')){
            return false;
        }

        //comrpobar option wisprointegration_whatsapp_number
        if(!get_option('wisprointegration_whatsapp_number')){
            return false;
        }
        return true;
    }
}