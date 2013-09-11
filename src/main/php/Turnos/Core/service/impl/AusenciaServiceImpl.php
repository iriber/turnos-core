<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\criteria\AusenciaCriteria;

use Turnos\Core\model\Ausencia;

use Turnos\Core\model\Profesional;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\IAusenciaService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;

use Cose\exception\DAOException;
use Cose\exception\ServiceException;
/**
 * servicio para Ausencia
 *  
 * @author bernardo
 *
 */
class AusenciaServiceImpl extends CrudService implements IAusenciaService {
	
	protected function getDAO(){
		return DAOFactory::getAusenciaDAO();
	}
	
	function validateOnAdd( $entity ){}
	
	function validateOnUpdate( $entity ){}
	
	function validateOnDelete( $oid ){}

	/**
	 * (non-PHPdoc)
	 * @see service/Turnos\Core\service.IAusenciaService::getAusenciasDelDia()
	 */
	function getAusenciasDelDia( \DateTime $fecha, Profesional $profesional){
		
		$criteria = new AusenciaCriteria();
		$criteria->setFecha($fecha);
		$criteria->setProfesional($profesional);
		
		try {

        	return $this->getDAO()->getList( $criteria );
        	
        } catch (Exception $e) {
        	
        	throw new ServiceException( $e->getMessage() );
        	
        }
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/Turnos\Core\service.IAusenciaService::getAusenciasVigentes()
	 */
	function getAusenciasVigentes( \DateTime $fecha, Profesional $profesional){
		
		$criteria = new AusenciaCriteria();
		$criteria->setFechaVigencia($fecha);
		$criteria->setProfesional($profesional);
		
		try {

        	return $this->getDAO()->getList( $criteria );
        	
        } catch (Exception $e) {
        	
        	throw new ServiceException( $e->getMessage() );
        	
        }
	}
	
	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Turnos/Core/service/Turnos\Core\service.IAusenciaService::getAusenciasVigentesEnRango()
	 */
	function getAusenciasVigentesEnRango( \DateTime $fechaDesde, \DateTime $fechaHasta, Profesional $profesional){
		
		$criteria = new AusenciaCriteria();
		$criteria->setFechaVigenciaDesde($fechaDesde);
		$criteria->setFechaVigenciaHasta($fechaHasta);
		$criteria->setProfesional($profesional);
		
		try {

        	return $this->getDAO()->getList( $criteria );
        	
        } catch (Exception $e) {
        	
        	throw new ServiceException( $e->getMessage() );
        	
        }
	}
	
}