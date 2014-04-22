<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\dao\IStatsDAO;

use Cose\persistence\PersistenceContext;
use Cose\persistence\PersistenceConfig;

use Cose\dao\impl\DoctrineDAO;

use Cose\criteria\ICriteria;
use Cose\exception\DAOException;

use Turnos\Core\model\Turno;

use Doctrine\ORM\QueryBuilder;
use Cose\utils\Logger;
/**
 * dto para Stats
 *  
 * @author bernardo
 *
 */
class StatsDoctrineDAO extends DoctrineDAO implements IStatsDAO{

	public function __construct( $unitName=""){
		
		if(empty($unitName))
			$unitName = PersistenceConfig::getDefaultUnit();
			
		parent::__construct( $unitName );
	}
	
	protected function getClazz(){}
	
	/**
	 * helper para la construcci�n de queries.
	 * 
	 * @param ICriteria criteria
	 * @return
	 */
	protected function getQueryBuilder(ICriteria $criteria){}

	/**
	 * helper para la construcción de queries.
	 * 
	 * @param ICriteria criteria
	 * @return
	 */
	protected function getQueryCountBuilder(ICriteria $criteria){}
	
	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	}
	
	public function getClientesPorMes($anio){
	
		try {
			$turnoClass = get_class( new Turno() );
			
			$emConfig = $this->getEntityManager()->getConfiguration();
    		$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
    		//$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
 
//	 	 	$qb = $this->createQueryBuilder('e')
//            ->select('e')
//            ->where("DAY(e.registeredAt) = :day")
//            ->andwhere("MONTH(e.registeredAt) = :month")
//            ->andwhere("YEAR(e.registeredAt) = :year");
     
     
			$q = $this->getEntityManager()->createQuery(
				"SELECT MONTH(t.fecha) as mes,
					COUNT(t.oid) as cantidad, SUM(t.importe) as importeTotal 
					FROM $turnoClass t 
					WHERE YEAR(t.fecha) = $anio
					GROUP BY mes");
			
			//WHERE SUBSTRING(t.fecha, 0, 4) = $anio
					
			$r = $q->getScalarResult();
		
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
			
			$qb->select(array('t', 'p', 'c', 'cos'))
	   				->from( $this->getClazz(), "t")
					->leftJoin('t.profesional', 'p')
					->leftJoin('t.cliente', 'c')
					->leftJoin('t.clienteObraSocial', 'cos');
					//->leftJoin('cos.obraSocial', 'os');
	   
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