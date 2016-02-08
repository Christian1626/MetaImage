<?php

class Json {
	public function getAllImages() {
		$str = file_get_contents(ROOT."/public/img/json/home.json");
		return json_decode($str, true);
	}

	public function getImage($name) {
		$str = file_get_contents(ROOT."/public/img/json/".$name.".json");
		$img=json_decode($str, true);
		$img = $img[0];
		return $img;
	}
}