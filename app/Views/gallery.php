
<!-- ================================================================ -->
<!--                      GALLERIE D'IMAGES                           -->
<!-- ================================================================ -->


<div class="container">
    <br/>
    <!-- The container for the list of example images -->
    <div id="links">
       <?php

       //IMAGE AVEC FLICKR -> page de détails d'une image
       if(isset($gallery['photos']['photo'])) {
            foreach($gallery['photos']['photo'] as $photo) {
                $src = 'http://farm' . $photo["farm"] . '.static.flickr.com/' . $photo["server"] . '/' . $photo["id"] . '_' . $photo["secret"] . '.jpg';
                echo '<a data-gallery href="'.$src.'" ><img  width="100" height="100" src="'.$src.'"/></a>';
            }
        }
        else { //IMAGE LOCAL -> page accueil
           foreach($gallery as $img) {
                $imageName =   str_replace('.jpg', '', str_replace('img/', '', $img['SourceFile']));

                $title = isset($img['Title']) ? $img['Title'] : "";
                $author = isset($img['Creator']) ? $img['Creator'] : "";
                echo'<a data-gallery href="'.$img['SourceFile'].'" title="'.$title.' - Par '.$author.'"><img width="350" height="300" src="'.$img['SourceFile'].'"/></a>';
            }
        }
      ?>
  </div>
  <br>
</div>

<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        Précédente
                    </button>

                    <a href='' id="bouton_modifier" class="mr"><button type="button" class="btn btn-warning pull-middle" >
                        <i class="glyphicon"></i>
                        Voir et modifier les métadonnées
                    </button></a>


                    <button type="button" class="btn btn-primary next">
                        Suivante
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
