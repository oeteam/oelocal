<?php

function redirect_ssl() {
    $CI =& get_instance();

    // Maintainance page start
    // if (count(explode('http://otelseasy.com', current_url()))==2) {
    //     $CI->load->view('index1');
    // }
    // Maintainance page end

    $class = $CI->router->fetch_class();
    $exclude =  array('client');  // add more controller name to exclude ssl.
    if(!in_array($class,$exclude)) {
        // redirecting to ssl.
        $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
            
        $url = explode("www", $_SERVER['HTTP_HOST']);
        if (count($url)==2) {
            redirect(base_url().$CI->uri->uri_string());
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            if ($_SERVER['HTTP_X_FORWARDED_PROTO']=='http') {
                redirect(base_url().$CI->uri->uri_string());
            }
        } else {
            redirect(base_url().$CI->uri->uri_string());
        }
        if ($_SERVER['SERVER_PORT'] != 80) redirect($CI->uri->uri_string());
    } else {
        // redirecting with no ssl.
        $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
        print_r($CI->uri->uri_string());
        if ($_SERVER['SERVER_PORT'] == 443) redirect($CI->uri->uri_string());
    }
}

