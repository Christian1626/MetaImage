<?php
/************************************************************
 * Definition des constantes / tableaux et variables
 *************************************************************/
 
// Constantes
define('TARGET', 'img/');    // Repertoire cible
define('MAX_SIZE', 1000000);    // Taille max en octets du fichier
define('WIDTH_MAX', 20000);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 20000);    // Hauteur max de l'image en pixels
 
// Tableaux de donnees
$tabExt = array('jpg','jpeg');    // Extensions autorisees
$infosImg = array();
 
// Variables
$extension = '';
$message = '';
$nomImage = '';
 
/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/
if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}
 
/************************************************************
 * Script d'upload
 *************************************************************/
if(!empty($_POST))
{
  // On verifie si le champ est rempli
  if( !empty($_FILES['fichier']['name']) )
  {
    // Recuperation de l'extension du fichier
    $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
 
    // On verifie l'extension du fichier
    if(in_array(strtolower($extension),$tabExt))
    {
      // On recupere les dimensions du fichier
      $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
 
      // On verifie le type de l'image
      if($infosImg[2] >= 1 && $infosImg[2] <= 14)
      {
        // On verifie les dimensions et taille de l'image
        if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
        {
          // Parcours du tableau d'erreurs
          if(isset($_FILES['fichier']['error']) 
            && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
          {
            // On renomme le fichier
            $nomImage = md5(uniqid()) .'.'. $extension;
 
            // Si c'est OK, on teste l'upload
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
            {
              $message = 'Upload réussi !';
            }
            else
            {
              // Sinon on affiche une erreur systeme
              $message = 'Problème lors de l\'upload !';
            }
          }
          else
          {
            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
          }
        }
        else
        {
          // Sinon erreur sur les dimensions et taille de l'image
          $message = 'Erreur dans les dimensions de l\'image !';
        }
      }
      else
      {
        // Sinon erreur sur le type de l'image
        $message = 'Le fichier à uploader n\'est pas une image !';
      }
    }
    else
    {
      // Sinon on affiche une erreur pour l'extension
      $message = 'L\'extension du fichier est incorrecte !';
    }
  }
  else
  {
    // Sinon on affiche une erreur pour le champ vide
    $message = 'Veuillez remplir le formulaire svp !';
  }
}
?>

 <?php
      if( !empty($message) ) 
      {
        echo '<p>',"\n";
        echo "\t\t<strong>", htmlspecialchars($message) ,"</strong>\n";
        echo "\t</p>\n\n";
      }
    ?>
    <!-- Debut du formulaire -->
    <form class="form-inline" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Ajouter une image :</label>
            <input class="form-control" type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        Browse&hellip; <input name="fichier" class="file" type="file" id="fichier_a_uploader" >
                    </span>
                </span>
                <input type="text" class="form-control" readonly>
            </div>
        </div>
        <button type="submit" class="btn btn-default">Envoyer</button>
    </form>
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