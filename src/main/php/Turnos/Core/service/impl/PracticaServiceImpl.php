<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\service\ServiceFactory;

use Turnos\Core\criteria\PracticaCriteria;

use Turnos\Core\model\Cliente;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\IPracticaService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;

/**
 * servicio para Practica
 *  
 * @author bernardo
 *
 */
class PracticaServiceImpl extends CrudService implements IPracticaService {
	
	protected function getDAO(){
		return DAOFactory::getPracticaDAO();
	}
	
	function validateOnAdd( $entity ){}
	
	function validateOnUpdate( $entity ){}
	
	function validateOnDelete( $oid ){}

	/**
	 * (non-PHPdoc)
	 * @see service/Turnos\Core\service.IPracticaService::getHistoriaClinica()
	 */
	function getHistoriaClinica( Cliente $cliente){
		
		$criteria = new PracticaCriteria();
		
		$criteria->setCliente($cliente);
		
		return $this->getList($criteria);

	}
	
	/**
	 * redefino el add para cambiar la obra social del
	 * cliente.
	 * @param $entity
	 * @throws ServiceException
	 */
	public function add($entity){

		$cosExistente = ServiceFactory::getClienteObraSocialService()->chequearObraSocial( $entity->getClienteObraSocial() );
		
		$entity->setClienteObraSocial( $cosExistente );
				
		//agregamos la práctica.
		parent::add($entity);

		//le asignamos al cliente la obra social indicada en la práctica.
		$cliente = $entity->getCliente();
		if( $cliente!= null && $cliente->getOid()>0 ){
		
			$entity->getClienteObraSocial()->setCliente($cliente);
			$cliente = DAOFactory::getClienteDAO()->get($cliente->getOid());
			$cliente->setClienteObraSocial($entity->getClienteObraSocial());
			DAOFactory::getClienteDAO()->update( $cliente );
			
		}
		
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
				
		//le asignamos al cliente la obra social indicada en la práctica.
		$cliente = $entity->getCliente();
		if( $cliente!= null && $cliente->getOid()>0 ){
		
			$entity->getClienteObraSocial()->setCliente($cliente);
			$cliente = DAOFactory::getClienteDAO()->get($cliente->getOid());
			$cliente->setClienteObraSocial($entity->getClienteObraSocial());
			DAOFactory::getClienteDAO()->update( $cliente );
			
		}
		
		//modificamos la práctica.
		parent::update($entity);
			
	}
}