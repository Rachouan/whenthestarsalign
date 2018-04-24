<?php

require_once WWW_ROOT .'classes'. DS . 'DatabasePDO.php';

class PosterDAO
{
	public $pdo;

	public function __construct(){

		$this->pdo = DatabasePDO::getInstance();

	}


	public function getPosterByName($name){

		$sql = 'SELECT *
						FROM posters as p
						WHERE p.name = :name';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':name',$name);

		if($stmt->execute()){

			$poster = $stmt->fetch(PDO::FETCH_ASSOC);

			if(!empty($poster)){

				return $poster;
			}

		}
		return array();

	}

	public function addPoster($name,$date,$message,$color){


		$sql = "INSERT INTO `posters` (`name`,`date`,`message`,`color`) VALUES (:name,:datum,:message,:color);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":name",$name);
        $stmt->bindValue(":datum",$date);
        $stmt->bindValue(":message",$message);
        $stmt->bindValue(":color",$color);

        if($stmt->execute()){

            return true;
        }
        return false;
	}

	public function updatePoster($name,$date,$message,$color){

		$sql = "UPDATE `posters` SET `date` = :date ,`message` = :message ,`color` = :color  WHERE `name` = :name;";
    $stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":message",$message);
    $stmt->bindValue(":date",$date);
    $stmt->bindValue(":color",$color);
    $stmt->bindValue(":name",$name);

    if($stmt->execute()){

        return true;
    }
    return false;
	}

}
