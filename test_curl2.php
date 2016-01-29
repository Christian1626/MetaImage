<?php 

	$api_key = '8ab106f76a997bba0c04f3772c8c0b4e';
 
	$tag = ['california, google, googleplex, mountainview'];
	$query = 'california, google, googleplex, mountainview';
	$perPage = 25;
	$url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
	$url.= '&api_key='.$api_key;
	$url.= '&tags=mountainview,google,mountainview,california';
	//$url.= '&text='.$query;
	$url.= '&per_page='.$perPage;
	$url.= '&format=json';
	$url.= '&nojsoncallback=1';
	$url.= '&sort=interestingness-desc';
	//$url.= '&safe_search=1';
	//$url.= '&accuracy=16';
	//$url.= '&place_id=Mairie';

	$proxy = "http://proxy.unicaen.fr:3128";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_PROXY, $proxy);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$json = curl_exec($curl);
	$data_flickr = json_decode($json,TRUE);
	var_dump($data_flickr);

  	foreach($data_flickr['photos']['photo'] as $photo) { 
		echo '<img src="' . 'http://farm' . $photo["farm"] . '.static.flickr.com/' . $photo["server"] . '/' . $photo["id"] . '_' . $photo["secret"] . '.jpg">'; 
	}
  ?>