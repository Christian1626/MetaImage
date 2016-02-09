<?php

namespace App\Controllers;
use App\Models;

class AProposController extends Controller {
	public function index(){
		$this->render('pages.apropos');
	}
}