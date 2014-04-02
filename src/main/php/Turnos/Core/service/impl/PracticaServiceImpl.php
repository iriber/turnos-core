<?php
namespace Turnos\Core\service\impl;

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

		//$this->validateOnAdd( $entity );
			
		//si tiene obra social asignada, actualizamos la obra social del cliente.
		$cliente = $entity->getCliente();
		if( $cliente!= null && $cliente->getOid()>0 ){
		
			$os = $entity->getObraSocial();
			if( $os!= null && $os->getOid()>0){
				//chequeo la obra social que tiene el cliente actualmente.
				$cliente = DAOFactory::getClienteDAO()->get($cliente->getOid());
				$entity->setClienteObraSocial( $cliente->checkearObraSocial( $entity->getClienteObraSocial() ) );
				DAOFactory::getClienteDAO()->update( $cliente );
				$entity->setCliente($cliente);
				
			}else 
				$entity->getCliente()->setClienteObraSocial(null);
		}else{
			$entity->setClienteObraSocial(null);
		}
				
		//agregamos la práctica.
		parent::add($entity);
			
	}
	
	/**
	 * redefino el update para cambiar la obra social del
	 * cliente.
	 * @param $entity
	 * @throws ServiceException
	 */
	public function update($entity){

		//$this->validateOnUpdate( $entity );
			
		//si tiene obra social asignada, actualizamos la obra social del cliente.
		$cliente = $entity->getCliente();
		if( $cliente!= null && $cliente->getOid()>0 ){
		
			$os = $entity->getObraSocial();
			if( $os!= null && $os->getOid()>0){
				//chequeo la obra social que tiene el cliente actualmente.
				$cliente = DAOFactory::getClienteDAO()->get($cliente->getOid());
				$entity->setClienteObraSocial( $cliente->checkearObraSocial( $entity->getClienteObraSocial() ) );
				DAOFactory::getClienteDAO()->update( $cliente );
				$entity->setCliente($cliente);
				
			}else 
				$entity->getCliente()->setClienteObraSocial(null);
		}else{
			$entity->setClienteObraSocial(null);
		}
				
		//modificamos la práctica.
		parent::update($entity);
			
	}
}