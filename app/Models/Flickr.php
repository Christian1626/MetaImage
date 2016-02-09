<?php
namespace App\Models;

class Flickr { 
	private $apiKey; 
	
	public function __construct($apikey = null) {
		$this->apiKey = $apikey;
	} 
	
	public function search($query = null) { 
		$query = str_replace(' ', '', $query);

		$perPage = 30;
		$url = "";
		$url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
		$url.= '&tags='.$query;
		//$url.= '&safe_search=1';
		//$url.= '&accuracy=16';


		$url.= '&api_key='.$this->apiKey;
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

		return $data_flickr;
	}	
}
?>