<?php if((isset($image->title) && !empty($image->title)) || (isset($image->keywords)&& !empty($image->keywords))) { ?>
<div class="container">
	<h3> Images similaires via Flickr  </h3>
	<div class='loading'>
	  <div class='loader'>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--text'></div>
	  </div>
	</div>

	<div id="flickrGallery"> </div>
	
</div>
<?php } ?>