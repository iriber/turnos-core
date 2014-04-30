<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\criteria\PlanObraSocialCriteria;

use Turnos\Core\model\ObraSocial;

use Turnos\Core\service\IPlanObraSocialService;

use Turnos\Core\dao\DAOFactory;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\utils\Logger;
use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
/**
 * servicio para PlanObraSocial
 *  
 * @author bernardo
 * @since 24/04/2014
 *
 */
class PlanObraSocialServiceImpl extends CrudService implements IPlanObraSocialService {
	
	protected function getDAO(){
		return DAOFactory::getPlanObraSocialDAO();
	}
	
	function validateOnAdd( $entity ){
	
		//que tenga nombre
		$nombre = $entity->getNombre();
		if( empty($nombre) )
			throw new ServiceException("planObraSocial.nombre.required");

		//que tenga obrasocial
		$obraSocial = $entity->getObraSocial();
		if( empty($obraSocial) )
			throw new ServiceException("planObraSocial.obraSocial.required");
			
		//que no exista otro con mismo nombre para la misma obra social
		if( $this->existsByNombreObraSocial($nombre,$obraSocial) )
		
			throw new DuplicatedEntityException("planObraSocial.nombre.unicity");
			
	}
	
	function validateOnUpdate( $entity ){
	
		$this->validateOnAdd($entity);
	}
	
	function validateOnDelete( $oid ){
	
		//TODO que no esté asignado a ningún cliente.
	}

	
		
	/**
	 * Retorna true si existe un plan dado un nombre y obra social  
	 * @param string $nombre
	 * @param ObraSocial $obraSocial
	 * @param int $oid
	 */
	private function existsByNombreObraSocial( $nombre, ObraSocial $obraSocial, $oid=null ){
	
		$criteria = new PlanObraSocialCriteria();
		$criteria->setNombreEqual($nombre);
		$criteria->setOidNotEqual($oid);
		$criteria->setObraSocial($obraSocial);
	
		$exists = false;
		
		try{
			
			$os = $this->getSingleResult( $criteria );
			$exists = true;
			
		}catch (ServiceNonUniqueResultException $ex){
			Logger::log( $ex->getMessage(), __CLASS__ );
			$exists = true;
		
		}catch (ServiceException $ex){
			Logger::log( $ex->getMessage(), __CLASS__ );
			$exists = false;
		
		}catch (\Exception $ex){
			Logger::log( $ex->getMessage(), __CLASS__ );
			$exists = false;
		}
		return $exists;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Turnos/Core/service/Turnos\Core\service.IPlanObraSocialService::getPlanes()
	 */
	public function getPlanes( ObraSocial $obraSocial ){

		$criteria = new PlanObraSocialCriteria();
		$criteria->setObraSocial($obraSocial);
		$criteria->addOrder( "nombre", "ASC");
		return $this->getList( $criteria );
		
	}
	
	
}