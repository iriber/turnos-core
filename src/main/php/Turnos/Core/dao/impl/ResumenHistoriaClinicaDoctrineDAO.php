<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\model\ResumenHistoriaClinica;

use Turnos\Core\dao\IResumenHistoriaClinicaDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;
use Doctrine\ORM\QueryBuilder;
/**
 * dto para ResumenHistoriaClinica
 *  
 * @author bernardo
 * @since 19/03/2014
 *
 */
class ResumenHistoriaClinicaDoctrineDAO extends CrudDAO implements IResumenHistoriaClinicaDAO{
	
	protected function getClazz(){
		return get_class( new ResumenHistoriaClinica() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('r', 'c', 'prof'))
						->from( $this->getClazz() , 'r')
						->leftJoin('r.cliente', 'c')
						->leftJoin('r.profesional', 'prof');
		
		
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(r.oid)')->from( $this->getClazz() , 'r')
						->leftJoin('r.cliente', 'c')
						->leftJoin('r.profesional', 'prof');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$cliente = $criteria->getCliente();
		if( !empty($cliente) ){
			$queryBuilder->where( "c.oid= " . $cliente->getOid() );
		}
		
		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "r.fecha = '" . $fecha->format("Y-m-d") . "'");
		}
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "r.fecha >= '" . $fechaDesde->format("Y-m-d") . "'");
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "r.fecha <= '" . $fechaHasta->format("Y-m-d") . "'");
		}
		
		$profesional = $criteria->getProfesional();
		if( !empty($profesional) ){
			$queryBuilder->andWhere( "prof.oid= " . $profesional->getOid() );
		}
		
		$queryBuilder->orderBy('r.fecha', 'DESC');
	}	
}