<?php
namespace Turnos\Core\service;

use Turnos\Core\service\impl\ClienteObraSocialServiceImpl;

use Turnos\Core\service\impl\PlanObraSocialServiceImpl;

use Turnos\Core\service\impl\StatsServiceImpl;

use Turnos\Core\service\impl\ResumenHistoriaClinicaServiceImpl;

use Turnos\Core\service\impl\EspecialidadServiceImpl;

use Turnos\Core\service\impl\AusenciaServiceImpl;

use Turnos\Core\service\impl\HorarioServiceImpl;

use Turnos\Core\service\impl\LocalidadServiceImpl;

use Turnos\Core\service\impl\NomencladorServiceImpl;

use Turnos\Core\service\impl\ObraSocialServiceImpl;

use Turnos\Core\service\impl\PracticaServiceImpl;

use Turnos\Core\service\impl\TurnoServiceImpl;

use Turnos\Core\service\impl\ProfesionalServiceImpl;

use Turnos\Core\service\impl\ClienteServiceImpl;


/**
 * Factory de servicios
 *  
 * @author bernardo
 *
 */
class ServiceFactory {

	/**
	 * @return IAusenciaService
	 */
	public static function getAusenciaService(){
	
		return new AusenciaServiceImpl();	
	}
	
	/**
	 * @return IClienteService
	 */
	public static function getClienteService(){
	
		return new ClienteServiceImpl();	
	}
	

	/**
	 * @return IHorarioService
	 */
	public static function getHorarioService(){
	
		return new HorarioServiceImpl();	
	}
	
	/**
	 * @return ILocalidadService
	 */
	public static function getLocalidadService(){
	
		return new LocalidadServiceImpl();	
	}	
	
	/**
	 * @return INomencladorService
	 */
	public static function getNomencladorService(){
	
		return new NomencladorServiceImpl();	
	}
	
	/**
	 * @return IObraSocialService
	 */
	public static function getObraSocialService(){
	
		return new ObraSocialServiceImpl();	
	}
	
	/**
	 * @return IPracticaService
	 */
	public static function getPracticaService(){
	
		return new PracticaServiceImpl();	
	}
	
	/**
	 * @return IProfesionalService
	 */
	public static function getProfesionalService(){
	
		return new ProfesionalServiceImpl();	
	}
	
	/**
	 * @return ITurnoService
	 */
	public static function getTurnoService(){
	
		return new TurnoServiceImpl();	
	}

	/**
	 * @return IEspecialidadService
	 */
	public static function getEspecialidadService(){
	
		return new EspecialidadServiceImpl();	
	}
	
	/**
	 * @return IResumenHistoriaClinicaService
	 */
	public static function getResumenHistoriaClinicaService(){
	
		return new ResumenHistoriaClinicaServiceImpl();	
	}
	
	/**
	 * @return IStatsService
	 */
	public static function getStatsService(){
	
		return new StatsServiceImpl();	
	}		
	
	/**
	 * @return IPlanObraSocialService
	 */
	public static function getPlanObraSocialService(){
	
		return new PlanObraSocialServiceImpl();	
	}

	/**
	 * @return IClienteObraSocialService
	 */
	public static function getClienteObraSocialService(){
	
		return new ClienteObraSocialServiceImpl();	
	}
}