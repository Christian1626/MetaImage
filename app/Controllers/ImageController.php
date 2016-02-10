<?php

namespace App\Controllers;
use App\Models;

class ImageController extends Controller {
	public function __construct(){
		parent::__construct();
		$this->flickr = new Models\Flickr('8ab106f76a997bba0c04f3772c8c0b4e');
		$this->json = new Models\Json();
		$this->image = new Models\Image();
	}

	public function index(){
    	$this->json = new Models\Json();
    	$image = $this->image;
    	$actual_link = "https://".$_SERVER['HTTP_HOST'];
		$full_url = $actual_link.$_SERVER['REQUEST_URI'];

		$this->render('pages.details',compact('image','actual_link','full_url'));
	}

	public function modifyMetadata() {
		$this->image->modifyMetadata();
		header('Location: index.php?p=details&imageName='.$this->image->name);
	}
}