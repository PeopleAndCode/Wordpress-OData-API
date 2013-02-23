<?php

Class EntitySets_Controller {
	var $entitySet;

	function __construct($entitySetName){
		$this->entitySet = $entitySetName;
	}

	function show(){
		global $odata_dir;
		global $odata_api_url_base;
		$entitySet = &$this->entitySet;
		$post_type = strtolower($entitySet);

		if( $post_type == 'post' || $post_type == 'page') {
			// we don't want to accept URLs/Queries with Post||Page (singular) we want Posts||Pages
			$post_type = 'odataForcePostTypeError';
		} elseif ( $post_type == 'posts' ) {
			$post_type = 'post';
		} elseif ( $post_type == 'pages' ) {
			$post_type = 'page';
		}

		$args = array(
			'post_status' => 'publish',
			'post_type' => strtolower($post_type),
			'posts_per_page' => '-1',
			'order' => 'ASC'
		);

		$post_object = query_posts($args);

		if(have_posts()){
			if ( $overridden_template = locate_template( 'odata/templates/entitysets/show.php' ) ) {
				load_template( $overridden_template );

			} else {
				include($odata_dir . '/' .'templates' . '/' . 'entitysets' . '/' . 'show.php');

			}
			exit();

		} else {
			if ( $overridden_template = locate_template( 'odata/templates/defaults/odata_error_no_data_found/php' ) ) {
				load_template( $overridden_template );

			} else {
				include($odata_dir . '/' . 'templates' . '/' . 'defaults' . '/' . 'odata_error_no_data_found.php' );

			}
			exit();

		} // end have_posts()

	} // end function show()

} // end Class EntitySets_Controller

?>