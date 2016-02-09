
<!-- ================================================================ -->
<!--                             UPLOAD                               -->
<!-- ================================================================ -->
 <?php
    //Validation du formulaire d'Upload d'une image

    if(isset($_GET['message'])) {
      echo '<div class="container"> <p>'. $_GET["message"]. '</p></div>';
    }
?>

    
<!-- Debut du formulaire -->
<div class="container">
  <form class="form-inline" enctype="multipart/form-data" action="index.php?p=upload" method="post">
      <div class="form-group">
          <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Ajouter une image :</label>
          <input class="form-control" type="hidden" name="MAX_FILE_SIZE" value="10485760" />
          <div class="input-group">
              <span class="input-group-btn">
                  <span class="btn btn-primary btn-file">
                      Browse&hellip; <input name="fichier" class="file" type="file" id="fichier_a_uploader" >
                  </span>
              </span>
              <input type="text" class="form-control" readonly>
          </div>
      </div>
      <button type="submit" class="btn btn-success">Envoyer</button>
  </form>
</div>
