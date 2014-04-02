<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\dao\IClienteObraSocialDAO;

use Turnos\Core\model\ClienteObraSocial;

use Turnos\Core\model\Cliente;

use Turnos\Core\dao\IClienteDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Doctrine\ORM\QueryBuilder;

/**
 * dao para ClienteObraSocial
 *  
 * @author bernardo
 *
 */
class ClienteObraSocialDoctrineDAO extends CrudDAO implements IClienteObraSocialDAO{
	
	protected function getClazz(){
		return get_class( new ClienteObraSocial() );
	}
	
	
	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
		
		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "cos.oid <> $oid");
		}
		
		$obraSocial = $criteria->getObraSocial();
		if( !empty($obraSocial) ){
			$queryBuilder->andWhere( "os.oid= " . $obraSocial->getOid() );
		}
		
		$cliente = $criteria->getCliente();
		if( !empty($cliente) ){
			$queryBuilder->andWhere( "c.oid= " . $cliente->getOid() );
		}
		
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('cos')->from( $this->getClazz() , 'cos')
								->leftJoin('cos.cliente', 'c')
								->leftJoin('cos.obraSocial', 'os');
								
		return $queryBuilder;
	}
	
	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(cos.oid)')->from( $this->getClazz() , 'cos')
								->leftJoin('cos.cliente', 'c')
								->leftJoin('cos.obraSocial', 'os');
								
		return $queryBuilder;
	}
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "cos.$name";	
		}	
		
	}
}