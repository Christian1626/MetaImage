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
En plus de bootstrap nous avons utilisé une gallerie d'image, développée par blueimp, qui se base sur du javascript et bootstrap afin de faire l'affichage de la page d'accueil ainsi que la pop-up présentant les images.

<h2><a href="https://www.polymer-project.org/1.0/">Polymer</a></h2>
Nous avons utilisé Polymer au sein du site afin d'afficher sur google maps le lieu ou a été pris la photographie quand celle-ci a une position géographique définie dans ses métadonnées.

<h2><a href="http://www.sno.phy.queensu.ca/~phil/exiftool/">Exiftool</a></h2>
<h3>Appel à exiftool</h3>
Exiftool est un programme executable en console qui permet d'acceder à la totalité des métadonnées des images et les modifier.</br>
Dans notre site nous utilisons exiftool pour obtenir des fichiers JSON contenant les métadonnées des images, que nous stockons ensuite dans un dossier.</br>

<h3>Optimisation</h3>
Nous utilisons des appels à exiftool uniquement pour créer les fichiers JSON qui servent au site mais également lorsqu'on modifie les métadonnées d'une image, dans ce cas le fichier JSON est recréé.</br>
C'est donc avec ce système que nous avons 'optimisé' le site, en ne réduisant les appels à exiftool qu'en cas d'upload et de modification d'image, ne prenant ensuite que les fichiers JSON pour les différents affichages.</br>

<h3>Modification de différents champs 'identiques'</h3>
Dans les métadonnées il existe des champs parlant des mêmes valeurs, par exemple "object name", "title" et "headline". Afin de garder une cohérence dans les données, nous avons mit en place un algorithme qui lie chaque champ modifié dans l'application à un ensemble de champ des métadonnées et qui les modifient toutes quand on modifie une nouvelle valeur.</br>
L'algorithme, lors de la modification, liste tout les champs des métadonnées ayant exactement la même valeur que la valeur précédente du champ qu'on veut modifier, les stocke, et les modifie ensuite tous avec la nouvelle valeur.</br>
Ainsi, au lieu de mettre en place un formulaire supplémentaire nécessitant l'action d'un utilisateur pour valider le problème, nous avons automatisé la modification pour la rendre transparente à l'utilisateur.

<h2><a href="https://www.flickr.com/">Recherche Flickr</a></h2>
Nous avons ajouté, sur la page de détails d'une image, une recherche flickr montrant un ensemble d'image se rapprochant de celle détaillée, ce grâce à une recherche sur flickr avec les keywords contenus dans les métadonnées de l'image.

<h2>Microdata, Open Graph et Twitter Card</h2>
Nous avons mit en place, pour les pages de détail de chaque image, un ensemble de metadata provenant de trois bases : Microdata, Open Graph et Twitter Cards.</br>
Voici deux exemples imagés des résultats qu'on obtient sur facebook (Open Graph) et sur twitter (Twitter Cards) quand on ajoute un lien de notre site sur ces sites.</br>
<img src="img/apropos/twittercards.png" width="400" height="400" name="twittercards">
<img src="img/apropos/opengraph.png" width="400" height="400" name="opengraph">
