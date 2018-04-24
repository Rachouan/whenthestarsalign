<?php

require_once WWW_ROOT . 'controller'. DS .'AppController.php';

class PosterController extends AppController{


	public function __construct(){

		require_once WWW_ROOT . 'dao' .DS. 'PosterDAO.php';

		$this->posterDAO = new PosterDAO();
	}

	public function creator(){

		$date = date("Y/m/d");
		$color = 1;
		$message = "This is a message";


		$this->set("date",$date);
		$this->set("color",$color);
		$this->set("message",$message);

	}
	/*public function map(){

		$content = "";
		if(!empty($_SESSION["content"])){
			$content = $_SESSION['content'];
		}else{
			header( "Location:".BASE_URL."index.php?page=map&lang=NL");
		}

		$lang = 1;
		$name = "";
		$category = "";

		if($_SESSION["language"] == "fr"){
			$lang = 2;
		}

		if(!empty($_GET["name"])){
			$name = $_GET["name"];
		}


		$places = $this->placesDAO->getPlacesByFilter($name,$category,$lang);
		$categories = $this->categoryDAO->getCategories($lang);

		$this->set("places",$places);
		$this->set("categories",$categories);
		$this->set("content",$content);

	}
	public function detail(){

		$content = "";
		if(!empty($_SESSION["content"])){
			$content = $_SESSION['content'];
		}else{
			exit();
		}

		$lang = 1;
		if($_SESSION["language"] == "fr"){
			$lang = 2;
		}
		$placeid = $_GET["id"];

		$place = $this->placesDAO->getPlaceById($placeid,$lang);
		$this->set("place",$place);
		$this->set("content",$content);
	}*/

}
