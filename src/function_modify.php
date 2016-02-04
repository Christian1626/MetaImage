<?php


function modifyMetadata($data,$imageName) {
	//Pour contrôler les champs identiques, mettre des hiddens dans le formulaire avec les anciennes valeurs des champs
	$amodif=array('Title' =>array(),'Description' =>array(),'Copyright' =>array(),'Artist' =>array());

	if (count(explode(',', addcslashes(str_replace(', ', ',', $_POST['old_keywords']), '"')))==1) {
		$arraykw=$_POST['old_keywords'];
	} else {
		$arraykw=explode(',', addcslashes(str_replace(', ', ',', $_POST['old_keywords']), '"'));
	}
	foreach (array_slice($data, 2) as $key => $type) {
		foreach ($type as $name => $valeur) {
			//var_dump($valeur);
			//Ptet faire un case
			if($valeur==$_POST['old_title_photo']) {
				$amodif['Title'][]=$key.":".$name;
			}
			if($valeur==$_POST['old_ImageDescription']) {
				$amodif['Description'][]=$key.":".$name;
			}
			if($valeur==$arraykw) {
				$amodif['keywords'][]=$key.":".$name;
			}
			if($valeur==$_POST['old_copyright']) {
				$amodif['Copyright'][]=$key.":".$name;
			}
			if($valeur==$_POST['old_artist']) {
				$amodif['Artist'][]=$key.":".$name;
			}
		}
	}

	$listeParam="";

	//Vérifie si il y a au moins un champ à modifier, si il y en a pas, alors il ajoute le champ de base.
	//Cela permet d'éviter le problème des champs qui n'existent pas encore et qui ne sont donc pas créés.
	if (count($amodif['Title'])==0) {
		$amodif['Title'][]='XMP-dc:Title';
	}
	if (count($amodif['Description'])==0) {
		$amodif['Description'][]='IFD0:ImageDescription';
	}
	if (count($amodif['Copyright'])==0) {
		$amodif['Copyright'][]='IFD0:Copyright';
	}
	if (count($amodif['Artist'])==0) {
		$amodif['Artist'][]='IFD0:Artist';
	}
	if (count($amodif['keywords'])==0) {
		$amodif['keywords'][]='IPTC:Keywords';
	}


	foreach($amodif['Title'] as $name) {
		$listeParam.='-'.$name.'="'.addcslashes($_POST['title_photo'], '"').'" ';
	}

	foreach($amodif['Description'] as $name) {
		$listeParam.='-'.$name.'="'.addcslashes($_POST['ImageDescription'], '"').'" ';
	}

	foreach($amodif['Copyright'] as $name) {
		$listeParam.='-'.$name.'="'.addcslashes($_POST['copyright'], '"').'" ';
	}
	foreach($amodif['Artist'] as $name) {
		$listeParam.='-'.$name.'="'.addcslashes($_POST['artist'], '"').'" ';
	}

	$listeParam.='img/'.$imageName;
	shell_exec('exiftool '.$listeParam);

	foreach($amodif['keywords'] as $name) {
		shell_exec('exiftool -'.$name.'="" img/'.$imageName);
		shell_exec('exiftool -sep ", " -'.$name.'="'.$_POST['keywords'].'"  img/'.$imageName);
	}
	shell_exec('exiftool -json -g1 img/'.$imageName.' > img/json/'.explode(".",$imageName)[0].'.json');
	shell_exec('exiftool -json -XMP-dc:Title -XMP-dc:Creator -XMP-dc:Rights img/> img/json/home.json');
}




function getMetadata($imageName="") {
	$filename = "img/json/".explode(".",$imageName)[0].".json";
	$str = file_get_contents($filename);
	$data=json_decode($str, true);

	return $data[0];

}

function homeMetadata() {
	$str = file_get_contents("img/json/home.json");
	$data=json_decode($str, true);


	foreach($data as $img) {
		echo '<span itemtype="http://schema.org/Photograph" itemscope>';
		if (isset($img['Title'])) {
		echo '<meta itemprop="about" content="'.$img['Title'].'" />';
		}
		if (isset($img['Creator'])) {
		echo '<span itemprop="creator" itemscope itemtype="http://schema.org/Person">
			<meta itemprop="givenName" content="'.$img['Creator'].'" />
		</span>';
		}
		if (isset($img['Rights'])) {
		echo '<meta itemprop="copyrightHolder" content="'.$img['Rights'].'" />';
		}
		echo '</span>';

	}
}

function displayMetadata($imageName,$data,$listeKW,$latitude,$longitude){
	echo '
	<div class="centrer">
		<h1>'.$data['XMP-dc']['Title'].'</h1>
		<img src="img/'.$imageName.'" alt="Modifier L\'image courante" class="img-thumbnail" size="5em">
	</div><br/><br/>';

	echo '
	<div class="container">
		<div class="row row-centered">';
		if (!empty($latitude) && !empty($longitude)) {
				echo '<div class="col-xs-8 col-centered col-max">';
			} else {
				echo '<div class="col-xs-12 col-centered col-max">';
			}
				echo '
				<div class="item">
					<div class="content" itemtype="http://schema.org/Photograph" itemscope>
						<form class="form-horizontal" role="form" method="post">
							<div class="form-group">
								<label class="control-label col-sm-2" for="filename">Title :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_title_photo" name="old_title_photo" value="'.$data['XMP-dc']['Title'].'" >
									<input itemprop="about" type="text" class="form-control" id="title_photo" name="title_photo" value="'.$data['XMP-dc']['Title'].'" >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="description">Description:</label>
								<div class="col-sm-10" >
									<input type="hidden" id="old_ImageDescription" name="old_ImageDescription" value="'.$data['IFD0']['ImageDescription'].'" >
									<textarea itemprop="description" class="form-control custom-control" rows="3" style="resize:none" name="ImageDescription">'.$data['IFD0']['ImageDescription'].'</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="keywords">Keywords :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_keyword" name="old_keywords" value="'.$listeKW.'" >
									<input itemprop="keywords" type="text" class="form-control" id="keyword" name="keywords" value="'.$listeKW.'" >
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="copyright">Copyright :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_copyright" name="old_copyright" value="'.$data['IFD0']['Copyright'].'" >
									<input itemprop="copyrightHolder" type="text" class="form-control" id="copyright" name="copyright" value="'.$data['IFD0']['Copyright'].'" >
								</div>
							</div>

							<div class="form-group" itemprop="creator" itemscope itemtype="http://schema.org/Person">
								<label class="control-label col-sm-2" for="artist">Artist :</label>
								<div class="col-sm-10">
									<input type="hidden" id="old_artist" name="old_artist" value="'.$data['IFD0']['Artist'].'" >
									<input itemprop="givenName" type="text" class="form-control" id="artist" name="artist" value="'.$data['IFD0']['Artist'].'" >
								</div>
							</div>';

							if (isset($data['XMP-photoshop']['Source'])) {
								echo '<input type="hidden" itemprop="image" value="'.$data['XMP-photoshop']['Source'].'"/>
								<input type="hidden" itemprop="url" value="'.$data['XMP-photoshop']['Source'].'"/>';
							}
							if (isset($data['IFD0']['ModifyDate'])) {
								echo '<input type="hidden" itemprop="dateModified" value="'.$data['IFD0']['ModifyDate'].'"/>';
							}
							if (isset($data['ExifIFD']['CreateDate'])) {
								echo '<input type="hidden" itemprop="dateCreated" value="'.$data['ExifIFD']['CreateDate'].'"/>';
							}
							echo '<div itemprop="associatedMedia" itemscope itemtype="http://schema.org/MediaObject">
								<input type="hidden" itemprop="height" value="'.$data['File']['ImageHeight'].'"/>
								<input type="hidden" itemprop="width" value="'.$data['File']['ImageWidth'].'"/>
								<input type="hidden" itemprop="encodingFormat" value="'.$data['File']['FileType'].'"/>
								<input type="hidden" itemprop="contentSize" value="'.$data['System']['FileSize'].'"/>';
								if (isset($data['XMP-photoshop']['Source'])) {
									echo '<input type="hidden" itemprop="contentUrl" value="'.$data['XMP-photoshop']['Source'].'"/>';
								}
							echo '
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
		</div>
	</div>';
	}

}

function displayAllMetadata($data, $imageName) {
	echo '
	<div class="row row-centered">
		<div class="col-xs-12 col-centered col-max">
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
		</div>
		</div>
	</div>';

}

function getListKW($data) {
	$listeKW = "";
	if (isset($data['IPTC']['Keywords'])) {
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
	}
	return $listeKW;
}


function getLatitude($data) {
	if(isset($data['Composite']['GPSLatitude'])) {
		$latitude = explode(" ",$data['Composite']['GPSLatitude']);
		$latitude = DMStoDEC($latitude[0],str_replace("'","",$latitude[2]),str_replace("\"","",$latitude[3]),$latitude[4]);
		return $latitude;
	}
	return 0;
}

function getLongiude($data) {
	if(isset($data['Composite']['GPSLatitude'])) {
		$longitude = explode(" ",$data['Composite']['GPSLongitude']);
		$longitude = DMStoDEC($longitude[0],str_replace("'","",$longitude[2]),str_replace("\"","",$longitude[3]),$longitude[4]);
		return $longitude;
	}
	return 0;
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
//                 FLICKR
/////////////////////////////////////////////////////
function displaySimilarPicture($latitude,$longitude, $query) {
	$api_key = '8ab106f76a997bba0c04f3772c8c0b4e';

	$perPage = 30;
	$url = "";

	//TODO : authentification Flickr pour faire la recherche en fonction des cordonnées GPS
 	/*if (!empty($latitude) && !empty($longitude)) {
		$url = 'https://api.flickr.com/services/rest/?method=flickr.photos.geo.photosForLocation';
		$url.= '&tags='.$tag;
		$url.= '&lat='.$latitude;
		$url.= '&lon='.$longitude;
		$url.= '&accuracy=5';
	} else {*/
		//$tag = ;
		$url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
		$query = str_replace(' ', '', $query);
		$url.= '&tags='.$query;
		//$url.= '&tags='.$tag;
		//$url.= '&safe_search=1';
		//$url.= '&accuracy=16';
		//$url.= '&place_id=Mairie';
	//}

		//$url.= '&tags=mountainview,google,mountainview,california';


		$url.= '&api_key='.$api_key;
		$url.= '&per_page='.$perPage;
		$url.= '&format=json';
		$url.= '&nojsoncallback=1';
		$url.= '&sort=interestingness-desc';


		$proxy = "http://proxy.unicaen.fr:3128";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_PROXY, $proxy);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$json = curl_exec($curl);
		$data_flickr = json_decode($json,TRUE);
		//var_dump($data_flickr);

		$img ="";
		echo "<h3> Images similaires via Flickr </h3>";
	  	foreach($data_flickr['photos']['photo'] as $photo) {
	  		$src = 'http://farm' . $photo["farm"] . '.static.flickr.com/' . $photo["server"] . '/' . $photo["id"] . '_' . $photo["secret"] . '.jpg';
			$img.= '<a data-gallery href="'.$src.'" ><img  width="100" height="100" src="'.$src.'"/></a>';
		}

		displayGallery($img);


}

function displayGallery($img) {
	echo '
<div class="container">
    <div id="links">'.$img.'</div>
    <br>
</div>
<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <div class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        Précédente
                    </button>

                    <button type="button" class="btn btn-primary next">
                        Suivante
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="fileNames"> </div>';
}

/////////////////////////////////////////////////////
//                 METADATA
/////////////////////////////////////////////////////
function openGraph($data) {
	if(isset($data['XMP-dc']['Title'])) {echo '<meta property="og:title" content="'.$data['XMP-dc']['Title'].'" />';}
	if(isset($data['System']['FileName'])) {echo '<meta property="og:image" content="img/'.$data['System']['FileName'].'" />';}
	if(isset($data['IFD0']['ImageDescription'])) {echo '<meta property="og:description" content="'.$data['IFD0']['ImageDescription'].'" />';}
	if(isset($data['System']['FileName'])) {echo '<meta property="og:image:secure_url" content="img/'.$data['System']['FileName'].'" />';}
	echo '<meta property="og:image:type" content="image/jpeg" />';
	if(isset($data['File']['ImageWidth'])) {echo '<meta property="og:image:width" content="'.$data['File']['ImageWidth'].'" />';}
	if(isset($data['File']['ImageHeight'])) {echo '<meta property="og:image:height" content="'.$data['File']['ImageHeight'].'" />';}
}

function twitterCards($data) {
	$actual_link = "https://$_SERVER[HTTP_HOST]";

	echo '<meta name="twitter:card" content="summary_large_image" />';
	echo '<meta name="twitter:site" content="@MetaImage" />';
	if(isset($data['IFD0']['ImageDescription'])) {echo '<meta name="twitter:description" content="'.$data['IFD0']['ImageDescription'].'" />';}
	if(isset($data['XMP-dc']['Title'])) {echo '<meta name="twitter:title" content="'.$data['XMP-dc']['Title'].'" />';}
	if(isset($data['System']['FileName'])) {echo '<meta name="twitter:image:src" content="'.$actual_link.'/MetaImage/img/'.$data['System']['FileName'].'" />';}
	echo '<meta name="twitter:url" content="'.$actual_link.$_SERVER['REQUEST_URI'].'" />';
}
?>
