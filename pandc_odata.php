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
	global $pc_odata_api, $wp_rewrite;
	if (phpversion() < 5) {
		add_action('admin_notices', 'pc_odata_api_php_version_warning');
		return;
	}
	add_filter('rewrite_rules_array', 'pc_odata_api_rewrites');
	$wp_rewrite->flush_rules();
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
	"OData/([^/]+)/?" => 'index.php?odata=$matches[1]'
	);
	return array_merge($odata_api_rules, $wp_rules);
	
}

function my_insert_query_vars( $vars ) {
    $vars[] = 'odata';
    return $vars;
}
add_filter( 'query_vars','my_insert_query_vars' );

function pandc_odata_template_redirect() {
	$odata_query = get_query_var('odata');
	if ($odata_query == 'OData.svc') {
		if ( $overridden_template = locate_template( 'page-OData.php' ) ) {
			// locate_template() returns path to file
			// if either the child theme or the parent theme have overridden the template
			load_template( $overridden_template );
		} else {
			// if this is not a request for odata or a singular object then bail
			// include custom template
			include($dir . 'templates/odata-template.php');
			exit();
		}
	}
}
add_action( 'template_redirect', 'pandc_odata_template_redirect' );

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

function plugin_myown_content() {
  $return = '<p>OData Page Plugin</p>';
  return $return;
}

function plugin_myown_title() {
  return "On the fly foobar form";
}

// if ($_GET['odata'] == "OData.svc") {
//   add_filter('the_title', 'plugin_myown_title');
//   add_filter('the_content', 'plugin_myown_content');
//   add_action('template_redirect', 'pandc_odata_template_redirect');
// }

?>