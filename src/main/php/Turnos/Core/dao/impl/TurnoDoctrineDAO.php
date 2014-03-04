<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\model\Turno;
use Turnos\Core\model\Profesional;

use Turnos\Core\dao\ITurnoDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;
use Cose\exception\DAOException;

use Doctrine\ORM\QueryBuilder;
use Cose\utils\Logger;
/**
 * dto para Turno
 *  
 * @author bernardo
 *
 */
class TurnoDoctrineDAO extends CrudDAO implements ITurnoDAO{
	
	protected function getClazz(){
		return get_class( new Turno() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		//$queryBuilder->select('p')->from( $this->getClazz() , 'p');
		$queryBuilder->select(array('t', 'p', 'c', 'os'))
	   				->from( $this->getClazz(), "t")
					->leftJoin('t.profesional', 'p')
					->leftJoin('t.cliente', 'c')
					->leftJoin('t.obraSocial', 'os');
					
		return $queryBuilder;
	}
	
	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(t.oid)')
					->from( $this->getClazz() , 't')
					->leftJoin('t.profesional', 'p')
					->leftJoin('t.cliente', 'c')
					->leftJoin('t.obraSocial', 'os');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "t.oid <> $oid");
		}
		
		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "t.fecha = '" . $fecha->format("Y-m-d") . "'");
		}
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "t.fecha >= '" . $fechaDesde->format("Y-m-d") . "'");
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "t.fecha <= '" . $fechaHasta->format("Y-m-d") . "'");
		}
		
		$hora = $criteria->getHora();
		if( !empty($hora) ){
			
			$queryBuilder->andWhere( "t.hora = '" . $hora->format("H:i:s") . "'" );
			
		}
		
		$estado = $criteria->getEstadoTurno();
		if( !empty($estado) ){
			$queryBuilder->andWhere( "t.estado= " . $estado );
		}
		
		$estados = $criteria->getEstados();
		if( !empty($estados) && count( $estados>0) ){
			
			$strEstados = implode(",", $estados );
			
			$queryBuilder->andWhere( $queryBuilder->expr()->in("t.estado", $strEstados) );
		}
		
		$cliente = $criteria->getCliente();
		if( !empty($cliente) ){
			$queryBuilder->andWhere( "c.oid= " . $cliente->getOid() );
		}

		$profesional = $criteria->getProfesional();
		if( !empty($profesional) ){
			$queryBuilder->andWhere( "p.oid= " . $profesional->getOid() );
		}
		
	}
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "t.$name";	
		}	
		
	}
	
	public function getTurnosDelDia($fecha, Profesional $profesional=null){
	
		try {
			
			$qb = $this->getEntityManager()->createQueryBuilder();
			
			$qb->select(array('t', 'p', 'c', 'os'))
	   				->from( $this->getClazz(), "t")
					->leftJoin('t.profesional', 'p')
					->leftJoin('t.cliente', 'c')
					->leftJoin('t.obraSocial', 'os');
	   
			$qb->where( "t.fecha= :fecha " );
			
			if( $profesional!=null)
				$qb->andWhere( "p.oid= :oid ");
			
			$qb->orderby( "t.hora", "ASC" );
			
			$qb->setParameter( "fecha", $fecha->format("Y-m-d") );
			if( $profesional!=null)
				$qb->setParameter( "oid", $profesional->getOid() );
			
					
			$q = $qb->getQuery();
			
			$r = $q->getResult();
		
			//\Logger::getLogger(__CLASS__)->info("size: " . count($r) );
			
			return $r;
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
	
		
	}
	

	/**
	 * Retorna los turnos que están en estado "atendiendo"
	 * para la fecha dada, uno por profesional.
	 * Si un profesional tiene más de un turno es estado "atendiendo",
	 * retornará el último de ellos.
	 * 
	 * @param Datetime $fecha
	 * @throws DAOException
	 */
	public function getTurnosAtendiendo($fecha){
	
		try {
			
			$qb = $this->getEntityManager()->createQueryBuilder();
			
			$qb->select(array('t', 'p', 'c', 'os'))
	   				->from( $this->getClazz(), "t")
					->leftJoin('t.profesional', 'p')
					->leftJoin('t.cliente', 'c')
					->leftJoin('t.obraSocial', 'os');
	   
			$qb->where( "t.fecha= :fecha " );
			
			if( $profesional!=null)
				$qb->andWhere( "p.oid= :oid ");
			
			$qb->orderby( "t.hora", "ASC" );
			
			$qb->setParameter( "fecha", $fecha->format("Y-m-d") );
			
			$q = $qb->getQuery();
			
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