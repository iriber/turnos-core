<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\criteria\NomencladorCriteria;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\INomencladorService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\utils\Logger;
use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;

/**
 * servicio para Nomenclador
 *  
 * @author bernardo
 *
 */
class NomencladorServiceImpl extends CrudService implements INomencladorService {
	
	protected function getDAO(){
		return DAOFactory::getNomencladorDAO();
	}
	
	function validateOnAdd( $entity ){
	
		//que tenga nombre
		$nombre = $entity->getNombre();
		if( empty($nombre) )
			throw new ServiceException("nomenclador.nombre.required");

		//que tenga código
		$codigo = $entity->getCodigo();
		if( empty($codigo) )
			throw new ServiceException("nomenclador.codigo.required");
			
		//que no exista otro con mismo nombre
		if( $this->existsByNombre($nombre) )
		
			throw new DuplicatedEntityException("nomenclador.nombre.unicity");
			
		//que no exista otro con mismo código
		if( $this->existsByCodigo($codigo) )
		
			throw new DuplicatedEntityException("nomenclador.codigo.unicity");
		
	
	}
	
	function validateOnUpdate( $entity ){
	
		$this->validateOnAdd($entity);
	}
	
	function validateOnDelete( $oid ){}
	
	/**
	 * Retorna true si existe un nomenclador dado un nombre 
	 * @param string $nombre
	 */
	private function existsByNombre( $nombre, $oid=null ){
	
		$criteria = new NomencladorCriteria();
		$criteria->setNombreEqual($nombre);
		$criteria->setOidNotEqual($oid);
	
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
	private function existsByCodigo( $codigo, $oid=null ){
	
		$criteria = new NomencladorCriteria();
		$criteria->setCodigo($codigo);
		$criteria->setOidNotEqual($oid);
	
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