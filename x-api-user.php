<?php
/**
 * @file x-api-user.php
 * @desc User class
 */
/**
 * Includes.
 */
require_once ABSPATH . '/wp-includes/pluggable.php';
require_once ABSPATH . '/wp-includes/user.php';
require_once ABSPATH . '/wp-admin/includes/user.php';

/**
 * Class WP_INCLUDE_USER
 */
class XUser extends WP_User {
    public function __construct( $id = 0, $name = '', $blog_id = '' )
    {
        parent::__construct($id, $name, $blog_id);
    }

    public function login() {
        $user = wp_authenticate( $_REQUEST['user_login'], $_REQUEST['user_pass']);
        if ( is_wp_error( $user ) ) {
            $user = get_user_by('login', $_REQUEST['user_login']);
            if ( $user ) {
                wp_send_json_error("Wrong Password. Password is incorrect - $_REQUEST[user_pass]");
            }
            else {
                wp_send_json_error("Wrong User ID. There is no user by - $_REQUEST[user_login]");
            }
        }
        else {

        }
        wp_set_current_user( $user->ID );

        wp_send_json_success( $this->get_session_id( $user ) );

    }

    public function get_session_id( WP_User $user ) {
        $userdata = $user->to_array();
        if ( ! isset( $userdata['ID'] ) ) wp_send_json_error("User data has no ID");
        $reg = $userdata['user_registered'];
        $reg = str_replace(' ', '', $reg);
        $reg = str_replace('-', '', $reg);
        $reg = str_replace(':', '', $reg);
        $uid = $userdata['ID'] . $userdata['user_login'] . $userdata['user_email'] . $userdata['user_pass'] . $reg;
        $uid = $userdata['ID'] . '_' . md5( $uid );
        return $uid;
    }

    public function authenticate() {
        $session_id = $_REQUEST['session_id'];

        list( $ID, $trash ) = explode('_', $session_id);

        $user = get_userdata( $ID );
        if ( $user ) {
            if ( $session_id == $this->get_session_id( $user ) ) {
                wp_set_current_user( $ID );
            }
            else {
                wp_send_json_error('Session ID is invalid. Session ID is incorrect.');
            }
        }
        else {
            wp_send_json_error('Session ID is invalid. No user by that session ID.');
        }
    }


}
