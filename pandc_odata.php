<?php
/*
Plugin Name: oData API
Plugin URI: http://peopleandcode.com/oData
Description: Currently (v.0.1.0) a read only OData API for WordPress
Version: 0.1.0
Author: Raymond Kao
Author URI: http://peopleandcode.com
*/

global $odata_dir;
global $odata_api_url_base;
$odata_api_url_base = 'http://' . get_bloginfo('url') . '/OData/OData.svc/';
$odata_dir = pc_odata_api_dir();

include_once($odata_dir . '/' . 'controller'. '/' . 'entities_controller.php');
include_once($odata_dir . '/' . 'controller'. '/' . 'entitysets_controller.php');
include_once($odata_dir . '/' . 'controller'. '/' . 'odata_controller.php');
include_once($odata_dir . '/' . 'route.php');

function pc_odata_api_init() {
	global $pc_odata_api, $wp_rewrite;
	if (phpversion() < 5) {
		add_action('admin_notices', 'pc_odata_api_php_version_warning');
		return;
	}
	add_filter('rewrite_rules_array', 'pc_odata_api_rewrites');
	$wp_rewrite->flush_rules();
	$odata_api = new Route();	
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

function pc_odata_api_rewrites($wp_rules) {
	$odata_api_rules = array(
	"OData/([^/]*)/([^/]*)\(([0-9]*)\)/?$" => 'index.php?odata=$matches[1]&entitySet=$matches[2]&entityID=$matches[3]',
	"OData/([^/]*)/([^/]*)/?$" => 'index.php?odata=$matches[1]&entitySet=$matches[2]',
	"OData/([^/]*)/?$" => 'index.php?odata=$matches[1]'
	);
	return array_merge($odata_api_rules, $wp_rules);
}

function my_insert_query_vars( $vars ) {
	$vars[] = 'odata';
	$vars[] = 'entitySet';
	$vars[] = 'entityID';
	return $vars;
}
add_filter( 'query_vars','my_insert_query_vars' );

function pandc_odata_endpoints_activate() {
	global $wp_rewrite;
	add_filter('rewrite_rules_array', 'pc_odata_api_rewrites');
	$wp_rewrite->flush_rules();
}
register_activation_hook( __FILE__, 'pandc_odata_endpoints_activate' );

function pandc_odata_endpoints_deactivate() {
	remove_filter('rewrite_rules_array', 'pc_odata_api_rewrites');
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'pandc_odata_endpoints_deactivate' );

?>