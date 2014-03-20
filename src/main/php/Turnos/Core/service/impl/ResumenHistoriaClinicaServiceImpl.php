<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\criteria\ResumenHistoriaClinicaCriteria;

use Turnos\Core\model\Cliente;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\IResumenHistoriaClinicaService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;

/**
 * servicio para ResumenHistoriaClinica
 *  
 * @author bernardo
 * @since 19/03/2014
 *
 */
class ResumenHistoriaClinicaServiceImpl extends CrudService implements IResumenHistoriaClinicaService {
	
	protected function getDAO(){
		return DAOFactory::getResumenHistoriaClinicaDAO();
	}
	
	function validateOnAdd( $entity ){}
	
	function validateOnUpdate( $entity ){}
	
	function validateOnDelete( $oid ){}

	/**
	 * (non-PHPdoc)
	 * @see service/Turnos\Core\service.IResumenHistoriaClinicaService::getResumenHistoriaClinica()
	 */
	function getResumenHistoriaClinica( Cliente $cliente){
		
		$criteria = new ResumenHistoriaClinicaCriteria();
		
		$criteria->setCliente($cliente);
		
		return $this->getList($criteria);

	}
}