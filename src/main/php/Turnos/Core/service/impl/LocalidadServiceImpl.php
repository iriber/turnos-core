<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\ILocalidadService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;

/**
 * servicio para localidad
 *  
 * @author bernardo
 *
 */
class LocalidadServiceImpl extends CrudService implements ILocalidadService {
	
	protected function getDAO(){
		return DAOFactory::getLocalidadDAO();
	}
	
	function validateOnAdd( $entity ){}
	
	function validateOnUpdate( $entity ){}
	
	function validateOnDelete( $oid ){}
	
	
}