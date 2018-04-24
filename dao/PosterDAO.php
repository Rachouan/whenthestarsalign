<?php

require_once WWW_ROOT .'classes'. DS . 'DatabasePDO.php';

class PosterDAO
{
	public $pdo;

	public function __construct(){

		$this->pdo = DatabasePDO::getInstance();

	}


	public function getPosterByName($name){

		$sql = 'SELECT p.*, pi.*,c.Color,cn.Name as category_name
						FROM Places AS p
						LEFT OUTER JOIN Place_Info AS pi
						ON pi.Place_id = p.Place_id AND pi.Lang = :lang
						LEFT OUTER JOIN categories AS c
						ON p.Category = c.Category_id
						LEFT OUTER JOIN Category_Name AS cn
						ON cn.Category_id = c.Category_id
						WHERE pi.Place_id = :placeid
						GROUP BY p.Place_id';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':lang',$lang);
		$stmt->bindValue(':placeid',$placeid);

		if($stmt->execute()){

			$place = $stmt->fetch(PDO::FETCH_ASSOC);

			if(!empty($place)){

				return $place;
			}

		}
		return array();

	}

	public function addTrip($name,$date,$message,$color){


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
	/*
	public function updateTrip($trip_id,$title,$adres,$tel,$mail,$web,$lat,$long,$status,$edit_date,$type,$tags,$image){


		$sql = "UPDATE `trip` SET `title` = :title ,`adres` = :adres ,`tel` = :tel ,`image` = :image,`mail` = :mail ,`website` = :web ,`lat` = :lat ,`long` = :long ,`status` = :status ,`edit_date` = :edit_date,`type` = :type,`tags` = :tags   WHERE `trip_id` = :trip_id;";
    $stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(":trip_id",$trip_id);
    $stmt->bindValue(":title",$title);
    $stmt->bindValue(":adres",$adres);
    $stmt->bindValue(":tel",$tel);
    $stmt->bindValue(":mail",$mail);
		$stmt->bindValue(":web",$web);
		$stmt->bindValue(":image",$image);
    $stmt->bindValue(":lat",$lat);
    $stmt->bindValue(":long",$long);
    $stmt->bindValue(":status",$status);
		$stmt->bindValue(":edit_date",$edit_date);
		$stmt->bindValue(":type",$type);
    $stmt->bindValue(":tags",$tags);

    if($stmt->execute()){

        return true;
    }
    return false;
	}*/

}
