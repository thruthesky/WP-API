<?php
/**
 *
 * @file x-api.php
 *
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers:Content-Type,Accept');

require_once dirname( __FILE__ ) . '/x-api-function.php';
require_once dirname( __FILE__ ) . '/x-api-user.php';
require_once dirname( __FILE__ ) . '/x-api-post.php';
require_once dirname( __FILE__ ) . '/x-api-comment.php';

$user = new XUser();
if ( $json = xapi_get_json_post() ) $_REQUEST = array_merge( $_REQUEST, $json );

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
