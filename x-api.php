<?php
/**
 *
 */
require_once dirname( __FILE__ ) . '/x-api-user.php';
require_once dirname( __FILE__ ) . '/x-api-post.php';

list ( $class, $method ) = explode( '.', $_REQUEST['xapi'] );
if ( $class == 'user' ) {
    $user = new XUser();
    $user->$method();
}