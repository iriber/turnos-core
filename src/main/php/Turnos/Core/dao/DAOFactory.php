<?php
namespace Turnos\Core\dao;

use Turnos\Core\dao\impl\EspecialidadDoctrineDAO;

use Turnos\Core\dao\impl\AusenciaDoctrineDAO;

use Turnos\Core\dao\impl\HorarioDoctrineDAO;

use Turnos\Core\dao\impl\TurnoDoctrineDAO;

use Turnos\Core\dao\impl\ProfesionalDoctrineDAO;

use Turnos\Core\dao\impl\PracticaDoctrineDAO;

use Turnos\Core\dao\impl\ObraSocialDoctrineDAO;

use Turnos\Core\dao\impl\NomencladorDoctrineDAO;

use Turnos\Core\dao\impl\LocalidadDoctrineDAO;

use Turnos\Core\dao\impl\ClienteDoctrineDAO;



/**
 * Factory de DAOs
 *  
 * @author bernardo
 *
 */
class DAOFactory {

	/**
	 * DAO para Ausencia.
	 * 
	 * @return IAusenciaDAO
	 */
	public static function getAusenciaDAO(){
	
		return new AusenciaDoctrineDAO();	
	}
	
	
	/**
	 * DAO para Cliente.
	 * 
	 * @return IClienteDAO
	 */
	public static function getClienteDAO(){
	
		return new ClienteDoctrineDAO();	
	}

	/**
	 * DAO para Horario.
	 * 
	 * @return IHorarioDAO
	 */
	public static function getHorarioDAO(){
	
		return new HorarioDoctrineDAO();	
	}
	
	/**
	 * DAO para Localidad.
	 * 
	 * @return ILocalidadDAO
	 */
	public static function getLocalidadDAO(){
	
		return new LocalidadDoctrineDAO();	
	}

	/**
	 * DAO para Nomenclador.
	 * 
	 * @return INomencladorDAO
	 */
	public static function getNomencladorDAO(){
	
		return new NomencladorDoctrineDAO();	
	}
	
	/**
	 * DAO para ObraSocial.
	 * 
	 * @return IObraSocialDAO
	 */
	public static function getObraSocialDAO(){
	
		return new ObraSocialDoctrineDAO();	
	}

	
	/**
	 * DAO para Practica.
	 * 
	 * @return IPracticaDAO
	 */
	public static function getPracticaDAO(){
	
		return new PracticaDoctrineDAO();	
	}
	
	/**
	 * DAO para Profesional.
	 * 
	 * @return IProfesionalDAO
	 */
	public static function getProfesionalDAO(){
	
		return new ProfesionalDoctrineDAO();	
	}

	/**
	 * DAO para Turno.
	 * 
	 * @return ITurnoDAO
	 */
	public static function getTurnoDAO(){
	
		return new TurnoDoctrineDAO();	
	}

	/**
	 * DAO para Especialidad.
	 * 
	 * @return IEspecialidadDAO
	 */
	public static function getEspecialidadDAO(){
	
		return new EspecialidadDoctrineDAO();	
	}	
}