<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\model\Turno;

use Turnos\Core\model\ClienteObraSocial;

use Turnos\Core\criteria\PracticaCriteria;

use Turnos\Core\service\ServiceFactory;

use Turnos\Core\model\Practica;

use Turnos\Core\exception\TurnoClienteRequiredException;

use Turnos\Core\model\Cliente;

use Turnos\Core\model\EstadoTurno;

use Turnos\Core\criteria\TurnoCriteria;

use Turnos\Core\model\Profesional;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\ITurnoService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\utils\Logger;
use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;

/*
use Cose\Observer\service\impl\TriggerService;
use Cose\Observer\model\impl\Event;
*/

/**
 * servicio para Turno
 *  
 * @author bernardo
 *
 */
class TurnoServiceImpl extends CrudService implements ITurnoService {
	
	protected function getDAO(){
		return DAOFactory::getTurnoDAO();
	}
	
	function validateOnAdd( $entity ){
	
		//que tenga profesional
		$profesional = $entity->getProfesional();
		if( empty($profesional) )
			throw new ServiceException("turno.profesional.required");

		//que tenga cliente
		$cliente = $entity->getCliente();
		if( empty($cliente) ){
			
			//vemos si tiene el nombre y el teléfono (turnos rápidos)
			$nombre = $entity->getNombre();
			if( empty($nombre) )
				throw new ServiceException("turno.cliente.required");
				
		}
			
			
		//que tenga fecha
		$fecha = $entity->getFecha();
		if( empty($fecha) )
			throw new ServiceException("turno.fecha.required");
			
		//que tenga hora
		$hora = $entity->getHora();
		if( empty($hora) )
			throw new ServiceException("turno.hora.required");
			
		//que no se repita profesional+fecha+hora
		
		if( $this->existsByProfesionalFechaHora($profesional, $fecha, $hora, $entity->getOid() ) )
		
			throw new DuplicatedEntityException("turno.profesional.unicity");
						
			
	}
	
	function validateOnUpdate( $entity ){
	
		$this->validateOnAdd($entity);		
	
	}
	
	function validateOnDelete( $oid ){}
	
	/**
	 * redefino el add para cambiar la obra social del
	 * cliente.
	 * @param $entity
	 * @throws ServiceException
	 */
	public function add($entity){

		$tipoAfiliado = $entity->getTipoAfiliado();
		if(empty($tipoAfiliado) || $tipoAfiliado < 0)
			$entity->setTipoAfiliado(null);
		
		$nueva = $entity->getClienteObraSocial();
		if($nueva!=null){	
			$cosExistente = ServiceFactory::getClienteObraSocialService()->chequearObraSocial( $entity->getClienteObraSocial() );
		
			$entity->setClienteObraSocial( $cosExistente );
		}
		
		//agregamos el turno.
		parent::add($entity);

		
		//le asignamos al cliente la obra social indicada en el turno.
		$cliente = $entity->getCliente();
		if( $cliente!= null && $cliente->getOid()>0 ){
		
			$cliente = DAOFactory::getClienteDAO()->get($cliente->getOid());
			$cliente->setClienteObraSocial($entity->getClienteObraSocial());
			DAOFactory::getClienteDAO()->update( $cliente );
			
		}

		
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/Turnos\Core\service.ITurnoService::getTurnosDelDia()
	 */
	function getTurnosDelDia( \DateTime $fecha, Profesional $profesional=null){
		
        try {
        	
        	return $this->getDAO()->getTurnosDelDia($fecha, $profesional);
        	
        } catch (\Exception $e) {
        	
        	throw new ServiceException( $e->getMessage() );
        	
        }

	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/Turnos\Core\service.ITurnoService::iniciarTurno()
	 */
	function iniciarTurno($turnoOid){
		
		try {
			
			$turno = $this->get($turnoOid);
		
			$turno->setEstado( EstadoTurno::EnCurso );
		
			$this->getDAO()->update( $turno );
			
			//generamos la práctica asociada al turno.
			$nomenclador = $turno->getNomenclador();
			
			//primero chequeamos que no se haya generado la práctica manualmente
			//esto lo miramos chequeamos que no exista una práctica con el mismo nomenclador,
			//para la misma fecha.
			
			if( $nomenclador!=null ){
			
				$criteria= new PracticaCriteria();
				$criteria->setFecha($turno->getFecha());
				$criteria->setCliente($turno->getCliente());
				$criteria->setNomenclador($nomenclador);
				
				try {
					
					$practica = ServiceFactory::getPracticaService()->getSingleResult( $criteria );
					
					//ya existe, no hacemos nada.		
				}catch (ServiceException $se){
				
					//no existe, la creamos.
					$practica = new Practica();
					$practica->setCliente( $turno->getCliente() );
					$practica->setProfesional( $turno->getProfesional() );
					$practica->setClienteObraSocial($turno->getCliente()->getClienteObraSocial() );
					$practica->setFecha( $turno->getFecha() );
					$practica->setNomenclador( $nomenclador );
				
					ServiceFactory::getPracticaService()->add( $practica );
				}
				
				
				
			}
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e );
			
		} catch (\Exception $e) {

			throw new ServiceException( $e );
					
		}
		return $turno;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/Turnos\Core\service.ITurnoService::finalizarTurno()
	 */
	function finalizarTurno($turnoOid){
		
		try {
			
			$turno = $this->get($turnoOid);
		
			$turno->setEstado( EstadoTurno::Atendido );
		
			$this->getDAO()->update( $turno );
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e );
			
		} catch (Exception $e) {

			throw new ServiceException( $e );
					
		}
		return $turno;
	}
	
	function getTurnosCliente( Cliente $cliente){
		
		$criteria = new TurnoCriteria();
		$criteria->setCliente($cliente);		
		$criteria->addOrder("fecha", "DESC");
		//$criteria->addOrder("hora", "DESC");
		return $this->getList($criteria);
		
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see service/Turnos\Core\service.ITurnoService::iniciarTurno()
	 */
	function turnoEnSala($turnoOid){
		
		try {
			
			$turno = $this->get($turnoOid);
		
			
			//chequeamos si ya se ingresó el cliente
			//si no se ingresó avisamos con exception
			$cliente = $turno->getCliente();
			if( empty($cliente) ){
				$ex = new TurnoClienteRequiredException("turno.enSala.cliente.required");
				$ex->setTurno($turno);
				throw $ex;
				
			}
			$turno->setEstado( EstadoTurno::EnSala );
		
			$this->getDAO()->update( $turno );
			
			//FIXME test observer
			/*
			$trigger = new TriggerService();
			$event = new Event();
			$trigger->trigger($event, "localhost", "8084");			
			*/
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e );
			
		} catch (ServiceException $e) {

			throw $e;
					
		} catch (\Exception $e) {

			throw new ServiceException( $e );
					
		}
		return $turno;
	}
	
	/**
	 * Retorna true si existe un turno para el profesional, fecha y hora dados
	 * 
	 * @param $profesional
	 * @param $fecha
	 * @param $hora
	 * @param $oid
	 */
	private function existsByProfesionalFechaHora( Profesional $profesional, \Datetime $fecha, \Datetime $hora, $oid=null ){
	
		$criteria = new TurnoCriteria();
		$criteria->setProfesional($profesional);
		$criteria->setFecha($fecha);
		$criteria->setHora($hora);
		$criteria->setOidNotEqual($oid);
	
		$exists = false;
		
		try{
			Logger::log("buscando turno", __CLASS__ );
			
			$os = $this->getSingleResult( $criteria );
			Logger::log("exists $exists ", __CLASS__ );
			$exists = true;
			
		}catch (ServiceNonUniqueResultException $ex){
			Logger::log( get_class($ex) . ": " . $ex->getMessage(), __CLASS__);
			$exists = true;
		
		}catch (ServiceException $ex){
			Logger::log( get_class($ex) . ": " .$ex->getMessage(), __CLASS__);
			$exists = false;
		
		}catch (\Exception $ex){
			Logger::log( get_class($ex) . ": " .$ex->getMessage(), __CLASS__);
			$exists = false;
		}
		return $exists;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see service/Turnos\Core\service.ITurnoService::asignarTurno()
	 */
	function asignarTurno($turnoOid){
		
		try {
			
			$turno = $this->get($turnoOid);
		
			$turno->setEstado( EstadoTurno::Asignado );
		
			$this->getDAO()->update( $turno );
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e );
			
		} catch (Exception $e) {

			throw new ServiceException( $e );
					
		}
		return $turno;
	}
	
	function getTurnosAtendiendo( \DateTime $fecha ){
		
		try {
        	
        	return $this->getDAO()->getTurnosAtendiendo($fecha);
        	
        } catch (\Exception $e) {
        	
        	throw new ServiceException( $e->getMessage() );
        	
        }
	}
	
	/**
	 * redefino el update para cambiar la obra social del
	 * cliente.
	 * @param $entity
	 * @throws ServiceException
	 */
	public function update($entity){

		$tipoAfiliado = $entity->getTipoAfiliado();
		if(empty($tipoAfiliado) || $tipoAfiliado < 0)
			$entity->setTipoAfiliado(null);
			
		$nueva = $entity->getClienteObraSocial();
		if($nueva!=null){
			$cosExistente = ServiceFactory::getClienteObraSocialService()->chequearObraSocial( $entity->getClienteObraSocial() );
			$entity->setClienteObraSocial( $cosExistente );
		
		
			//le asignamos al cliente la obra social indicada en el turno.
			$cliente = $entity->getCliente();
			if( $cliente!= null && $cliente->getOid()>0 ){
		
			$entity->getClienteObraSocial()->setCliente($cliente);
			$cliente = DAOFactory::getClienteDAO()->get($cliente->getOid());
			$cliente->setClienteObraSocial($entity->getClienteObraSocial());
			DAOFactory::getClienteDAO()->update( $cliente );
			
			}
		}
		
		parent::update($entity);
		
		
	}

//	
//	protected function chequearObraSocial( Turno $entity ){
//	
//		//busco un clienteobrasocial con los mismos datos q los del turno
//		//si no tiene creamos uno.
//		$cosTurno = $entity->getClienteObraSocial();
//		$cosExistente = null;
//		$osTurno = $cosTurno->getObraSocial();
//		$cliente = $entity->getCliente();
//
//		Logger::log("buscando cliente obra social ");
//		
//		if($osTurno!=null && (( $cliente!= null && $cliente->getOid()>0 ))){
//
//			Logger::log("buscando cliente obra social " . $cliente->getOid() . " os:" . $cosTurno->getObraSocial()->getOid() . " plan:" .$cosTurno->getPlanObraSocial() . " nro:" . $cosTurno->getNroObraSocial() . " tipo:" . $cosTurno->getTipoAfiliado());
//			$cosExistente = ServiceFactory::getClienteObraSocialService()->getByObraSocialPlan($cliente, $cosTurno->getObraSocial(), $cosTurno->getPlanObraSocial(), $cosTurno->getNroObraSocial(), $cosTurno->getTipoAfiliado() );
//
//			if($cosExistente!=null){ //ya existe, tomamos esta y la asignamos al turno.
//				$entity->setClienteObraSocial($cosExistente);
//			
//				Logger::log("existe! " . $cosExistente->getOid()	);
//				
//			}else{ //no existe, asi que una vez que agregamos el turno, se la asignamos al cliente
//				$cambioObraSocial = true;			
//				$cosExistente = $entity->getClienteObraSocial();  
//				Logger::log("no existe! ");
//			}
//		}else{
//			$entity->setClienteObraSocial(null);
//		}
//		return $cosExistente;
//	}
}