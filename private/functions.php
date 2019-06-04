<?php

function url_for( $script_path ) {
    // add the leading '/' if not present
    if ( $script_path[ 0 ] != '/' ) {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
}

function u( $string = "" ) {
    return urlencode( $string );
}

function raw_u( $string = "" ) {
    return rawurlencode( $string );
}

function h( $string = "" ) {
    return htmlspecialchars( $string );
}

function error_404() {
    header( $_SERVER[ "SERVER_PROTOCOL" ] . " 404 Not Found" );
    exit();
}

function error_500() {
    header( $_SERVER[ "SERVER_PROTOCOL" ] . " 500 Internal Server Error" );
    exit();
}

function redirect_to( $location ) {
    header( "Location: " . $location );
    exit;
}

function is_post_request() {
    return $_SERVER[ 'REQUEST_METHOD' ] == 'POST';
}

function is_get_request() {
    return $_SERVER[ 'REQUEST_METHOD' ] == 'GET';
}

function display_errors( $errors = array() ) {
    $output = '';
    if ( !empty( $errors ) ) {
        $output .= "<div>";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ( $errors as $error ) {
            $output .= "<li>" . h( $error ) . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

function display_error( $error ) {

    echo "<div style=\"color: red;\" class=\"row\">";

    echo "<div class=\"col-25\">";
    echo "</div>";

    echo "<div class=\"col-75\">";
    echo h( $error );
    echo "</div>";


    echo "</div>";

}

function db_escape($connection, $string){
    return mysqli_real_escape_string($connection, $string);
}

function date_fmt($date){
    return date('m/d/Y', strtotime($date));
}

function date_fmt_lng($date){
    return date('l, m/d/Y', strtotime($date));
}