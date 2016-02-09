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
		$this->render('pages.details',compact('image'));
	}

	public function modifyMetadata() {
		$this->image->modifyMetadata();
		header('Location: index.php?p=details&imageName='.$this->image->name);
	}
}