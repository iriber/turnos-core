<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\dao\IClienteObraSocialDAO;

use Turnos\Core\model\ClienteObraSocial;

use Turnos\Core\model\Cliente;
use Turnos\Core\model\ObraSocial;
use Turnos\Core\model\PlanObraSocial;
use Turnos\Core\dao\IClienteDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;
use Cose\exception\DAOException;

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

		$planObraSocial = $criteria->getPlanObraSocial();
		if( !empty($planObraSocial) ){
			$queryBuilder->andWhere( "pos.oid= " . $planObraSocial->getOid() );
		}
		
		$nroObraSocial = $criteria->getNroObraSocial();
		if( !empty($nroObraSocial) ){
			$queryBuilder->andWhere( "cos.nroObraSocial= '$nroObraSocial'" );
		}
		
		$tipoAfiliado = $criteria->getTipoAfiliado();
		if( !empty($tipoAfiliado) ){
			$queryBuilder->andWhere( "cos.tipoAfiliado= " . $tipoAfiliado );
		}
		
		$obraSocialNull = $criteria->getObraSocialNull();
		if( $obraSocialNull ){
			$queryBuilder->andWhere( "os.oid is null ");
		}
		
		$planObraSocialNull = $criteria->getPlanObraSocialNull();
		if( $planObraSocialNull ){
			$queryBuilder->andWhere( "pos.oid is null ");
		}
		
		$tipoAfiliadoNull = $criteria->getTipoAfiliadoNull();
		if( $tipoAfiliadoNull ){
			$queryBuilder->andWhere( "cos.tipoAfiliado is null ");
		}

		$nroObraSocialEmpty = $criteria->getNroObraSocialEmpty();
		if( $nroObraSocialEmpty ){
			$queryBuilder->andWhere( "cos.nroObraSocial = '' ");
		}
		
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('cos')->from( $this->getClazz() , 'cos')
								->leftJoin('cos.cliente', 'c')
								->leftJoin('cos.obraSocial', 'os')
								->leftJoin('cos.planObraSocial', 'pos');
								
		return $queryBuilder;
	}
	
	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(cos.oid)')->from( $this->getClazz() , 'cos')
								->leftJoin('cos.cliente', 'c')
								->leftJoin('cos.obraSocial', 'os')
								->leftJoin('cos.planObraSocial', 'pos');
								
		return $queryBuilder;
	}
	
	protected function getFieldName($name){
		
		$hash = array();
		$hash["obraSocial.nombre"] = "os.nombre";
		$hash["planObraSocial.nombre"] = "pos.nombre";
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "cos.$name";	
		}	
		
	}
	
	public function getByObraSocialPlan(Cliente $cliente,  ObraSocial $obraSocial=null, PlanObraSocial $planObraSocial=null, $nroObraSocial="", $tipoAfiliado=null ){
	
		try {
			
			$queryBuilder = $this->getEntityManager()->createQueryBuilder();
			
			$queryBuilder->select('cos')->from( $this->getClazz() , 'cos')
								->leftJoin('cos.cliente', 'c')
								->leftJoin('cos.obraSocial', 'os')
								->leftJoin('cos.planObraSocial', 'pos');
				   
			if( !empty($obraSocial) )
				$queryBuilder->andWhere( "os.oid= " . $obraSocial->getOid() );
			else
				$queryBuilder->andWhere( "cos.obraSocial is null ");
		
			$queryBuilder->andWhere( "c.oid= " . $cliente->getOid() );

			if( !empty($planObraSocial) )
				$queryBuilder->andWhere( "pos.oid= " . $planObraSocial->getOid() );
			else
				$queryBuilder->andWhere( "cos.planObraSocial is null " );
		
			$queryBuilder->andWhere( "cos.nroObraSocial= '$nroObraSocial'" );
		
		
			if( $tipoAfiliado!=null )
				$queryBuilder->andWhere( "cos.tipoAfiliado= " . $tipoAfiliado );
			else
				$queryBuilder->andWhere( "cos.tipoAfiliado is null " );
		
					
			$q = $queryBuilder->getQuery();
			
			$r = $q->getResult();
		
			//\Logger::getLogger(__CLASS__)->info("size: " . count($r) );
			
			return $r;
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
	
		
	}
}