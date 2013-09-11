<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\INomencladorService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;

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
	
		//TODO que no se repita el código.
	
	}
	
	function validateOnUpdate( $entity ){}
	
	function validateOnDelete( $oid ){}
	
	
}