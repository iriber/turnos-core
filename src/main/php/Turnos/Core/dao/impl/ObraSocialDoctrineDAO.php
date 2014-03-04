<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\model\ObraSocial;

use Turnos\Core\dao\IObraSocialDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;
use Doctrine\ORM\QueryBuilder;
/**
 * dto para ObraSocial
 *  
 * @author bernardo
 *
 */
class ObraSocialDoctrineDAO extends CrudDAO implements IObraSocialDAO{
	
	protected function getClazz(){
		return get_class( new ObraSocial() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('os')->from( $this->getClazz() , 'os');
		
		 
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(os.oid)')->from( $this->getClazz() , 'os');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
		
		
		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "os.oid <> $oid");
		}
		
		
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere("os.nombre like '%$nombre%'");
		}


		$nombreEq = $criteria->getNombreEqual();
		if( !empty($nombreEq) ){
			$queryBuilder->andWhere("os.nombre = '$nombreEq'");
		}
		
		$codigo = $criteria->getCodigo();
		if( !empty($codigo) ){
			$queryBuilder->andWhere("os.codigo = '$codigo'");
		}
	}

	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "os.$name";	
		}	
		
	}
}