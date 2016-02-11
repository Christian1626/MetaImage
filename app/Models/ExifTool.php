<?php
namespace App\Models;

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

	public function exifKeyword($name,$keywords,$filename) {
		shell_exec('exiftool -'.$name.'="" img/'.$filename);
		shell_exec('exiftool -sep ", " -'.$name.'="'.$keywords.'"  img/'.$filename);
	}


	public function modifyJSON($filename) {
		shell_exec('exiftool -json -g1 img/'.$filename.'> img/json/'.str_replace(".jpg","",$filename).'.json');
	}

	public function replaceOriginal($listeParam) {
		shell_exec('exiftool -overwrite_original '.$listeParam);
	}
}
