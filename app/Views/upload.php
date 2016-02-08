<!-- ================================================================ -->
<!--                             UPLOAD                               -->
<!-- ================================================================ -->
 <?php
    require_once ROOT.'/app/Upload.php';

    
    $upload = new Upload();

    //Validation du formulaire d'Upload d'une image
    if(!empty($_POST)) {
        if( !empty($_FILES['fichier']['name'])) {
            $upload->action($_FILES);

            if($upload->error) { 
                echo $upload->message;
            } else {
                echo '<script type=text/javascript>document.location.replace("modifyMetadata.php?imageName='.$upload->nommd5.'")</script>';
            }


        }
    }
?>

    
<!-- Debut du formulaire -->
<div class="container">
  <form class="form-inline" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="form-group">
          <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Ajouter une image :</label>
          <input class="form-control" type="hidden" name="MAX_FILE_SIZE" value="<?= $upload->MAX_SIZE ?>" />
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

<script>
$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }

    });
});
</script>
