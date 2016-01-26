<?php 


function modifyMetadata($imageName) {
	$param1='-Title="'.addcslashes($_POST['title_photo'], '"').'"';
	$param2='-IFD0:ImageDescription="'.addcslashes($_POST['ImageDescription'], '"').'"';
	$param4='-IFD0:Copyright="'.addcslashes($_POST['copyright'], '"').'"';
	$param5='-IFD0:Artist="'.addcslashes($_POST['artist'], '"').'"';

	$listeParam=$param1.' '.$param2.' '.$param4.' '.$param5.' img/'.$imageName;
	shell_exec('exiftool '.$listeParam);
	
	$arr_kw=explode(',', addcslashes(str_replace(' ', '', $_POST['keywords']), '"'));
	shell_exec('exiftool -Keywords="" img/'.$imageName); //clear
	$strkw="exiftool";
	foreach($arr_kw as $value ) {
		$strkw=$strkw.' -Keywords+="'.$value.'"';
	}
	echo $strkw;
	shell_exec($strkw.' img/'.$imageName); //reconstruction kw

	//header('Location: '.$_SERVER['PHP_SELF'].'page=1');
	//echo "<script>alert('TOTO');</script>";
}

function getMetadata($imageName) {
	$str = shell_exec('exiftool -json -g1 img/'.$imageName);
	$data=json_decode($str, true);

	return $data[0];

}

function displayMetadata($imageName,$data,$listeKW,$latitude,$longitude){
	echo '
	<div class="centrer">
		<h1>'.$data['XMP-dc']['Title'].'</h1>
		<img src="img/'.$imageName.'" alt="Modifier L\'image courante" class="img-thumbnail" size="5em">
	</div><br/><br/>';

	echo '
	<div class="container">
		<div class="row row-centered">
			<div class="col-xs-8 col-centered col-max"><div class="item"><div class="content">
				<form class="form-horizontal" role="form" method="post">
					<div class="form-group">
						<label class="control-label col-sm-2" for="filename">Title :</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="title_photo" name="title_photo" value="'.$data['XMP-dc']['Title'].'" >
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="description">Description:</label>
						<div class="col-sm-10">
							<textarea class="form-control custom-control" rows="3" style="resize:none" name="ImageDescription">'.$data['IFD0']['ImageDescription'].'</textarea>     
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="keywords">Keywords :</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="keyword" name="keywords" value="'.$listeKW.'" >
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="copyright">Copyright :</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="copyright" name="copyright" value="'.$data['IFD0']['Copyright'].'" >
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="artist">Artist :</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="artist" name="artist" value="'.$data['IFD0']['Artist'].'" >
						</div>
					</div>



					<div class="form-group">        
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-warning" name="EnvoyerModif" onclick="return confirm(\'Appliquer définitivement les modifications aux metadatas de :\n '.$imageName.' ?\')">Modifier</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>';

	if (!empty($latitude) && !empty($longitude)) {
		echo '
			<div class="col-xs-4 col-centered col-max"><div class="item">
				<div class="content">
					<google-map latitude="37.77493" longitude="-122.41942" fit-to-markers>
		 				 <google-map-marker latitude="'.$latitude.'" longitude="'.$longitude.'"></google-map-marker>
					</google-map>
				</div>
			</div>
		</div></div>';
	}
}

function displayAllMetadata($data, $imageName) {
	echo '
	<div id="accordion">
		<div id="headingZero" class="panel-heading">
			<h4 class="panel-title"><a href="#collapseZero" data-toggle="collapse" data-parent="#accordion">Cliquez pour afficher toutes les métadonnées de l\'image</a></h4>
		</div>

		<div id="collapseZero" class="panel-collapse collapse">
			<div class="panel-body">
				<pre>';
					$info=shell_exec('exiftool -g1 img/'.$imageName);
					print_r($info);

					echo '
				</pre>
			</div>
		</div>
	</div>';

}

function getListKW($data) {
	$listeKW = "";
	if (is_array($data['IPTC']['Keywords'])){
		foreach($data['IPTC']['Keywords'] as $value ) {
			if($listeKW == "") {
				$listeKW = $listeKW . $value ;
			}
			else {
				$listeKW = $listeKW . ', '.  $value ;
			}
		}
	}else{
		$listeKW=$data['IPTC']['Keywords'];
	}

	return $listeKW;
}


function getLatitude($data) {
	$latitude = explode(" ",$data['Composite']['GPSLatitude']);
	$latitude = DMStoDEC($latitude[0],str_replace("'","",$latitude[2]),str_replace("\"","",$latitude[3]),$latitude[4]);
	return $latitude;
}

function getLongiude($data) {
	$longitude = explode(" ",$data['Composite']['GPSLongitude']);
	$longitude = DMStoDEC($longitude[0],str_replace("'","",$longitude[2]),str_replace("\"","",$longitude[3]),$longitude[4]);
	return $longitude;
}

function DMStoDEC($deg,$min,$sec,$dir)
	{

	// Converts DMS ( Degrees / minutes / seconds / direction ) 
	// to decimal format longitude / latitude
	    $res = $deg+((($min*60)+($sec))/3600);

	    if($dir == "S" || $dir == "W") {
	    	return -$res;
	    }

	    return $res;
	}  


/////////////////////////////////////////////////////
//                 METADATA
/////////////////////////////////////////////////////
function openGraph($data) {
	echo '
	<meta property="og:title" content="'.$data['XMP-dc']['Title'].'" />
	<meta property="og:image" content="img/'.$data['System']['FileName'].'" />
	<meta property="og:description" content="'.$data['IFD0']['ImageDescription'].'" />
	<meta property="og:image:secure_url" content="img/'.$data['System']['FileName'].'" />
	<meta property="og:image:type" content="image/jpeg" />
	<meta property="og:image:width" content="'.$data['File']['ImageWidth'].'" />
	<meta property="og:image:height" content="'.$data['File']['ImageHeight'].'" />'; 
}

function twitterCards($data) {
echo '
	<meta name="twitter:card" content="photo" />
	<meta name="twitter:site" content="@MetaImage" />
	<meta name="twitter:description" content="'.$data['IFD0']['ImageDescription'].'" />
	<meta name="twitter:title" content="'.$data['XMP-dc']['Title'].'" />
	<meta name="twitter:image" content=img/"'.$data['System']['FileName'].'" />
	<meta name="twitter:url" content=img/"'.$data['System']['FileName'].'" />';
}
?>