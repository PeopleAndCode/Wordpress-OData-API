<?php
/*
Plugin Name: oData API
Plugin URI: http://peopleandcode.com/oData
Description: A RESTful oData API for WordPress
Version: 0.1.0
Author: Raymond Kao
Author URI: http://peopleandcode.com
*/

$dir = pc_odata_api_dir();

function pc_odata_api_init() {
	global $pc_odata_api;
	if (phpversion() < 5) {
		add_action('admin_notices', 'pc_odata_api_php_version_warning');
		return;
	}
}
add_action('init', 'pc_odata_api_init');

function pc_odata_api_dir() {
	if (defined('PC_ODATA_API_DIR') && file_exists(PC_ODATA_API_DIR)) {
		return PC_ODATA_API_DIR;
	} else {
		return dirname(__FILE__);
	}
}

function pc_odata_api_php_version_warning(){
	echo "<div id='odata-api-warning' class='updated fade'><p>Sorry, odata API requires PHP version 5.0 or greater.</p></div>";
}

// function pandc_odata_add_endpoint() {
// 	add_rewrite_endpoint( 'OData', EP_PERMALINK );
// }
// add_action( 'init', 'pandc_odata_add_endpoint' );

function wpa5413_init() {
    // Remember to flush the rules once manually after you added this code!
    add_rewrite_rule(
        '^OData/OData.svc',
        'index.php?pagename=$matches[1]',
        'top' );
}
add_action( 'init', 'wpa5413_init' );

function wpa5413_query_vars( $query_vars ) {
    $query_vars[] = 'OData';
    $query_vars[] = 'somethingelse';
    return $query_vars;
}
add_filter( 'query_vars', 'wpa5413_query_vars' );

function pandc_odata_template_redirect() {
    global $wp_query;
 
    // if this is not a request for odata or a singular object then bail
    if ( $wp_query->get('OData') ):
        
	    // include custom template
	    include $dir . 'templates/odata-template.php';
	    exit;
    endif;
}
add_action( 'template_redirect', 'pandc_odata_template_redirect' );

function pandc_odata_endpoints_activate() {
        // ensure our endpoint is added before flushing rewrite rules
        wpa5413_init();
        // flush rewrite rules - only do this on activation as anything more frequent is bad!
        flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'pandc_odata_endpoints_activate' );

function pandc_odata_endpoints_deactivate() {
        // flush rules on deactivate as well so they're not left hanging around uselessly
        flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'pandc_odata_endpoints_deactivate' );


?>