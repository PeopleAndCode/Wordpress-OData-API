<?php
	header('Content-Type: application/xml');
	echo '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>';
?>
<feed xml:base="http://<?php echo $odata_api_url_base; ?>" xmlns:d="http://schemas.microsoft.com/ado/2007/08/dataservices" xmlns:m="http://schemas.microsoft.com/ado/2007/08/dataservices/metadata" xmlns="http://www.w3.org/2005/Atom">
<id><?php echo $odata_api_url_base . $entitySet; ?></id>
<title type="text"><?php echo $entitySet; ?></title>
<link rel="self" title="<?php echo $entitySet; ?>" href="<?php echo "$entitySet"; ?>" />
<?php
	while(have_posts()): the_post();
?>
<entry>
	<id><?php echo $odata_api_url_base . $entitySet . "(" . get_the_ID() .")/"; ?></id>
	<title type="text"><?php the_title(); ?></title>
	<updated><?php echo get_the_modified_time("Y-m-d\TH:m:s"); ?></updated>
	<link rel="self" title="<?php echo $entitySet; ?>" href="<?php echo "$entitySet(" . get_the_ID() . ")/"; ?>" />
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
			<d:PublishDate m:type="Edm.DateTime"><?php echo get_the_time('Y-m-d\TH:m:s'); ?></d:PublishDate>

		</m:properties> 
	</content>
</entry>
<?php
	endwhile;
?>
</feed>
