<?php
/**
 *
 */
require_once dirname( __FILE__ ) . '/x-api-function.php';
require_once dirname( __FILE__ ) . '/x-api-user.php';
require_once dirname( __FILE__ ) . '/x-api-post.php';
header('Access-Control-Allow-Origin: *');
list ( $class, $method ) = explode( '.', $_REQUEST['xapi'] );
if ( $class == 'user' ) {
    $user = new XUser();
    $user->$method();
}