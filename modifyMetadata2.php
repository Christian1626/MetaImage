<!DOCTYPE HTML>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Modification des Metadata</title>
	<meta name="description" content="Outil de modification des metadata de l'image.">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
	<link rel="stylesheet" href="css/bootstrap-image-gallery.css">
	<link rel="stylesheet" href="css/demo.css">


	<style media="screen" type="text/css">
	.img-thumbnail{
		max-height: 20em;
	}
	.centrer{
		margin : auto;
		text-align : center;
	}
	</style>

</head>
<body>
<?php

	//$img 		= $_POST['imageSelected'];
	$imageName 	= $_GET['imageName'];
	//$imageName 	= 'img/photo1.jpg';

	$str = shell_exec('exiftool -json -g1 img/'.$imageName);

	$data=json_decode($str, true);
	$data = $data[0];
	/*echo "<pre>";
	print_r($data);
	echo "</pre>";*/
	$listeKW = "";
	//var_dump($data['IPTC']['Keywords']);
	foreach($data['IPTC']['Keywords'] as $value ) {
		//echo $value;
		if($listeKW == "") {
			$listeKW = $listeKW . $value ;
		}
		else {
			$listeKW = $listeKW . ','.  $value ;
		}

		//echo $listeKW;
	} 

	echo '<div class="centrer">
			<h1>Modification de "'.$imageName.'" :</h1>
			<img src="img/'.$imageName.'" alt="Modifier L\'image courante" class="img-thumbnail" size="5em">
		</div><br/><br/>';

	

echo '<div class="container">
  <form class="form-horizontal" role="form">
    <div class="form-group">
      <label class="control-label col-sm-2" for="filename">FileName:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="filename" value="'.$data['System']['FileName'].'" >
      </div>
    </div>

     <div class="form-group">
      <label class="control-label col-sm-2" for="description">Description:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="description" value="'.$data['IFD0']['ImageDescription'].'" >
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="keywords">Keywords:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="keyword" value="'.$listeKW.'" >
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="copyright">Copyright:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="copyright" value="'.$data['IFD0']['Copyright'].'" >
      </div>
    </div>

     <div class="form-group">
      <label class="control-label col-sm-2" for="artist">Artist:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="artist" value="'.$data['IFD0']['Artist'].'" >
      </div>
    </div>



    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
</div>';


	

	?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation and button states -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="js/bootstrap-image-gallery.js"></script>
<script src="js/demo.js"></script>
</body>
</html>
