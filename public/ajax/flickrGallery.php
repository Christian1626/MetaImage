<?php
	define('ROOT', dirname(__DIR__)); 
	require_once ROOT.'/../app/Models/Flickr.php';

	$flickr = new App\Models\Flickr('8ab106f76a997bba0c04f3772c8c0b4e');
	$gallery= $flickr->search($_POST['query']);
	
	require ROOT.'/../app/Views/utils/gallery.php';




