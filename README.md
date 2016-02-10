# MetaImage

## Demo
https://21102541.users.info.unicaen.fr/devoir-idc/public/index.php

https://dev-21102541.users.info.unicaen.fr/devoir-idc/public/index.php

## Description
Ce projet, fait dans le cadre du cours d'Ingénierie des Documents Composites, a pour objectif le développement d'un site web permettant plusieurs actions autour des images et de leurs métadonnées :
* Mise en ligne d'images par l'utilisateur et sauvegarder sur le serveur.
* Accès aux images au moyen d'une gallerie d'images.
* Accès aux métadonnées de l'image et en permettre la modification.

## Equipe du projet
* BRUNET Alban
* LAFORGE Valentin
* LEROY Christian

## Structure du projet
![alt text](https://github.com/Christian1626/MetaImage/blob/master/public/img/apropos/MVC.png "OpenGraph")
####app
* Modèle : Cette partie va gérer les données du site, comme par exemple la manipulation avec exiftool, la gestion des fichiers
* Vue : Cette partie ne fait aucun calcul, elle récupère seulement les variables et affiche ce qui est necesaire.
* Controller : Cette partie gère la logique du code qui prend des décisions.
*Le fichier Autoloader permet de savoir comment include nos classes

#### bower component 
Ce dossier contient tous les élements necessaires pour le webcomponent GoogleMap

#### public 
Il contient les ressources du projet ainsi que l'index.php

	


## Outils utilisés
### Bootstrap et Blueimp gallery
Bootstrap est un framework CSS connu et performant permettant la création de design web facilement et rapidement.
En plus de bootstrap nous avons utilisé une gallerie d'image, développée par blueimp, qui se base sur du javascript et bootstrap.

### Polymer
Nous avons utilisé Polymer au sein du site afin d'afficher sur google maps le lieu ou a été pris la photographie quand celle-ci a une position.

###Exiftool
####Appel à exiftool
Exiftool est un programme executable en console qui permet d'acceder à la totalité des métadonnées des images et les modifier.
Dans notre site nous utilisons exiftool pour obtenir des fichiers JSON contenant les métadonnées des images, que nous stockons ensuite dans un dossier.

####Optimisation
Nous utilisons des appels à exiftool uniquement pour créer les fichiers JSON qui servent au site mais également lorsqu'on modifie les métadonnées d'une image, dans ce cas le fichier JSON est recréé.
C'est donc avec ce système que nous avons 'optimisé' le site, en ne réduisant les appels à exiftool qu'en cas d'upload et de modification d'image, ne prenant ensuite que les fichiers JSON pour les différents affichages.

####Modification des metadata d'une image
Dans les métadonnées il existe des champs parlant des mêmes valeurs, par exemple "object name", "title" et "headline". Afin de garder une cohérence dans les données, nous avons mit en place un algorithme qui lie chaque champ modifié dans l'application à un ensemble de champ des métadonnées et qui les modifient toutes quand on modifie une nouvelle valeur.
L'algorithme, lors de la modification, liste tout les champs des métadonnées ayant exactement la même valeur que la valeur précédente du champ qu'on veut modifier, les stocke, et les modifie ensuite tous avec la nouvelle valeur.
Ainsi, au lieu de mettre en place un formulaire supplémentaire nécessitant l'action d'un utilisateur pour valider le problème, nous avons automatisé la modification pour la rendre transparente à l'utilisateur.

###Recherche Flickr
Nous avons ajouté, sur la page de détails d'une image, une recherche flickr montrant un ensemble d'image se rapprochant de celle détaillée, ce grâce à une recherche sur flickr avec les keywords ou le titre contenus dans les métadonnées de l'image.

###Métadonnées
Nous avons mis en place, pour les pages de détails de chaque image, un ensemble de metadata provenant de trois bases: Microdata, Open Graph et Twitter Cards.

####Microdata sur la page d'accueil
Par exemple si on dispose de 3 images sur notre page d'accueil nous obtenons: 
![alt text](https://github.com/Christian1626/MetaImage/blob/master/public/img/apropos/homeMetadata.PNG "Microdata de la page d'accueil")

####Microdata sur la page de détail d'une image
Voici l'exemple d'une image qui comporte beaucoup de metadata, nous obtenons ceci:
![alt text](https://github.com/Christian1626/MetaImage/blob/master/public/img/apropos/imageMetadata.PNG "Microdata d'une image")

####TwitterCards
Si on souhaite partager notre image sur Twitter ce "snippet" apparait:
![alt text](https://github.com/Christian1626/MetaImage/blob/master/public/img/apropos/twittercards.png "TwitterCards")

####OpenGraph
Si on veut partager notre image sur notre mur facebook ce "snipet" apparait:
![alt text](https://github.com/Christian1626/MetaImage/blob/master/public/img/apropos/opengraph.png "OpenGraph")
