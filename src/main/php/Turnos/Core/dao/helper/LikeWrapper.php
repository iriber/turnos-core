<?php 
namespace Turnos\Core\dao\helper;

use Doctrine\ORM\QueryBuilder;

class LikeWrapper{
	
	
	public static function wrapp(QueryBuilder $queryBuilder, $field, $value){
		
		$words = explode(" ", $value);
				
		if(count($words) > 1){
			$likes=array();
			foreach ($words as $word) {
				$queryBuilder->andWhere("$field like '%$word%'");
			}
			$likes = implode(" AND ", $likes);
		}else{
			$queryBuilder->andWhere("$field like '%$value%'");
		}

	}
	
}

?>