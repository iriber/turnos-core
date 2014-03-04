<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\model\Especialidad;

use Turnos\Core\dao\IEspecialidadDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;
use Doctrine\ORM\QueryBuilder;
/**
 * DAO para Especialidad
 *  
 * @author bernardo
 *
 */
class EspecialidadDoctrineDAO extends CrudDAO implements IEspecialidadDAO{
	
	protected function getClazz(){
		return get_class( new Especialidad() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('e')->from( $this->getClazz() , 'e');
		
		 
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(e.oid)')->from( $this->getClazz() , 'e');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->where("e.nombre like '%$nombre%'");
		}
	}
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "e.$name";	
		}	
		
	}
}