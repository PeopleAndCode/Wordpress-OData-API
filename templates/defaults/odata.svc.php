<?php
	// header('Content-Type: application/xml');
?>


<?php
	$odata = get_query_var( 'odata' );
	$id = get_query_var('entitySet');
	$ray = get_query_var('entityID');

	echo "OData value = " . $odata . "<br/>";
	echo "Entiy Set value = " . $id . "<br/>";
	echo "Entity value = " . $ray . "<br/>";
	
	if(is_home()){
		if(have_posts()):
			echo the_permalink();
			while(have_posts()): the_post();
				echo the_title();
				echo the_content();
			endwhile;
		endif;
	}
?>
