<?php


/**
 * Returns first error message from WP_Error array.
 * @param $error
 * @return string|void
 */
function xapi_get_error_message( $error ) {
    if ( ! is_wp_error($error) ) return null;
    list ( $k, $v ) = each ($error->errors);
    return "$k : $v[0]";
}
function xerror( $thing ) {
    return xapi_get_error_message( $thing );
}

function xapi_get_query_vars() {
    return ['xapi', 'session_id'];
}
function xapi_post_query_vars() {
    return ['xapi', 'session_id', 'category', 'title', 'content'];
}




function isValidJSON($str) {
    json_decode($str);
    return json_last_error() == JSON_ERROR_NONE;
}


function xapi_get_json_post() {
    $json_params = file_get_contents( "php://input" );
    if ( strlen($json_params) > 0 ) {
        $dec = json_decode( $json_params, true );
        if ( json_last_error() == JSON_ERROR_NONE ) {
            return $dec;
        }
    }
    return null;
}


if ( ! function_exists('in') ) {
    /**
     *
     * @note By default it returns null if the key does not exist.
     *
     * @param $name
     * @param null $default
     * @return null
     *
     */
    function in( $name, $default = null ) {
        if ( isset( $_REQUEST[$name] ) ) return $_REQUEST[$name];
        else return $default;
    }
}