<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\model\Localidad;

use Turnos\Core\dao\ILocalidadDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;
use Doctrine\ORM\QueryBuilder;
/**
 * dto para localidad
 *  
 * @author bernardo
 *
 */
class LocalidadDoctrineDAO extends CrudDAO implements ILocalidadDAO{
	
	protected function getClazz(){
		return get_class( new Localidad() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('l')->from( $this->getClazz() , 'l');
		
		 
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(l.oid)')->from( $this->getClazz() , 'l');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->where("l.nombre like '%$nombre%'");
		}
	}
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "l.$name";	
		}	
		
	}
}