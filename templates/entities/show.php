<?php
	header('Content-Type: application/xml');
	echo '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>';
	while(have_posts()): the_post();
?>
<entry xml:base="http://<?php bloginfo('url'); ?>/OData/OData.svc/" xmlns:d="http://schemas.microsoft.com/ado/2007/08/dataservices" xmlns:m="http://schemas.microsoft.com/ado/2007/08/dataservices/metadata" xmlns="http://www.w3.org/2005/Atom">

	<content type="application/xml"> 
		<m:properties> 
			<d:ID m:type="Edm.Int32"><?php echo get_the_ID(); ?></d:ID>
			<d:Name><?php echo the_title(); ?></d:Name> 
		</m:properties> 
	</content>
</entry>

<?php
	endwhile;
?>