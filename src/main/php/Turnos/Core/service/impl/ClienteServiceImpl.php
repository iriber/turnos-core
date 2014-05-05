<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\service\ServiceFactory;

use Turnos\Core\criteria\ClienteObraSocialCriteria;

use Turnos\Core\criteria\ClienteCriteria;

use Turnos\Core\model\TipoDocumento;
use Turnos\Core\model\Cliente;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\IClienteService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
use Cose\exception\DAOException;

/**
 * servicio para cliente
 *  
 * 
 * 
 * @author bernardo
 */
//@Cose\Security\annotation\Secured( permission='clientes' )
class ClienteServiceImpl extends CrudService implements IClienteService {

	/**
	 * redefino el add para cambiar la obra social del
	 * cliente.
	 * @param $entity
	 * @throws ServiceException
	 */
	public function add($entity){

		$cosExistente = ServiceFactory::getClienteObraSocialService()->chequearObraSocial( $entity->getClienteObraSocial() );
		
		$entity->setClienteObraSocial( $cosExistente );
				
		//agregamos el cliente.
		parent::add($entity);

	}
	
	/**
	 * redefino el update para cambiar la obra social del
	 * cliente.
	 * @param $entity
	 * @throws ServiceException
	 */
	public function update($entity){

		$cosExistente = ServiceFactory::getClienteObraSocialService()->chequearObraSocial( $entity->getClienteObraSocial() );
		
		$entity->setClienteObraSocial( $cosExistente );
				
		//modificamos el cliente.
		parent::update($entity);
			
	}	
	
	protected function getDAO(){
		return DAOFactory::getClienteDAO();
	}
	
	public function getByHistoriaClinica( $nroHistoriaClinica ){
	
		try{
		
			$criteria = new ClienteCriteria();
			$criteria->setNroHistoriaClinica($nroHistoriaClinica);
			
			return $this->getSingleResult( $criteria );
			
		} catch (\Doctrine\ORM\NonUniqueResultException $e){

			return null;
			
		} catch (\Doctrine\ORM\NoResultException $e){

			return null;
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}	
	} 
	
	function validateOnAdd( $entity ){
	
		//que tenga nombre
		$nombre = $entity->getNombre();
		if( empty($nombre) )
			throw new ServiceException("cliente.nombre.required");

		//si tiene tipo + nro documento, que no se repita.
		$tipoDocumento = $entity->getTipoDocumento();
		$nroDocumento = $entity->getNroDocumento();
		if( !empty($nroDocumento) ){
			
			if( $this->existsByDocumento($tipoDocumento, $nroDocumento, $entity->getOid()) )
				
				throw new DuplicatedEntityException("cliente.documento.unicity");
				
		}else{
			//si no tiene documento, que no exista otro con mismo nombre y sin documento.
			if( $this->existsByNombre($nombre,$tipoDocumento, $nroDocumento, $entity->getOid()) )
				
				throw new DuplicatedEntityException("cliente.nombre.unicity");
		}
		
		
		//que tenga nroHistoriaClinica
		$nroHC = $entity->getNroHistoriaClinica();
		if( empty($nroHC) )
			throw new ServiceException("cliente.nroHistoriaClinica.required");
		
		//unicidad de la historia clínica
		//if( $this->existsByHistoriaClinica($nroHC, $entity->getOid()) )
		//	throw new DuplicatedEntityException("cliente.nroHistoriaClinica.unicity");
	}
	
	/**
	 * Retorna true si existe un cliente dado un tipo y número de documento. 
	 * @param TipoDocumento $tipo
	 * @param string $numero
	 */
	private function existsByDocumento($tipo, $numero, $oid=null){
	
		$criteria = new ClienteCriteria();
		$criteria->setNroDocumento($numero);
		$criteria->setTipoDocumento($tipo);
		$criteria->setOidNotEqual($oid);
		
		$exists = false;
		
		try{
			
			$cliente = $this->getSingleResult( $criteria );
			$exists = true;
			
		}catch (ServiceNonUniqueResultException $ex){
			\Logger::getLogger(__CLASS__)->info( $ex->getMessage());
			$exists = true;
		
		}catch (ServiceException $ex){
			\Logger::getLogger(__CLASS__)->info( $ex->getMessage());
			$exists = false;
		
		}catch (\Exception $ex){
			\Logger::getLogger(__CLASS__)->info("error buscando por documento. " . $ex->getMessage());
			$exists = false;
		}
		return $exists;
	}
	
	/**
	 * Retorna true si existe un cliente dado un nombre pero
	 * que no tenga documento. 
	 * @param string $nombre
	 * @param TipoDocumento $tipo
	 * @param string $numero
	 */
	private function existsByNombre($nombre, $tipoDocumento, $nroDocumento, $oid=null){
	
		$criteria = new ClienteCriteria();
		$criteria->setNombreEqual($nombre);
		$criteria->setNroDocumento($nroDocumento);
		$criteria->setTipoDocumento($tipoDocumento);
		$criteria->setOidNotEqual($oid);
	
		$exists = false;
		
		try{
			
			$cliente = $this->getSingleResult( $criteria );
			
			\Logger::getLogger(__CLASS__)->info("cliente encontrado por nombre. ");
			
			$exists = true;
			
		}catch (ServiceNonUniqueResultException $ex){
			\Logger::getLogger(__CLASS__)->info( $ex->getMessage());
			$exists = true;
		
		}catch (ServiceException $ex){
			\Logger::getLogger(__CLASS__)->info( $ex->getMessage());
			$exists = false;
		
		}catch (\Exception $ex){
			\Logger::getLogger(__CLASS__)->info("error buscando por nombre. " . $ex->getMessage());
			$exists = false;
		}
		return $exists;
	}
	
	/**
	 * Retorna true si existe un cliente dado el número de historia clínica. 
	 * @param string $nroHistoriaClinica
	 * @param integer $oid
	 */
	private function existsByHistoriaClinica($nroHistoriaClinica, $oid=null){
	
		$criteria = new ClienteCriteria();
		$criteria->setNroHistoriaClinica($nroHistoriaClinica);
		$criteria->setOidNotEqual($oid);
		
		$exists = false;
		
		try{
			
			$cliente = $this->getSingleResult( $criteria );
			$exists = true;
			
		}catch (ServiceNonUniqueResultException $ex){
			\Logger::getLogger(__CLASS__)->info( $ex->getMessage());
			$exists = true;
		
		}catch (ServiceException $ex){
			\Logger::getLogger(__CLASS__)->info( $ex->getMessage());
			$exists = false;
		
		}catch (\Exception $ex){
			\Logger::getLogger(__CLASS__)->info("error buscando por historia clínica. " . $ex->getMessage());
			$exists = false;
		}
		return $exists;
	}
	
	function validateOnUpdate( $entity ){
	
		$this->validateOnAdd($entity);
	}
	
	function validateOnDelete( $oid ){}


}	