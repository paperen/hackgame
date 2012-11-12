<?php

if ( HG_Arsenal::is_Admin() ) HG_Arsenal::dheader('?ac=home');
//login
if ( isset( $_POST['login'] ) ) {
    $login_state = 0;
    $login_data = $_POST['login'];
    $name = isset( $login_data['name'] ) ? $login_data['name'] : '';
    $password = isset( $login_data['password'] ) ? $login_data['password'] : '';
    $auth = isset( $login_data['auth'] ) ? $login_data['auth'] : '';
    if ( empty( $auth ) ) {
        $login_state = -1;
    } else if( $_SESSION[HG_ADMINAUTHKEY] != strtoupper($auth) ) {
        $login_state = -2;
    } else if ( empty( $name ) ) {
        $login_state = -3;
    } else if( HG_ADMINACOUNT != $name ) {
        $login_state = -4;
    } else if( empty( $password ) ) {
        $login_state = -5;
    } else if( md5(HG_ADMINPWD) != md5($password) ) {
        $login_state = -6;
    } else {
        $login_state = 1;
        HG_Arsenal::set_adminsession( HG_ADMINVAL );
        HG_Arsenal::dheader('?ac=home');
    }
} else {
    $authcode = HG_Arsenal::create_adminauth();
    require( HM_ROOT . 'template/hman_login.tpl.php' );
}

?>
