<?php
	define('ROOT', dirname(__DIR__)); 
	require ROOT.'/../app/Flickr.php';

	$flickr = new Flickr('8ab106f76a997bba0c04f3772c8c0b4e');
	$gallery= $flickr->search($_POST['query']);
	
	require ROOT.'/../app/Views/gallery.php';




