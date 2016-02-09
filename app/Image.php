<?php
require 'Json.php';
require 'ExifTool.php';

class Image {
	public $title;
	public $fileName;
	public $keywords;
	public $description;
	public $copyright;
	public $artist;
	public $source;
	public $modifyDate;
	public $dateCreated;
	public $latitude;
	public $longitude;
	public $width;
	public $height;

	public function __construct($name) {
		$this->json = new Json();
		$this->exif = new ExifTool();

		//récupère les info de l'image dans le fichir json
		$this->data = $this->json->getImage($name);

		$this->title = $this->getTitle();
		$this->fileName = $this->getFileName();
		$this->keywords = $this->getKeywords();
		$this->description = $this->getDescription();
		$this->copyright = $this->getCopyright();
		$this->artist = $this->getArtist();
		$this->source = $this->getSource();
		$this->modifyDate = $this->getModifyDate();
		$this->dateCreated = $this->getDateCreated();
		$this->latitude = $this->getLatitude();
		$this->longitude = $this->getLongiude();
		$this->width = $this->getWidth();
		$this->height = $this->getHeight();
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


	function modifyMetadata() {
		//Pour contrôler les champs identiques, mettre des hiddens dans le formulaire avec les anciennes valeurs des champs
		$amodif=array('Title' =>array(),'Description' =>array(),'Copyright' =>array(),'Artist' =>array(),'Keywords' =>array());

		if (count(explode(',', addcslashes(str_replace(', ', ',', $_POST['old_keywords']), '"')))==1) {
			$arraykw=$_POST['old_keywords'];
		} else {
			$arraykw=explode(',', addcslashes(str_replace(', ', ',', $_POST['old_keywords']), '"'));
		}

		foreach (array_slice($this->data, 2) as $key => $type) {
			foreach ($type as $name => $valeur) {
				if($valeur===$_POST['old_title_photo']) {
					$amodif['Title'][]=$key.":".$name;
				}
				if(str_replace("\n","",(str_replace("\r","",$valeur)))===str_replace("\n","",(str_replace("\r","",$_POST['old_ImageDescription'])))) {
					$amodif['Description'][]=$key.":".$name;
				}
				if($valeur===$arraykw) {
					$amodif['Keywords'][]=$key.":".$name;
				}
				if($valeur===$_POST['old_copyright']) {
					$amodif['Copyright'][]=$key.":".$name;
				}
				if($valeur===$_POST['old_artist']) {
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
		if (count($amodif['Keywords'])==0) {
			$amodif['Keywords'][]='IPTC:Keywords';
		}
		foreach($amodif['Title'] as $name) {
			if ($name=="XMP-dc:Title" || $name=="IPTC:Headline" || $name=="IPTC:ObjectName" || $name=="XMP-photoshop:Headline") {
				$listeParam.='-'.$name.'="'.addcslashes($_POST['title_photo'], '"').'" ';
			}
		}
		foreach($amodif['Description'] as $name) {
			if ($name=="IFD0:ImageDescription" || $name=="XMP-dc:Description" || $name=="IPTC:Caption-Abstract") {
				$listeParam.='-'.$name.'="'.addcslashes($_POST['ImageDescription'], '"').'" ';
			}
		}
		foreach($amodif['Copyright'] as $name) {
			if ($name=="IFD0:Copyright" || $name=="XMP-dc:Rights" || $name=="IPTC:CopyrightNotice") {
				$listeParam.='-'.$name.'="'.addcslashes($_POST['copyright'], '"').'" ';
			}
		}
		foreach($amodif['Artist'] as $name) {
			if ($name=="IFD0:Artist" || $name=="XMP-dc:Creator" || $name=="IPTC:By-line") {
				$listeParam.='-'.$name.'="'.addcslashes($_POST['artist'], '"').'" ';
			}
		}
		$listeParam.=ROOT.'/public/img/'.$this->fileName;
		shell_exec('exiftool '.$listeParam);

		foreach($amodif['Keywords'] as $name) {
			if ($name=="IPTC:Keywords" || $name=="XMP-dc:Subject") {
				$this->exif->exifKeyword($name,$_POST['keywords'],$this->fileName);
			}
		}
		$this->exif->modify($this->fileName);
		$this->exif->refreshHomeJSON();

	}


	////////////////////////////////////////////////////////////
	//                 GETTERS & SETTERS
	////////////////////////////////////////////////////////////


	public function getTitle(){
		return isset($this->data['XMP-dc']['Title']) ? $this->data['XMP-dc']['Title']:
		(isset($this->data['IPTC']['Headline']) ? $this->data['IPTC']['Headline']:
			(isset($this->data['IPTC']['ObjectName']) ? $this->data['IPTC']['ObjectName']:
				(isset($this->data['XMP-photoshop']['Headline']) ? $this->data['XMP-photoshop']['Headline']: null)));
	}

	public function getLatitude() {
		if(isset($this->data['Composite']['GPSLatitude'])) {
			$latitude = explode(" ",$this->data['Composite']['GPSLatitude']);
			$latitude = $this->DMStoDEC($latitude[0],str_replace("'","",$latitude[2]),str_replace("\"","",$latitude[3]),$latitude[4]);
			return $latitude;
		}
		return 0;
	}

	public function getLongiude() {
		if(isset($this->data['Composite']['GPSLatitude'])) {
			$longitude = explode(" ",$this->data['Composite']['GPSLongitude']);
			$longitude = $this->DMStoDEC($longitude[0],str_replace("'","",$longitude[2]),str_replace("\"","",$longitude[3]),$longitude[4]);
			return $longitude;
		}
		return 0;
	}

	public function getDescription() {
		return ((isset($this->data['XMP-dc']['Description']) ? $this->data['XMP-dc']['Description']:
		(isset($this->data['IFD0']['ImageDescription'])) ? $this->data['IFD0']['ImageDescription']:
			(isset($this->data['IPTC']['Caption-Abstract']) ? $this->data['IPTC']['Caption-Abstract']: null)));
	}


	public function getCopyright() {
		return isset($this->data['IFD0']['Copyright']) ? $this->data['IFD0']['Copyright']:
		(isset($this->data['XMP-dc']['Rights']) ? $this->data['XMP-dc']['Rights']:
			(isset($this->data['IPTC']['CopyrightNotice']) ? $this->data['IPTC']['CopyrightNotice']: null));
	}

	public function getArtist() {
		return
		isset($this->data['IFD0']['Artist']) ? $this->data['IFD0']['Artist']:
		(isset($this->data['XMP-dc']['Creator']) ? $this->data['XMP-dc']['Creator']:
			(isset($this->data['IPTC']['By-line']) ? $this->data['IPTC']['By-line']: null));
	}

	public function getFileName() {
		return isset($this->data['System']['FileName']) ? $this->data['System']['FileName'] : null;
	}


	public function getSource() {
		return
		isset($this->data['IFD0']['Source']) ? $this->data['IFD0']['Source']:
		(isset($this->data['XMP-photoshop']['Source']) ? $this->data['XMP-photoshop']['Source']: null);
	}

	public function getModifyDate() {
		return
		isset($this->data['IFD0']['ModifyDate']) ? $this->data['IFD0']['ModifyDate']:
		(isset($this->data['System']['FileModifyDate']) ? $this->data['System']['FileModifyDate']: null);
	}

	public function getDateCreated() {
		return
		isset($this->data['IPTC']['DateCreated']) ? $this->data['IPTC']['DateCreated'] :
		(isset($this->data['ExifIFD']['CreateDate']) ? $this->data['ExifIFD']['CreateDate'] :
			(isset($this->data['XMP-xmp']['CreateDate']) ? $this->data['XMP-xmp']['CreateDate'] :
				(isset($this->data['Composite']['DateTimeCreated']) ? $this->data['Composite']['DateTimeCreated'] :
					(isset($this->data['XMP-photoshop']['DateCreated']) ? $this->data['XMP-photoshop']['DateCreated']: null))));
	}

	function getKeywords() {
		$listeKW = "";
		if (isset($this->data['IPTC']['Keywords'])) {
			if (is_array($this->data['IPTC']['Keywords'])){
				foreach($this->data['IPTC']['Keywords'] as $value ) {
					if($listeKW == "") {
						$listeKW = $listeKW . $value ;
					}
					else {
						$listeKW = $listeKW . ', '.  $value ;
					}
				}
			}else{
				$listeKW=$this->data['IPTC']['Keywords'];
			}
		}
		return $listeKW;
	}

	public function getWidth(){
		return isset($this->data['File']['ImageWidth']) ? $this->data['File']['ImageWidth'] : 0;
	}

	public function getHeight(){
		return isset($this->data['File']['ImageHeight']) ? $this->data['File']['ImageHeight'] : 0;
	}

	public function getSize(){
		return isset($this->data['System']['FileSize']) ? $this->data['System']['FileSize'] : 0;
	}



}
