<?php ob_start(); ?>


<!-- ================================================================ -->
<!--                      METADATA DE L'IMAGE                         -->
<!-- ================================================================ -->

<?php $actual_link = "https://".$_SERVER['HTTP_HOST']; ?>

<!-- Ces Metadata seront placées dans le <head> -->
<!-- OpenGraph -->
<meta property="fb:admins" content="1234" />
<meta name="fb:app_id" content="966242223397117" />
<meta property="og:title" content="<?= $image->title ?>" />
<meta property="og:image" content="<?=$actual_link?>/MetaImage/public/img/<?= $image->fileName ?>" />
<meta property="og:description" content="<?= $image->description ?>" />
<meta property="og:image:secure_url" content="<?=$actual_link?>/MetaImage/public/img/<?= $image->fileName ?>" />
<meta property="og:image:type" content="image/jpeg" />
<meta property="og:image:width" content="<?= $image->width ?>" />
<meta property="og:image:height" content="<?= $image->height ?>" />


<!-- TwitterCard -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@MetaImage" />
<meta name="twitter:description" content="<?= $image->description ?>" />
<meta name="twitter:title" content="<?= $image->title ?>" />
<meta name="twitter:image:src" content="<?=$actual_link?>/MetaImage/public/img/<?= $image->fileName ?>" />
<meta name="twitter:url" content="<?= $actual_link.$_SERVER['REQUEST_URI'] ?>" />
<?php $metadata = ob_get_clean(); ?>


<!-- Ces Metadata seront placées dans le <body> -->
<!-- MetaData Image -->
<span itemtype="http://schema.org/Photograph" itemscope>
	<meta itemprop="image" content="<?=$actual_link?>/MetaImage/public/img/<?= $image->fileName ?>"/>
	<meta itemprop="url" content="<?= $image->source ?>"/>
	<meta itemprop="dateModified" content="<?= $image->modifyDate ?>"/>
	<meta itemprop="dateCreated" content="<?= $image->dateCreated ?>"/>
	<meta itemprop="about" content="<?= $image->title ?>"/>
	<meta itemprop="description" content="<?= $image->description ?>"/>
	<meta itemprop="keywords" content="<?= $image->keywords ?>"/>
	<meta itemprop="copyrightHolder" content="<?= $image->copyright ?>"/>

	<span itemprop="creator" itemscope itemtype="http://schema.org/Person">
		<meta itemprop="givenName" content="<?=$image->artist?>"/>
	</span>

	<span itemprop="associatedMedia" itemscope itemtype="http://schema.org/MediaObject">
		<meta itemprop="height" content="<?= $image->height ?>"/>
		<meta itemprop="width" content="<?= $image->width ?>"/>
		<meta itemprop="encodingFormat" content="jpg"/>
		<meta itemprop="contentSize" content="<?= $image->title ?>"/>
	</span>
</span>


