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

		if(!empty($_POST)) {

				if(isset($_POST["date"])){
					$date = $_POST["date"];
				}else{
					echo "DATE IS WRONG";
					$uploadOk = 0;
				}

				if(isset($_POST["color"])){
					$color = $_POST["color"];
				}else{
					echo "COLOR IS WRONG";
					$uploadOk = 0;
				}

				if(isset($_POST["message"])){
					$message = $_POST["message"];
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


}
