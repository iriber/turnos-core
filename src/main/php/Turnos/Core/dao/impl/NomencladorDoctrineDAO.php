<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\model\Nomenclador;

use Turnos\Core\dao\INomencladorDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;
use Doctrine\ORM\QueryBuilder;
/**
 * dto para nomenclador
 *  
 * @author bernardo
 *
 */
class NomencladorDoctrineDAO extends CrudDAO implements INomencladorDAO{
	
	protected function getClazz(){
		return get_class( new Nomenclador() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
			$queryBuilder->select('n')->from( $this->getClazz() , 'n');
		
		 
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(n.oid)')->from( $this->getClazz() , 'n');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$codigo = $criteria->getCodigo();
		if( !empty($codigo) ){
			$queryBuilder->where("n.codigo = '$codigo'");
		}
		
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->where("n.nombre like '%$nombre%'");
		}
	}
	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "n.$name";	
		}	
		
	}	
}