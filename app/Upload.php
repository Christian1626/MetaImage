<?php 
require_once 'ExifTool.php';

class Upload {

  public function __construct() {
    $this->TARGET = ROOT."/public/img/";
    $this->MAX_SIZE = 10485760;
    $this->WIDTH_MAX = 20000;
    $this->HEIGHT_MAX = 20000;
    $this->error = True;
    $this->message = "";
    $this->nommd5 = "";
    $this->tabExt = array('jpg','jpeg');    // Extensions autorisees
  }

  public function action($file) {
        // Recuperation de l'extension du fichier
        $extension  = pathinfo($file['fichier']['name'], PATHINFO_EXTENSION);
        $infosImg = array();

        // On verifie l'extension du fichier
        if(in_array(strtolower($extension),$this->tabExt))
        {
          // On recupere les dimensions du fichier
          $infosImg = getimagesize($file['fichier']['tmp_name']);

          // On verifie le type de l'image
          if($infosImg[2] >= 1 && $infosImg[2] <= 14)
          {
            // On verifie les dimensions et taille de l'image
            if(($infosImg[0] <= $this->WIDTH_MAX) && ($infosImg[1] <= $this->HEIGHT_MAX) && (filesize($file['fichier']['tmp_name']) <= $this->MAX_SIZE))
            {
              // Parcours du tableau d'erreurs
              if(isset($file['fichier']['error'])
                && UPLOAD_ERR_OK === $file['fichier']['error'])
              {
                // On renomme le fichier
                $this->nommd5 = md5(uniqid());
                $nomImage = $this->nommd5 .'.'. $extension;

                // Si c'est OK, on teste l'upload
                if(move_uploaded_file($file['fichier']['tmp_name'], $this->TARGET.$nomImage))
                {
                  $exif = new ExifTool();
                  $exif->createJSON($this->TARGET.$nomImage,$this->TARGET.'/json/'.$this->nommd5.'.json');
                  $exif->refreshHomeJSON();
                  $this->message = 'Upload réussi !';
                  $this->error = False;
                }
                else
                {
                  // Sinon on affiche une erreur systeme
                  $this->message = 'Problème lors de l\'upload !';
                }
              }
              else
              {
                $this->message = 'Une erreur interne a empêché l\'uplaod de l\'image';
              }
            }
            else
            {
              // Sinon erreur sur les dimensions et taille de l'image
              $this->message = 'Votre image ne respecte pas les limites (20000x2000 en taille et 10Mo maxi)';
            }
          }
          else
          {
            // Sinon erreur sur le type de l'image
            $this->message = "L'image uploadée n'est pas correcte !";
          }
        }
        else
        {
          // Sinon on affiche une erreur pour l'extension
          $this->message = 'L\'extension du fichier est incorrecte !';
        }
  }
}