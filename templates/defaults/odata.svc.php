<?php
	header('Content-Type: application/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\r";
?>
<service xmlns:atom="http://www.w3.org/2005/Atom" xmlns:app="http://www.w3.org/2007/app" xmlns="http://www.w3.org/2007/app" xml:base="<?php echo $odata_api_url_base; ?>">
	<workspace>
		<atom:title>Default</atom:title>
	<?php 
		$args = array('public' => true);
		$post_types=get_post_types($args,'names'); 
		foreach ($post_types as $post_type ):
	?>
		<collection href="<?php echo ucfirst($post_type); ?>">
			<atom:title><?php echo ucfirst($post_type); ?></atom:title>
		</collection>
	<?php
		endforeach;
	?>
	</workspace>
</service>
