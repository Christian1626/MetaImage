<?php 
define('ROOT', dirname(__DIR__)); 
//require ROOT.'app/Flickr.php';
require_once ROOT.'/app/Image.php';
require_once ROOT.'/app/Json.php';
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<meta charset="utf-8">
<title>MetaImage</title>
<meta name="description" content="MetaImage affiche les métadonnées des images.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="css/bootstrap-image-gallery.css">
<link rel="stylesheet" href="css/demo.css">
<link href='https://fonts.googleapis.com/css?family=Lobster|Pacifico|Dosis|Oswald' rel='stylesheet' type='text/css'>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<?php 
    $json = new Json();
    $gallery = $json->getAllImages();
    require ROOT.'/app/Views/homeMetadata.php';
?>
</head>


<body>
<?php include(ROOT."/app/Views/navigation-bar.php"); ?>

<?php 
//affiche le formulaire d'upload
require ROOT.'/app/Views/upload.php';

//affiche la gallerie des images
require ROOT.'/app/Views/gallery.php';
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation and button states -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="js/bootstrap-image-gallery.js"></script>
<script src="js/renderImages.js"></script>
</body>
</html>
