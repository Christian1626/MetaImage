<?php 
namespace App\Models;

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

  public function action() {
        if(empty($_FILES['fichier']['name'])) {
            $this->message = "Pas de fichier selectionné.";
            return;
        }
        
        // Recuperation de l'extension du fichier
        $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
        $infosImg = array();

        // On verifie l'extension du fichier
        if(in_array(strtolower($extension),$this->tabExt))
        {
          // On recupere les dimensions du fichier
          $infosImg = getimagesize($_FILES['fichier']['tmp_name']);

          // On verifie le type de l'image
          if($infosImg[2] >= 1 && $infosImg[2] <= 14)
          {
            // On verifie les dimensions et taille de l'image
            if(($infosImg[0] <= $this->WIDTH_MAX) && ($infosImg[1] <= $this->HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= $this->MAX_SIZE))
            {
              // Parcours du tableau d'erreurs
              if(isset($_FILES['fichier']['error'])
                && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
              {
                // On renomme le fichier
                $this->nommd5 = md5(uniqid());
                $nomImage = $this->nommd5 .'.jpg';

                // Si c'est OK, on teste l'upload
                if(move_uploaded_file($_FILES['fichier']['tmp_name'], $this->TARGET.$nomImage))
                {
                  if(!is_dir(ROOT."/public/img/json/")) {
                    mkdir(ROOT."/public/img/json/",0700);
                  }

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