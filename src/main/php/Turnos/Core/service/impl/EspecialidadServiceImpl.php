<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\criteria\EspecialidadCriteria;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\IEspecialidadService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;

/**
 * servicio para Especialidad
 *  
 * @author bernardo
 *
 */
class EspecialidadServiceImpl extends CrudService implements IEspecialidadService {
	
	protected function getDAO(){
		return DAOFactory::getEspecialidadDAO();
	}
	
	function validateOnAdd( $entity ){}
	
	function validateOnUpdate( $entity ){}
	
	function validateOnDelete( $oid ){}

	function getByNombre( $nombre ){
	
		$criteria = new EspecialidadCriteria();
		$criteria->setNombre($nombre);

		$especialidad = $this->getSingleResult( $criteria );
		
		return $especialidad;
	}
	
}