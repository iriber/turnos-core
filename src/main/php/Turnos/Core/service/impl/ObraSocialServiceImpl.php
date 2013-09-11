<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\criteria\ObraSocialCriteria;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\IObraSocialService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\utils\Logger;
use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
/**
 * servicio para ObraSocial
 *  
 * @author bernardo
 *
 */
class ObraSocialServiceImpl extends CrudService implements IObraSocialService {
	
	protected function getDAO(){
		return DAOFactory::getObraSocialDAO();
	}
	
	function validateOnAdd( $entity ){
	
		//que tenga nombre
		$nombre = $entity->getNombre();
		if( empty($nombre) )
			throw new ServiceException("obraSocial.nombre.required");

		//que tenga código
		$codigo = $entity->getCodigo();
		if( empty($codigo) )
			throw new ServiceException("obraSocial.codigo.required");
			
		//que no exista otro con mismo nombre
		if( $this->existsByNombre($nombre) )
		
			throw new DuplicatedEntityException("obraSocial.nombre.unicity");
			
		//que no exista otro con mismo código
		if( $this->existsByCodigo($codigo) )
		
			throw new DuplicatedEntityException("obraSocial.codigo.unicity");
			
	}
	
	function validateOnUpdate( $entity ){}
	
	function validateOnDelete( $oid ){}

	
		
	/**
	 * Retorna true si existe una obra social dado un nombre 
	 * @param string $nombre
	 */
	private function existsByNombre( $nombre ){
	
		$criteria = new ObraSocialCriteria();
		$criteria->setNombreEqual($nombre);
	
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
	 * Retorna true si existe una obra social dado un código
	 * @param string $nombre
	 */
	private function existsByCodigo( $codigo ){
	
		$criteria = new ObraSocialCriteria();
		$criteria->setCodigo($codigo);
	
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
	
}