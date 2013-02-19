<?php
	// header('Content-Type: application/xml');
	$odata = get_query_var( 'OData' );
	$somethingelse = get_query_var( 'somethingelse' );

	echo $odata;
	echo '<br/>Hello</br>';
	echo $somethingelse;
?>
