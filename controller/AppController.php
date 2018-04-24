<?php

class AppController {

	public $route = array();
	public $viewVars = array();
	public $languages = array("nl","fr");

	public function __construct() {

	}

	public function filter() {
		$this->language();
		$this->intro();
		call_user_func(array($this, $this->route['action']));
		$this->logout();
	}
	public function intro(){

		if(isset($_SESSION['intro'])){
			if($_SESSION['intro'] == false){
				$_SESSION['intro'] = true;
			}
		}else{
			$intro = false;
			$_SESSION['intro'] = $intro;
		}
	}
	public function language()
	{
		$reload = false;
		if(isset($_SESSION['language'])){
			$lang = $_SESSION['language'];
		}else{
			$lang = "nl";
			$_SESSION['language'] = $lang;
			$reload = true;
		}
		if(isset($_GET["lang"])) {
				$lang =  $_GET["lang"];
				$langCheck = false;
				foreach ($this->languages as $key => $value) {
					if($value == $lang){
						$langCheck = true;
					}
				}
				if($langCheck){
					$lang =  $_GET["lang"];
					$reload = true;
				}else{
					$lang =  $this->language[0];
				}
				$_SESSION['language'] = $lang;
		}

		$lang = $_SESSION['language'];
		$xml=simplexml_load_file("lang/".$lang.".xml") or die("Error: Cannot create object");
		$content = json_encode($xml);
		$_SESSION['content'] = json_decode($content,TRUE);

		if($reload){
			$this->redirect( "index.php?page=map" );
		}
	}

	public function render() {
		extract($this->viewVars, EXTR_OVERWRITE);
		require WWW_ROOT . 'parts/menu.php';
	    require WWW_ROOT . 'pages/' . strtolower($this->route['controller']) . DS . $this->route['action'] . '.php';
	    require WWW_ROOT . 'parts/footer.php';

		unset($_SESSION['errors']);
	}
	public function logout()
	{
		if(isset($_GET["action"]) && $_GET['action'] == 'logout'){

			unset($_SESSION['user']);
			header("location:?page=login");
		}
	}

	public function set($variableName, $value) {
		$this->viewVars[$variableName] = $value;
	}

	public function addError($error){
		if(!isset($_SESSION["errors"])) {
			$_SESSION["errors"] = array();
		}
		$_SESSION["errors"][] = $error;
	}

	public function redirect($url) {
		header("Location: {$url}");
		exit();
	}

}
