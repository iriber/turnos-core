<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\criteria\AusenciaCriteria;

use Turnos\Core\model\Ausencia;

use Turnos\Core\model\DiaSemana;

use Turnos\Core\criteria\HorarioCriteria;

use Turnos\Core\model\Profesional;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\IHorarioService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;

use Cose\exception\DAOException;
use Cose\exception\ServiceException;
/**
 * servicio para Horario
 *  
 * @author bernardo
 *
 */
class HorarioServiceImpl extends CrudService implements IHorarioService {
	
	protected function getDAO(){
		return DAOFactory::getHorarioDAO();
	}
	
	function validateOnAdd( $entity ){}
	
	function validateOnUpdate( $entity ){}
	
	function validateOnDelete( $oid ){}


	/**
	 * (non-PHPdoc)
	 * @see service/Turnos\Core\service.IHorarioService::getHorariosDelDia()
	 */
	function getHorariosDelDia( \DateTime $fecha, Profesional $profesional){
		
		//obtenemos el día de la semana dada la fecha.
        $dia = DiaSemana::getDia($fecha);
        
        try {
        	
        	return $this->getDAO()->getHorariosDelDia($dia, $profesional);
        	
        } catch (Exception $e) {
        	
        	throw new ServiceException( $e->getMessage() );
        	
        }

	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/Turnos\Core\service.IHorarioService::getHorariosDelProfesional()
	 */
	function getHorariosDelProfesional( Profesional $profesional){
		
        
        try {
        	
        	return $this->getDAO()->getHorariosDelProfesional( $profesional);
        	
        } catch (Exception $e) {
        	
        	throw new ServiceException( $e->getMessage() );
        	
        }

	}
}