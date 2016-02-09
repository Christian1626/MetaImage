<?php 
define('ROOT', dirname(__DIR__)); 
require ROOT.'/app/Autoloader.php';

App\Autoloader::register();


if(isset($_GET['p'])) {
	$p = $_GET['p'];
} else {
	$p = 'home';
}



//Routing
if($p === 'home') {
	$controller = new \App\Controllers\HomeController();
	$controller->index();
} elseif($p === 'upload') {
	$controller = new \App\Controllers\HomeController();
	$controller->upload();
} else if($p === 'details'){
	$controller = new \App\Controllers\ImageController();
	$controller->index();
} else if($p === 'modify') {
	$controller = new \App\Controllers\ImageController();
	$controller->modifyMetadata();
} else if($p === 'apropos') {
	$controller = new \App\Controllers\AProposController();
	$controller->index();
} else {
	$controller = new \App\Controllers\HomeController();
	$controller->index();
}




