<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\dao\IPlanObraSocialDAO;

use Turnos\Core\model\PlanObraSocial;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Doctrine\ORM\QueryBuilder;

/**
 * dao para PlanObraSocial
 *  
 * @author bernardo
 * @since 24/4/2014
 */
class PlanObraSocialDoctrineDAO extends CrudDAO implements IPlanObraSocialDAO{
	
	protected function getClazz(){
		return get_class( new PlanObraSocial() );
	}
	
	
	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
		
		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "pos.oid <> $oid");
		}
		
		$obraSocial = $criteria->getObraSocial();
		if( !empty($obraSocial) ){
			$queryBuilder->andWhere( "os.oid= " . $obraSocial->getOid() );
		}
		
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere("pos.nombre like '%$nombre%'");
		}

		$nombreEq = $criteria->getNombreEqual();
		if( !empty($nombreEq) ){
			$queryBuilder->andWhere("pos.nombre = '$nombreEq'");
		}
				
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('pos')->from( $this->getClazz() , 'pos')
								->leftJoin('pos.obraSocial', 'os');
								
		return $queryBuilder;
	}
	
	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(pos.oid)')->from( $this->getClazz() , 'pos')
								->leftJoin('cos.obraSocial', 'os');
								
		return $queryBuilder;
	}
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "pos.$name";	
		}	
		
	}
}