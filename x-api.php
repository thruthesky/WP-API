<?php
/**
 *
 */

header('Access-Control-Allow-Origin: *');

require_once dirname( __FILE__ ) . '/x-api-function.php';
require_once dirname( __FILE__ ) . '/x-api-user.php';
require_once dirname( __FILE__ ) . '/x-api-post.php';
require_once dirname( __FILE__ ) . '/x-api-comment.php';

$user = new XUser();

if ( isset( $_REQUEST['session_id'] ) ) {
    $user->authenticate();
}
if ( isset( $_REQUEST['xapi'] ) ) {
    $xapi = $_REQUEST['xapi'];

    $segments = explode( '.', $_REQUEST['xapi'] );
    if ( count($segments) != 2 ) wp_send_json_error('Wrong xapi code');
    list ( $class, $method ) = $segments;
    if ( $class == 'user' ) {
        $user->$method();
    }
    else if ( $class == "post" ) {
        $post = new XPost();
        $post->$method();
    }
}
