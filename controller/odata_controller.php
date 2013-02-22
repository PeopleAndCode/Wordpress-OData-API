<?php

Class OData_Controller {

	public static function template_redirect(){
		global $odata_dir;
		if ( $overridden_template = locate_template( 'odata/templates/defaults/odata.svc.php' ) ) {
			load_template( $overridden_template );
			exit();
		} else {
			include($odata_dir . '/' .'templates' . '/' . 'defaults' . '/' . 'odata.svc.php');
			exit();
		}
	}
}

?>