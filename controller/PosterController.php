<?php

require_once WWW_ROOT . 'controller'. DS .'AppController.php';

class PosterController extends AppController{


	public function __construct(){

		require_once WWW_ROOT . 'dao' .DS. 'PosterDAO.php';

		$this->posterDAO = new PosterDAO();
	}

	public function creator(){

		$date = date("Y/m/d");
		$color = 0;
		$message = "";

		if(isset($_GET["name"])){
			$name = $_GET["name"];
			$poster = $this->posterDAO->getPosterByName($name);
			if(!empty($poster)){
				$date = $poster["date"];
				$color = $poster["color"];
				$message = $poster["message"];
			}else{
				header("Location: ?page=creator");
			}
		}

		$this->set("date",$date);
		$this->set("color",$color);
		$this->set("message",$message);
	}

	function upload(){

		$upload_dir = "upload/";
		$uploadOk = 1;
		$name = "";
		$date = "";
		$color = "";
		$message = "";
		$email = "";

		if(!empty($_POST)) {

				if(!empty($_POST["date"])){
					$date = $_POST["date"];
				}else{
					$uploadOk = 0;
				}
				if(!empty($_POST["color"])){
					$color = $_POST["color"];
				}else{
					$uploadOk = 0;
				}
				if(!empty($_POST["message"])){
					$message = $_POST["message"];
				}
				if(!empty($_POST["email"])){
					$email = $_POST["email"];
				}
				
				if($uploadOk == 1){
					$name = uniqid();
					$poster = array();
					if(isset($_GET["name"])){
						$poster = $this->posterDAO->getPosterByName($_GET["name"]);
					}

					if(empty($poster)){
						$uploadOk = $this->posterDAO->addPoster($name,$date,$message,$color);
					}else{
						$name = $poster["name"];
						$uploadOk = $this->posterDAO->updatePoster($name,$date,$message,$color);
					}
					$img = $_POST['hidden_data'];
					$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$data = base64_decode($img);
					$file = $upload_dir . $name . ".png";
					$success = file_put_contents($file, $data);
					print $success ? $name : 'Unable to save the file.';
				}
		}
		exit();
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
