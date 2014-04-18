<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\service\IStatsService;

use Turnos\Core\criteria\ClienteCriteria;

use Turnos\Core\model\TipoDocumento;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\IClienteService;

use Cose\service\impl\Service;

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

			$result = array(
			
				"1" => array("cantidad" => 2300, "importe" => 38000 ),
				"2" => array("cantidad" => 300, "importe" => 35030 ),
				"3" => array("cantidad" => 3300, "importe" => 33400 ),
				"4" => array("cantidad" => 5300, "importe" => 67450 ),
				"5" => array("cantidad" => 6000, "importe" => 75360 ),
				"6" => array("cantidad" => 4500, "importe" => 45600 ),
				"7" => array("cantidad" => 3560, "importe" => 6700 ),
				"8" => array("cantidad" => 2230, "importe" => 56600 ),
				"9" => array("cantidad" => 7630, "importe" => 98300 ),
				"10" => array("cantidad" => 2330, "importe" => 243000 ),
				"11" => array("cantidad" => 6230, "importe" => 138000 ),
				"12" => array("cantidad" => 9230, "importe" => 233000 ),
			
			);
			return $result;
			
		} catch (\Doctrine\ORM\NonUniqueResultException $e){

			return null;
			
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}	
	} 

	
}	