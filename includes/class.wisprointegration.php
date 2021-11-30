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
        return true;
    }
}