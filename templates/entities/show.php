<?php
	header('Content-Type: application/xml');
	echo '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>';
?>
<entry xml:base="http://<?php bloginfo('url'); ?>/OData/OData.svc/" xmlns:d="http://schemas.microsoft.com/ado/2007/08/dataservices" xmlns:m="http://schemas.microsoft.com/ado/2007/08/dataservices/metadata" xmlns="http://www.w3.org/2005/Atom">

<?php
	while(have_posts()): the_post();
?>
	<id><?php echo $odata_api_url_base . $entitySet . "($id)/"; ?></id>
	<title type="text"><?php the_title(); ?></title>
	<link rel="self" title="<?php echo $entitySet; ?>" href="<?php echo "$entitySet($id)/"; ?>" />
	<?php 
		foreach((get_the_category()) as $category) { 
	?>
	<category term="OData.<?php echo $category->cat_name; ?>" scheme="http://schemas.microsoft.com/ado/2007/08/dataservices/scheme" />
	<?php
		}
	?>
	<content type="application/xml"> 
		<m:properties> 
			<d:ID m:type="Edm.Int32"><?php the_ID(); ?></d:ID>
			<d:PublishDate m:type="Edm.DateTime"><?php echo get_the_time('Y-m-s\TH:m:s'); ?></d:PublishDate>

		</m:properties> 
	</content>

<?php
	endwhile;
?>
</entry>
