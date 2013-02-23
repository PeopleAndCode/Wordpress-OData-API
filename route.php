<?php
Class Route {

	function __construct() {
		add_action( 'template_redirect', array($this, 'pandc_odata_template_redirect') );
	}

	function pandc_odata_template_redirect() {
		$odataQuery 		= get_query_var('odata');
		$entitySetName 	= get_query_var('entitySet');
		$entityID 			= get_query_var('entityID');

		if((isset($entityID)) && is_numeric($entityID)) {
			$entity = new Entities_Controller($entityID, $entitySetName);
			$entity->show();

		} elseif(isset($entitySetName) && !empty($entitySetName)) {
			$entitySet = new EntitySets_Controller($entitySetName);
			$entitySet->show();

		} else {
			$odata = new OData_Controller($odataQuery);
			$odata->show();
		}
	}

}
?>