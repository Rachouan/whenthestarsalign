<?php

require_once WWW_ROOT .'classes'. DS . 'DatabasePDO.php';

class CategoryDAO
{
	public $pdo;

	public function __construct(){

		$this->pdo = DatabasePDO::getInstance();

	}

  public function getCategories($lang){

				$sql = 'SELECT c.*,cn.Name as category_name
								FROM categories AS c
								LEFT OUTER JOIN Category_Name AS cn
								ON cn.Category_id = c.Category_id AND cn.Language = :lang
								GROUP BY c.Category_id
								ORDER BY c.Category_id ASC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':lang',$lang);

		if($stmt->execute()){

			$trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if(!empty($trips)){

				return $trips;
			}

		}
		return array();

    }

}
