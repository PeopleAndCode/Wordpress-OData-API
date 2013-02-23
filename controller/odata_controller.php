<?php

Class OData_Controller {
	var $odataQuery;

	function __construct($odata){
		$this->odataQuery = $odata;
	}

	function show(){
		global $odata_dir;
		global $odata_api_url_base;

		$odataQuery = &$this->odataQuery;

		if ((isset($odataQuery)) && ($odataQuery == 'OData.svc')) {
			if ( $overridden_template = locate_template( 'odata/templates/defaults/odata.svc.php' ) ) {
				load_template( $overridden_template );
				exit();
			} else {
				include($odata_dir . '/' .'templates' . '/' . 'defaults' . '/' . 'odata.svc.php');
				exit();
			}
		} elseif(isset($odataQuery) && !empty($odataQuery) ) {
			echo "odata parameter is empty";
			exit();
		}
	}
}

?>