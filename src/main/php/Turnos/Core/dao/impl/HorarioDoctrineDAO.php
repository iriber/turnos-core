<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\model\DiaSemana;

use Turnos\Core\model\Horario;
use Turnos\Core\model\Profesional;

use Turnos\Core\dao\IHorarioDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dto para Horario
 *  
 * @author bernardo
 *
 */
class HorarioDoctrineDAO extends CrudDAO implements IHorarioDAO{
	
	protected function getClazz(){
		return get_class( new Horario() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('h')->from( $this->getClazz() , 'h');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(h.oid)')->from( $this->getClazz() , 'h');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
	}	
	
	public function getHorariosDelDia($dia, Profesional $profesional){
	
		try {
			
			$qb = $this->getEntityManager()->createQueryBuilder();
			
			$qb->select(array('h', 'p'))
	   				->from( $this->getClazz(), "h")
					->leftJoin('h.profesional', 'p');
	   
			$qb->where( "p.oid= " . $profesional->getOid() );
			$qb->andWhere( "h.dia= $dia" );
			
			$q = $qb->getQuery();
			
			return $q->getResult();
		
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
		
	}	
	
	
	public function getHorariosDelProfesional(Profesional $profesional){
	
		try {
			
			$qb = $this->getEntityManager()->createQueryBuilder();
			
			$qb->select(array('h', 'p'))
	   				->from( $this->getClazz(), "h")
					->leftJoin('h.profesional', 'p');
	   
			$qb->where( "p.oid= " . $profesional->getOid() );
			
			$q = $qb->getQuery();
			
			return $q->getResult();
		
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
		
	}
	
}