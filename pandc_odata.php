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

function pc_odata_api_php_version_warning(){
	echo "<div id='odata-api-warning' class='updated fade'><p>Sorry, odata API requires PHP version 5.0 or greater.</p></div>";
}

function pc_odata_api_activation() {
  // Add the rewrite rule on activation
  global $wp_rewrite;
  add_filter('rewrite_rules_array', 'pc_odata_api_rewrites');
  $wp_rewrite->flush_rules();
}

function pc_odata_api_deactivation() {
  // Remove the rewrite rule on deactivation
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}

function pc_odata_api_rewrites($wp_rules) {
  $base = get_option('pc_odata_api_base', 'api');
  if (empty($base)) {
    return $wp_rules;
  }
  $pc_odata_api_rules = array(
    "$base\$" => 'index.php?odata=info',
    "$base/(.+)\$" => 'index.php?odata=$matches[1]'
  );
  return array_merge($pc_odata_api_rules, $wp_rules);
}

function pc_odata_api_dir() {
  if (defined('PC_ODATA_API_DIR') && file_exists(PC_ODATA_API_DIR)) {
    return PC_ODATA_API_DIR;
  } else {
    return dirname(__FILE__);
  }
}

add_action('init', 'pc_odata_api_init');
register_activation_hook("$dir/odata-api.php", 'pc_odata_api_activation');
register_deactivation_hook("$dir/odata-api.php", 'pc_odata_api_deactivation');

?>