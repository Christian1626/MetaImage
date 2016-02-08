<?php
class ExifTool {
	public function getExifInfo($name) {
		return shell_exec('exiftool -g1 img/'.$name.".jpg");
	}

	public function createJSON($target,$filename) {
		shell_exec('exiftool -json -g1 '.$target.' > '.$filename);
	}

	public function refreshHomeJSON() {
		shell_exec('exiftool -json -XMP-dc:Title -XMP-dc:Creator -XMP-dc:Rights img/> img/json/home.json');
	}

	public function exifKeyword($name,$imageName,$keywords,$filename) {
		//TODO: Alban
		shell_exec('exiftool -'.$name.'="" img/'.$imageName.'.jpg');
		shell_exec('exiftool -sep ", " -'.$name.'="'.$keywords.'"  img/'.$fileName);
	}


	public function modify($filename) {
		shell_exec('exiftool -json -g1 img/'.$filename.'> img/json/'.str_replace(".jpg","",$filename).'.json');
	}
}