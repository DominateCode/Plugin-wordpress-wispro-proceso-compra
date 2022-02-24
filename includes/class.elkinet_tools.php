<?php

class elkinet_tools {

    //funcion para comprobar requisitos del plugin
    public function check(){
        //comprobar option elkinet_tools_api_token
        if(!get_option('elkinet_tools_api_token')){
            return false;
        }
        //comprobar option elkinet_tools_api_url
        if(!get_option('elkinet_tools_api_url')){
            return false;
        }
        return true;
    }
}