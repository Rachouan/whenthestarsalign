<?php

require_once WWW_ROOT .'classes'. DS . 'DatabasePDO.php';

class PlacesDAO
{
	public $pdo;

	public function __construct(){

		$this->pdo = DatabasePDO::getInstance();

	}


	public function getPlaces(){

		$sql = 'SELECT * FROM places ORDER BY Nr DESC';
		$stmt = $this->pdo->prepare($sql);

		if($stmt->execute()){

			$trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if(!empty($trips)){

				return $trips;
			}

		}
		return array();
	}

    public function getPlacesByFilter($name,$category,$lang){

				$sql = 'SELECT p.*, pi.*,c.Color,cn.Name as category_name
								FROM Places AS p
								LEFT OUTER JOIN Place_Info AS pi
								ON pi.Place_id = p.Place_id AND pi.Lang = :lang
								LEFT OUTER JOIN categories AS c
								ON p.Category = c.Category_id
								LEFT OUTER JOIN Category_Name AS cn
								ON cn.Category_id = c.Category_id
								WHERE pi.Name Like :name
								GROUP BY p.Place_id
								ORDER BY p.Nr ASC';
        $stmt = $this->pdo->prepare($sql);
				$stmt->bindValue(':name',"%".$name."%");
        //$stmt->bindValue(':category',$category);
        $stmt->bindValue(':lang',$lang);

		if($stmt->execute()){

			$trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if(!empty($trips)){

				return $trips;
			}

		}
		return array();

    }

	public function getPlaceById($placeid,$lang){

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

	/*public function addTrip($title,$adres,$tel,$mail,$web,$lat,$long,$status,$edit_date,$type,$tags,$image){


		$sql = "INSERT INTO `trip` (`title`,`adres`,`tel`,`mail`,`website`,`lat`,`image`,`long`,`status`,`edit_date`,`type`,`tags`) VALUES (:title,:adres,:tel,:mail,:web,:lat,:image,:long,:status,:edit_date,:type,:tags);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":title",$title);
        $stmt->bindValue(":adres",$adres);
        $stmt->bindValue(":tel",$tel);
        $stmt->bindValue(":mail",$mail);
				$stmt->bindValue(":web",$web);
        $stmt->bindValue(":lat",$lat);
        $stmt->bindValue(":long",$long);
				$stmt->bindValue(":image",$image);
        $stmt->bindValue(":status",$status);
				$stmt->bindValue(":edit_date",$edit_date);
				$stmt->bindValue(":type",$type);
        $stmt->bindValue(":tags",$tags);

        if($stmt->execute()){

            return true;
        }
        return false;
	}

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
	}

	public function removeTrip($trip_id){

		$sql ="DELETE FROM `trip` WHERE `trip_id` = :trip_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':trip_id',$trip_id);

		if($stmt->execute()){

			return true;
		}

		return false;
	}*/

}
