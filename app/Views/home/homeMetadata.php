<!-- ================================================================ -->
<!--                    BRIEF METADATA DES IMAGES                     -->
<!-- ================================================================ -->

<?php
if(isset($gallery)) {
	foreach($gallery as $img) {
		echo '<span itemtype="http://schema.org/Photograph" itemscope>';
		if (isset($img['Title'])) {
			echo '<meta itemprop="about" content="'.$img['Title'].'" />';
		}
		if (isset($img['Creator'])) {
			echo '
			<span itemprop="creator" itemscope itemtype="http://schema.org/Person">
				<meta itemprop="givenName" content="'.$img['Creator'].'" />
			</span>';
		}
		if (isset($img['Rights'])) {
			echo '<meta itemprop="copyrightHolder" content="'.$img['Rights'].'" />';
		}
		echo '</span>';
	}
}
