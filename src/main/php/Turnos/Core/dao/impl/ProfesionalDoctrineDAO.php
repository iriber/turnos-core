<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\model\Especialidad;

use Turnos\Core\model\Profesional;

use Turnos\Core\dao\IProfesionalDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\Security\model\User;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dto para Profesional
 *  
 * @author bernardo
 *
 */
class ProfesionalDoctrineDAO extends CrudDAO implements IProfesionalDAO{
	
	protected function getClazz(){
		return get_class( new Profesional() );
	}

	public function hasEspecialidad( Profesional $profesional, Especialidad $especialidad ){
	
		try {
			$qb = $this->getEntityManager()->createQueryBuilder();
			
			$qb->select(array('p'))
	   				->from( $this->getClazz(), "p")
					->leftJoin('p.especialidades', 'e');
	   
			$qb->where( "e.oid= '" . $especialidad->getOid() . "'");
			$qb->where( "p.oid= '" . $profesional->getOid() . "'");
			
			$q = $qb->getQuery();
			
			$r = $q->getSingleResult();
				
			return true;
			
		} catch(\Doctrine\ORM\NoResultException $e){
			
			return false;
			
		} catch (Exception $e) {
			throw new DAOException( $e->getMessage() );
		}
	}
	
	public function getProfesionalesByEspecialidad(Especialidad $especialidad){
		
		try {
			$qb = $this->getEntityManager()->createQueryBuilder();
			
			$qb->select(array('p'))
	   				->from( $this->getClazz(), "p")
					->innerJoin('p.especialidades', 'e', 'WITH',"e.oid= '" . $especialidad->getOid() . "'");
	   
			//$qb->where( "e.oid= '" . $especialidad->getOid() . "'");
			$qb->orderby( "p.nombre");
			
			$q = $qb->getQuery();
			
			return $q->getResult();
				
		} catch(\Doctrine\ORM\NoResultException $e){
			throw new DAOException( $e->getMessage() );
			
		} catch (Exception $e) {
			throw new DAOException( $e->getMessage() );
		}
	
	}
	
	public function getProfesionalByUser(User $user){
	
		try {
			$qb = $this->getEntityManager()->createQueryBuilder();
			
			$qb->select(array('p', 'u'))
	   				->from( $this->getClazz(), "p")
					->leftJoin('p.user', 'u');
	   
			$qb->where( "u.oid= '" . $user->getOid() . "'");
			
			$q = $qb->getQuery();
			
			return $q->getSingleResult();
				
		} catch(\Doctrine\ORM\NoResultException $e){
			throw new DAOException( $e->getMessage() );
			
		} catch (Exception $e) {
			throw new DAOException( $e->getMessage() );
		}
	
		
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('p')->from( $this->getClazz() , 'p');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(p.oid)')->from( $this->getClazz() , 'p');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere("p.nombre like '%$nombre%'");
		}
		
		$user = $criteria->getUser();
		if( !empty($user) ){
			$queryBuilder->andWhere( "p.user_oid= " . $user->getOid() );
		}
		
	}

	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "p.$name";	
		}	
		
	}	
}