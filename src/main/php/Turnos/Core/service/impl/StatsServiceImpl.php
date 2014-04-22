<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\service\IStatsService;

use Turnos\Core\criteria\ClienteCriteria;

use Turnos\Core\model\TipoDocumento;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\IClienteService;

use Cose\service\impl\Service;
use Cose\exception\DAOException;

use Cose\Security\service\SecurityContext;
use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;

/**
 * servicio para stats
 *  
 * @author bernardo
 */
class StatsServiceImpl extends Service implements IStatsService {
	
	protected function getDAO(){
		return null;
	}
	
	public function getClientesPorMes($anio){
	
		try{

			//inicializamos el 
			$result = array(
			
//				"1" => array("cantidad" => 0, "importe" => 0 ),
//				"2" => array("cantidad" => 0, "importe" => 0 ),
//				"3" => array("cantidad" => 0, "importe" => 0 ),
//				"4" => array("cantidad" => 0, "importe" => 0 ),
//				"5" => array("cantidad" => 0, "importe" => 0 ),
//				"6" => array("cantidad" => 0, "importe" => 0 ),
//				"7" => array("cantidad" => 0, "importe" => 0 ),
//				"8" => array("cantidad" => 0, "importe" => 0 ),
//				"9" => array("cantidad" => 0, "importe" => 0 ),
//				"10" => array("cantidad" => 0, "importe" => 0 ),
//				"11" => array("cantidad" => 0, "importe" => 0 ),
//				"12" => array("cantidad" => 0, "importe" => 0 ),
			
			);
			
			$dao = DAOFactory::getStatsDAO();
			
			$resultDAO = $dao->getClientesPorMes($anio);

			foreach ($resultDAO as $next) {
				
				$result[ $next["mes"] ] = array("cantidad" => $next["cantidad"], "importe" => $next["importeTotal"] );
				
			}
			
			
			return $result;
			
		} catch (\Doctrine\ORM\NonUniqueResultException $e){

			return null;
			
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}	
	} 

	
}	