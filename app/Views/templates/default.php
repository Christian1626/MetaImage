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
    <link rel="stylesheet" href="css/main.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster|Pacifico|Dosis|Oswald|Marmelad ' rel='stylesheet' type='text/css'>
    <link rel="import" href="../bower_components/google-map/google-map.html">

    <?php if(isset($metadata)) {
        echo $metadata;
    }; ?>

</head>


<body>
<div class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-fixed-top .navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php" name="accueil">MetaImage</a>
        </div>
        <!-- MENU -->
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
               <li><a href="index.php?p=apropos" name="A PROPOS">A PROPOS</a></li>
            </ul>
        </div>
    </div>
</div>


<?= $content; ?>

<!-- Scripts -->
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="../bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="js/bootstrap-image-gallery.js"></script>
<script src="js/metajs.js"></script>
</body>
</html>
