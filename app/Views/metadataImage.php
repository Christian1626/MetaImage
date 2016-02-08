<!-- ================================================================ -->
<!--                      METADATA DE L'IMAGE                         -->
<!-- ================================================================ -->


<?php $actual_link = "https://$_SERVER[HTTP_HOST]"; ?>

<!-- OpenGraph -->
<meta property="og:title" content="<?= $title ?>" />
<meta property="og:image" content="img/<?= $fileName ?>" />
<meta property="og:description" content="<?= $description ?>" />
<meta property="og:image:secure_url" content="<?=$actual_link?>/MetaImage/public/img/<?= $fileName ?>" />
<meta property="og:image:type" content="image/jpeg" />
<meta property="og:image:width" content="<?= $width ?>" />
<meta property="og:image:height" content="<?= $height ?>" />


<!-- TwitterCard -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@MetaImage" />
<meta name="twitter:description" content="<?= $description ?>" />
<meta name="twitter:title" content="<?= $title ?>" />
<meta name="twitter:image:src" content="<?=$actual_link?>/MetaImage/public/img/<?= $fileName ?>" />
<meta name="twitter:url" content="<?=$actual_link.$_SERVER['REQUEST_URI'] ?>" />

<!-- MetaData Image -->
<meta itemprop="image" content="<?=$actual_link?>/MetaImage/public/img/<?= $fileName ?>"/>
<meta itemprop="url" content="<?= $source ?>"/>
<meta itemprop="contentUrl" content="<?= $source ?>"/>
<meta itemprop="dateModified" content="<?= $modifyDate ?>"/>
<meta itemprop="dateCreated" content="<?= $dateCreated ?>"/>
<meta itemprop="about" content="<?= $title ?>"/>
<meta itemprop="description" content="<?= $description ?>"/>
<meta itemprop="keywords" content="<?= $keywords ?>"/>
<meta itemprop="copyrightHolder" content="<?= $copyright ?>"/>

<span itemprop="creator" itemscope itemtype="http://schema.org/Person">
	<meta itemprop="givenName" content="'.$artist.'"/>
</span>

<span itemprop="associatedMedia" itemscope itemtype="http://schema.org/MediaObject">
	<meta itemprop="height" content="<?= $height ?>"/>
	<meta itemprop="width" content="<?= $width ?>"/>
	<meta itemprop="encodingFormat" content="jpg?>"/>
	<meta itemprop="contentSize" content="<?= $title ?>"/>
</span>
