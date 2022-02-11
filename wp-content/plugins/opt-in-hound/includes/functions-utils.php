<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Strips any script tags from the given value
 *
 * @param string $value
 *
 * @return string
 *
 */
function _oih_sanitize_textarea( $value = '' ) {

	$value = preg_replace( '@<(script)[^>]*?>.*?</\\1>@si', '', $value );	

	return $value;

}


/**
 * Sanitizes the values of an array recursivelly
 *
 * @param array $array
 *
 * @return array
 *
 */
function _oih_array_sanitize_text_field( $array = array() ) {

    if( empty( $array ) || ! is_array( $array ) )
        return array();

    foreach( $array as $key => $value ) {

        if( is_array( $value ) )
            $array[$key] = _oih_array_sanitize_text_field( $value );

        else
            $array[$key] = sanitize_text_field( $value );

    }

    return $array;

}


/**
 * Helper function to decode each element of an array from json to array
 *
 * @param array $arr
 *
 * @return array
 *
 */
function _oih_json_decode_array( $arr = array() ) {

	if( ! is_array( $arr ) )
		return $arr;

	foreach( $arr as $key => $value ) {

		if( ! is_array( $value ) ) {

			if( $decoded = json_decode( $value, true ) )
				$arr[$key] = _oih_json_decode_array( $decoded );

		} else {

            $arr[$key] = _oih_json_decode_array( $value );

        }

	}

	return $arr;

}


/**
 * Prefixes all keys of an array with the given prefix and returns the result
 *
 * @param array  $array
 * @param string $prefix
 *
 * @return array
 *
 */
function _oih_prefix_array_keys( $array = array(), $prefix = '' ) {

    if( empty( $array ) )
        return array();

    if( empty( $prefix ) )
        return $array;

    foreach( $array as $key => $value ) {

        $array[$prefix . $key] = $value;
        unset( $array[$key] );

    }

    return $array;

}


/**
 * Adds an associative array value, example array( 'key' => 'value' ) into an existing array
 * after the existing array's provided $key
 *
 * @param array  $array
 * @param string $key
 * @param array  $value
 *
 * @return array
 *
 */
function _oih_array_assoc_push_after_key( $array = array(), $key = '', $value ) {

    if( ! isset( $value ) )
        return $array;

    if( ( $offset = array_search( $key, array_keys( $array ) ) ) === false ) {

        $offset = count( $array );

    }
    
    $offset++;

    return array_merge( array_slice( $array, 0, $offset ), $value, array_slice( $array, $offset ) );

}


/**
 * Function that return the IP address of the user. Checks for IPs (in order) in: 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'
 *
 * @return string
 *
 */
function oih_get_user_ip_address() {

    $ip_address = '';

    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true) {
            foreach ( array_map('trim', explode( ',', $_SERVER[$key]) ) as $ip ) {
                if ( filter_var($ip, FILTER_VALIDATE_IP) !== false ) {
                    return $ip;
                }
            }
        }
    }

    return $ip_address;
    
}


/**
 * Returns the url of the current page
 *
 * @param bool $strip_query_args - whether to eliminate query arguments from the url or not
 *
 * @return string
 *
 */
function oih_get_current_page_url( $strip_query_args = false ) {

    $page_url = 'http';

    if ((isset($_SERVER["HTTPS"])) && ($_SERVER["HTTPS"] == "on"))
        $page_url .= "s";

    $page_url .= "://";

    if ($_SERVER["SERVER_PORT"] != "80")
        $page_url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    else
        $page_url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];


    // Remove query arguments
    if( $strip_query_args ) {
        $page_url_parts = explode( '?', $page_url );

        $page_url = $page_url_parts[0];

        // Keep query args "p" and "page_id" for non-beautified permalinks
        if( isset( $page_url_parts[1] ) ) {
            $page_url_query_args = explode( '&', $page_url_parts[1] );

            if( !empty( $page_url_query_args ) ) {
                foreach( $page_url_query_args as $key => $query_arg ) {

                    if( strpos( $query_arg, 'p=' ) === 0 ) {
                        $query_arg_parts = explode( '=', $query_arg );
                        $query_arg       = $query_arg_parts[0];
                        $query_arg_val   = $query_arg_parts[1];

                        $page_url = add_query_arg( array( $query_arg => $query_arg_val ), $page_url );
                    }

                    if( strpos( $query_arg, 'page_id=' ) === 0 ) {
                        $query_arg_parts = explode( '=', $query_arg );
                        $query_arg       = $query_arg_parts[0];
                        $query_arg_val   = $query_arg_parts[1];

                        $page_url = add_query_arg( array( $query_arg => $query_arg_val ), $page_url );
                    }

                }
            }
        }

    }

    return $page_url;

}


/**
 * Returns the datetime format saved in WordPress's options
 *
 * @return string
 *
 */
function oih_get_wp_datetime_format() {

    $date_format = get_option('date_format');
    $time_format = get_option('time_format');

    return $date_format . ' ' . $time_format;

}