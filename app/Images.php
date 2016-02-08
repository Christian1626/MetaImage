<?php

class Images {
	public function __construct() {

	}

	public function getImages() {
		$str = file_get_contents(ROOT."/public/img/json/home.json");
		return json_decode($str, true);
	}

	public function getImage($imageName) {

		$str = file_get_contents(ROOT."/public/img/json/".$imageName.".json");
		$res=json_decode($str, true);
		$res = $res[0];

		$data['title'] = $this->getTitle($res);
		$data['fileName'] = $this->getFileName($res);
		$data['keywords'] = $this->getKeywords($res);
		$data['description'] = $this->getDescription($res);
		$data['copyright'] = $this->getCopyright($res);
		$data['artist'] = $this->getArtist($res);
		$data['source'] = $this->getSource($res);
		$data['modifyDate'] = $this->getModifyDate($res);
		$data['dateCreated'] = $this->getDateCreated($res);
		$data['latitude'] = $this->getLatitude($res);
		$data['longitude'] = $this->getLongiude($res);
		$data['width'] = $this->getWidth($res);
		$data['height'] = $this->getHeight($res);
		
		return $data;
	}

	public function exifImage($name) {
		return shell_exec('exiftool -g1 img/'.$name.".jpg");
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


	function modifyMetadata($data) {
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
			$amodif['Description'][]='XMP-dc:Description';
		}
		if (count($amodif['Copyright'])==0) {
			$amodif['Copyright'][]='XMP-dc:Rights';
		}
		if (count($amodif['Artist'])==0) {
			$amodif['Artist'][]='XMP-dc:Creator';
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

		$listeParam.='img/'.$data['fileName'];
		shell_exec('exiftool '.$listeParam);

		foreach($amodif['keywords'] as $name) {
			shell_exec('exiftool -'.$name.'="" img/'.$imageName.'.jpg');
			shell_exec('exiftool -sep ", " -'.$name.'="'.$_POST['keywords'].'"  img/'.$data['fileName']);
		}
		shell_exec('exiftool -json -g1 img/'.$data['fileName'].'> img/json/'.str_replace(".jpg","",$data['fileName']).'.json');
		shell_exec('exiftool -json -XMP-dc:Title -XMP-dc:Creator -XMP-dc:Rights img/> img/json/home.json');
	}


	////////////////////////////////////////////////////////////
	//                 GETTERS & SETTERS
	////////////////////////////////////////////////////////////


	public function getTitle($data){
		return isset($data['XMP-dc']['Title']) ? $data['XMP-dc']['Title'] : null;
	}

	public function getLatitude($data) {
		if(isset($data['Composite']['GPSLatitude'])) {
			$latitude = explode(" ",$data['Composite']['GPSLatitude']);
			$latitude = $this->DMStoDEC($latitude[0],str_replace("'","",$latitude[2]),str_replace("\"","",$latitude[3]),$latitude[4]);
			return $latitude;
		}
		return 0;
	}

	public function getLongiude($data) {
		if(isset($data['Composite']['GPSLatitude'])) {
			$longitude = explode(" ",$data['Composite']['GPSLongitude']);
			$longitude = $this->DMStoDEC($longitude[0],str_replace("'","",$longitude[2]),str_replace("\"","",$longitude[3]),$longitude[4]);
			return $longitude;
		}
		return 0;
	}

	public function getDescription($data) {
		return (isset($data['IFD0']['ImageDescription'])) ? $data['IFD0']['ImageDescription']:
		(isset($data['XMP-dc']['Description'])) ? $data['XMP-dc']['Description']: null;
	}


	public function getCopyright($data) {
		return 
		isset($data['IFD0']['Copyright']) ? $data['IFD0']['Copyright']:
		(isset($data['XMP-dc']['Rights']) ? $data['XMP-dc']['Rights']: null);
	}

	public function getArtist($data) {
		return 
		isset($data['IPTC']['Artist']) ? $data['IPTC']['Artist']:
		(isset($data['XMP-dc']['Creator']) ? $data['XMP-dc']['Creator']: null);
	}

	public function getFileName($data) {
		return isset($data['System']['FileName']) ? $data['System']['FileName'] : null;
	}


	public function getSource($data) {
		return
		isset($data['IFD0']['Source']) ? $data['IFD0']['Source']:
		(isset($data['XMP-photoshop']['Source']) ? $data['XMP-photoshop']['Source']: null);
	}

	public function getModifyDate($data) {
		return
		isset($data['IFD0']['ModifyDate']) ? $data['IFD0']['ModifyDate']:
		(isset($data['System']['FileModifyDate']) ? $data['System']['FileModifyDate']: null);
	}

	public function getDateCreated($data) {
		return
		isset($data['IPTC']['DateCreated']) ? $data['IPTC']['DateCreated'] :
		(isset($data['ExifIFD']['CreateDate']) ? $data['ExifIFD']['CreateDate'] :
			(isset($data['XMP-xmp']['CreateDate']) ? $data['XMP-xmp']['CreateDate'] :
				(isset($data['Composite']['DateTimeCreated']) ? $data['Composite']['DateTimeCreated'] :
					(isset($data['XMP-photoshop']['DateCreated']) ? $data['XMP-photoshop']['DateCreated']: null))));
	}

	function getKeywords($data) {
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

	public function getWidth($data){
		return isset($data['File']['ImageWidth']) ? $data['File']['ImageWidth'] : 0;
	}

	public function getHeight($data){
		return isset($data['File']['ImageHeight']) ? $data['File']['ImageHeight'] : 0;
	}

	public function getSize($data){
		return isset($data['System']['FileSize']) ? $data['System']['FileSize'] : 0;
	}



}