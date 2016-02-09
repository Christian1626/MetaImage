<?php

namespace App\Controllers;
use App\Models;

class HomeController extends Controller {
	public function __construct(){
		parent::__construct();
		$this->json = new Models\Json();
	}


	public function index(){
    	$this->json = new Models\Json();
    	$gallery = $this->json->getAllImages();
		$this->render('pages.home',compact('gallery'));
	}

	public function upload(){
		$upload = new Models\Upload();
    	$upload->action($_FILES);

    	if($upload->error) { 
            $this->json = new Models\Json();
            header('Location: index.php?p=home&message='.$upload->message);
        } else {
            header('Location: index.php?p=details&imageName='.$upload->nommd5);
        }
        
	}
}