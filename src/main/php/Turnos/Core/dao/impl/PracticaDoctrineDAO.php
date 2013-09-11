<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\model\Practica;

use Turnos\Core\dao\IPracticaDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;
use Doctrine\ORM\QueryBuilder;
/**
 * dto para Practica
 *  
 * @author bernardo
 *
 */
class PracticaDoctrineDAO extends CrudDAO implements IPracticaDAO{
	
	protected function getClazz(){
		return get_class( new Practica() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('p', 'c'))
						->from( $this->getClazz() , 'p')
						->leftJoin('p.cliente', 'c');
		
		
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(p.oid)')->from( $this->getClazz() , 'p');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$cliente = $criteria->getCliente();
		if( !empty($cliente) ){
			$queryBuilder->where( "c.oid= " . $cliente->getOid() );
		}
		
		$queryBuilder->orderBy('p.fecha', 'DESC');
	}	
}