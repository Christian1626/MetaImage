<?php


function modifyMetadata($data,$imageName) {
	//Pour contrôler les champs identiques, mettre des hiddens dans le formulaire avec les anciennes valeurs des champs
	/*
	1 - Comparerer _old et nouvelles valeurs.
	2 - Si différents alors trouver tout les champs metadonnées ayant comme valeur le _old.
	3 - Créer la fonction à exec grâce à cette boucle.
	4 - Executer la fonction exec.
	*/
	$amodif=array('Title' =>array(),'Description' =>array(),'Copyright' =>array(),'Artist' =>array());

	foreach (array_slice($data, 2) as $key => $type) {
		foreach ($type as $name => $valeur) {
			//Ptet faire un case
			if($valeur==$_POST['old_title_photo']) {
				$amodif['Title'][]=$key.":".$name;
			}
			if($valeur==$_POST['old_ImageDescription']) {
				$amodif['Description'][]=$key.":".$name;
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

function formatdata($data) {
	$tabvalue=array();
	$tablinked=array();
	$x=0;
	//var_dump($data);
	foreach (array_slice($data, 2) as $key => $type) {
		foreach ($type as $name => $valeur) {
			$validee=0;
				foreach ($tabvalue as $cle => $donnee) {
					if ($donnee==$valeur) {
						$tablinked[$key."##".$name]=$cle;
						$validee=1;
						break;
					}
				}
			if ($validee==0) {
				$tabvalue[$x]=$valeur;
				$tablinked[$key."##".$name]=$x;
				$x++;
			}
		}
	}
	//var_dump($tabvalue);
	//var_dump($tablinked);
	return array($tabvalue,$tablinked);
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
			<div class="col-xs-8 col-centered col-max">
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
									<input type="hidden" id="old_keyword" name="old_keyword" value="'.$listeKW.'" >
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
							</div>

							<input type="hidden" itemprop="image" value="'.$data['XMP-photoshop']['Source'].'"/>
							<input type="hidden" itemprop="url" value="'.$data['XMP-photoshop']['Source'].'"/>
							<input type="hidden" itemprop="dateModified" value="'.$data['IFD0']['ModifyDate'].'"/>
							<input type="hidden" itemprop="dateCreated" value="'.$data['ExifIFD']['CreateDate'].'"/>
							<div itemprop="associatedMedia" itemscope itemtype="http://schema.org/MediaObject">
								<input type="hidden" itemprop="height" value="'.$data['File']['ImageHeight'].'"/>
								<input type="hidden" itemprop="width" value="'.$data['File']['ImageWidth'].'"/>
								<input type="hidden" itemprop="encodingFormat" value="'.$data['File']['FileType'].'"/>
								<input type="hidden" itemprop="contentSize" value="'.$data['System']['FileSize'].'"/>
								<input type="hidden" itemprop="contentUrl" value="'.$data['XMP-photoshop']['Source'].'"/>
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

		echo "<h3> Images similaires via Flickr </h3>";
	  	foreach($data_flickr['photos']['photo'] as $photo) { 
			echo '<img width="100" height="100" src="' . 'http://farm' . $photo["farm"] . '.static.flickr.com/' . $photo["server"] . '/' . $photo["id"] . '_' . $photo["secret"] . '.jpg">'; 
		}

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
	$actual_link = "https://$_SERVER[HTTP_HOST]";

echo '
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="@MetaImage" />
	<meta name="twitter:description" content="'.$data['IFD0']['ImageDescription'].'" />
	<meta name="twitter:title" content="'.$data['XMP-dc']['Title'].'" />
	<meta name="twitter:image:src" content="'.$actual_link.'/MetaImage/img/'.$data['System']['FileName'].'" />
	<meta name="twitter:url" content="'.$actual_link.$_SERVER['REQUEST_URI'].'" />';
}
?>
