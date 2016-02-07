<?php


	$query = $_POST['query'];
	$query = str_replace(' ', '', $query);
	$api_key = '8ab106f76a997bba0c04f3772c8c0b4e';

	$perPage = 30;
	$url = "";
	$url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
	$url.= '&tags='.$query;
	//$url.= '&safe_search=1';
	//$url.= '&accuracy=16';


	$url.= '&api_key='.$api_key;
	$url.= '&per_page='.$perPage;
	$url.= '&format=json';
	$url.= '&nojsoncallback=1';
	$url.= '&sort=interestingness-desc';


	$proxy = "http://proxy.unicaen.fr:3128";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_PROXY, $proxy);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$json = curl_exec($curl);
	$data_flickr = json_decode($json,TRUE);
	//var_dump($data_flickr);

	$img ="";
	  	
 ?>



<div class="container">
    <div id="links"> 
    	<?php 
	   		 foreach($data_flickr['photos']['photo'] as $photo) {
		  		$src = 'http://farm' . $photo["farm"] . '.static.flickr.com/' . $photo["server"] . '/' . $photo["id"] . '_' . $photo["secret"] . '.jpg';
				echo '<a data-gallery href="'.$src.'" ><img  width="100" height="100" src="'.$src.'"/></a>';
			}
		?> 
	</div>
    <br>
</div>
<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <div class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        Précédente
                    </button>

                    <button type="button" class="btn btn-primary next">
                        Suivante
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

