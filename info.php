<!DOCTYPE HTML>
<!--
/*
 * Bootstrap Image Gallery Demo
 * https://github.com/blueimp/Bootstrap-Image-Gallery
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
-->
<html lang="en">
<head>
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<meta charset="utf-8">
<title>MetaImage - Infos</title>
<meta name="description" content="MetaImage affiche les métadonnées des images">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="css/demo.css">
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="css/bootstrap-image-gallery.css">
<link href='https://fonts.googleapis.com/css?family=Lobster|Pacifico|Dosis|Oswald' rel='stylesheet' type='text/css'>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>


<!-- Polymer -->
<script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
<link rel="import" href="bower_components/google-map/google-map.html">


</head>
<body>
<?php include("src/navigation-bar.php"); ?>

<div class="container">
<h1>Objectifs du projet</h1>
Ce projet, fait dans le cadre du cours d'<strong>Ingénierie des Documents Composites</strong>, a pour objectif le développement d'un site web permettant plusieurs actions autour des images et de leurs métadonnées :
<ul>
<li>Mise en ligne d'images par l'utilisateur et sauvegarder sur le serveur.</li>
<li>Accès aux images au moyen d'une gallerie d'images.</li>
<li>Accès aux métadonnées de l'image et en permettre la modification.</li>
</ul>

L'équipe du projet sur lequel vous vous trouvez est composée de :
<ul>
<li>Brunet Alban</li>
<li>Laforge Valentin</li>
<li>Leroy Christian</li>
</ul>
<h1>Outils utilisés</h1>
<h2><a href="http://getbootstrap.com/">Bootstrap</a> et <a href="https://blueimp.github.io/Bootstrap-Image-Gallery/">Blueimp gallery</a></h2>
Bootstrap est un framework CSS connu et performant permettant la création de design web facilement et rapidement.</br>
En plus de bootstrap nous avons utilisé une gallerie d'image, développée par blueimp, qui se base sur du javascript et bootstrap.

<h2><a href="https://www.polymer-project.org/1.0/">Polymer</a></h2>
Nous avons utilisé Polymer au sein du site afin d'afficher sur google maps le lieu ou a été pris la photographie quand celle-ci a une position.

<h2><a href="http://www.sno.phy.queensu.ca/~phil/exiftool/">Exiftool</a></h2>
Exiftool est un programme executable en console qui permet d'acceder à la totalité des métadonnées des images et les modifier.

<h2><a href="https://dev.twitter.com/cards/overview">Twitter Card</a></h2>
<img src="img/apropos/twittercards.png" width="400" height="400" name="twittercards">
<h2><a href="http://ogp.me/">Open Graph</a></h2>
<img src="img/apropos/opengraph.png" width="400" height="400" name="opengraph">
</div>
</body>
</html>
