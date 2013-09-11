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
}