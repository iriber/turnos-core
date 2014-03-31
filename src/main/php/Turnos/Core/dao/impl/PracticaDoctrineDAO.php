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
						->leftJoin('p.obraSocial', 'os')
						->leftJoin('p.cliente', 'c')
						->leftJoin('p.nomenclador', 'n')
						->leftJoin('p.profesional', 'prof');
		
		
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(p.oid)')->from( $this->getClazz() , 'p')
						->leftJoin('p.obraSocial', 'os')
						->leftJoin('p.cliente', 'c')
						->leftJoin('p.nomenclador', 'n')
						->leftJoin('p.profesional', 'prof');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$cliente = $criteria->getCliente();
		if( !empty($cliente) ){
			$queryBuilder->where( "c.oid= " . $cliente->getOid() );
		}
		
		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "p.fecha = '" . $fecha->format("Y-m-d") . "'");
		}
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "p.fecha >= '" . $fechaDesde->format("Y-m-d") . "'");
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "p.fecha <= '" . $fechaHasta->format("Y-m-d") . "'");
		}
		
		$profesional = $criteria->getProfesional();
		if( !empty($profesional) ){
			$queryBuilder->andWhere( "prof.oid= " . $profesional->getOid() );
		}
		
		$obraSocial = $criteria->getObraSocial();
		if( !empty($profesional) ){
			$queryBuilder->andWhere( "os.oid= " . $obraSocial->getOid() );
		}
		
		$nomenclador = $criteria->getNomenclador();
		if( !empty($nomenclador) ){
			$queryBuilder->andWhere( "n.oid= " . $nomenclador->getOid() );
		}
		
		$queryBuilder->orderBy('p.fecha', 'DESC');
	}	
}