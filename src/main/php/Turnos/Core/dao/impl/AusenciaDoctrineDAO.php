<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\model\Ausencia;
use Turnos\Core\model\Profesional;

use Turnos\Core\dao\IAusenciaDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dto para Ausencia
 *  
 * @author bernardo
 *
 */
class AusenciaDoctrineDAO extends CrudDAO implements IAusenciaDAO{
	
	protected function getClazz(){
		return get_class( new Ausencia() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('a', 'p'))
	   				->from( $this->getClazz(), "a")
					->leftJoin('a.profesional', 'p');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(a.oid)')
	   				->from( $this->getClazz(), "a")
					->leftJoin('a.profesional', 'p');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "a.oid <> $oid");
		}
		
		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			
			//que fechaDesde & fechaHasta no son nulas y fechaDesde<=fecha<=fechaHasta 
			//OR
			//que fechaHasta es nula y fechaDesde=fecha 
			$strFecha = $fecha->format("Y-m-d");
			
			$fechaMas = new \Datetime();
			//que fechaDesde & fechaHasta no son nulas y fechaDesde<=fecha<fechaHasta 
			$queryBuilder->andWhere( 
				$queryBuilder->expr()->orX(

						$queryBuilder->expr()->andX(
								$queryBuilder->expr()->andX($queryBuilder->expr()->isNotNull('a.fechaDesde'),$queryBuilder->expr()->isNotNull('a.fechaHasta')),
								
								
								$queryBuilder->expr()->andX(
									$queryBuilder->expr()->lte('a.fechaDesde', "'$strFecha'"),
									$queryBuilder->expr()->gte('a.fechaHasta', "'$strFecha'")
								))
								
       					,
       					$queryBuilder->expr()->andX(
								$queryBuilder->expr()->isNull('a.fechaHasta'),
								$queryBuilder->expr()->eq('a.fechaDesde', "'$strFecha'" )
								)
       					)
   				);
			
			
			
		}

		
		$fechaVigencia = $criteria->getFechaVigencia();
		if( !empty($fechaVigencia) ){
			
			//que fechaDesde >= fechaVigencia 
			//OR
			//que fechaHasta no es nula y fechaHasta<=fechaVigencia
			 
			$strFecha = $fechaVigencia->format("Y-m-d");
			$queryBuilder->andWhere( 
				$queryBuilder->expr()->orX(

						$queryBuilder->expr()->gte('a.fechaDesde', "'$strFecha'")								
       					,
       					$queryBuilder->expr()->andX(
								$queryBuilder->expr()->isNotNull('a.fechaHasta'),
								$queryBuilder->expr()->lte('a.fechaHasta', "'$strFecha'" )
								)
       					)
   				);
			
			
			//que fechaHasta es nula y fechaDesde=fecha 
			$queryBuilder->andWhere( 
				$queryBuilder->expr()->orX(
       					$queryBuilder->expr()->isNull('a.fechaHasta'),
       					$queryBuilder->expr()->gte('a.fechaHasta', "'$strFecha'" )
   				)
			);
		}
		
		$fechaVigenciaDesde = $criteria->getFechaVigenciaDesde();
		$fechaVigenciaHasta = $criteria->getFechaVigenciaHasta();
		if( !empty($fechaVigenciaDesde) && !empty($fechaVigenciaHasta) ){
		
		}
		
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "a.fechaDesde = '" . $fechaDesde->format("Y-m-d") . "'");
		}
		
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "a.fechaHasta = '" . $fechaHasta->format("Y-m-d") . "'");
		}
		
		if( !empty($profesional) && $profesional!=null){
			$profesionalOid = $profesional->getOid();
			if(!empty($profesionalOid))
				$queryBuilder->andWhere( "p.oid= $profesionalOid" );
		}
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "f.$name";	
		}	
		
	}	
}