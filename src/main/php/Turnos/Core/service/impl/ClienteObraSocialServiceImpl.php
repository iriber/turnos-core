<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\model\ClienteObraSocial;

use Turnos\Core\model\ObraSocial;

use Turnos\Core\criteria\ClienteObraSocialCriteria;

use Turnos\Core\model\PlanObraSocial;

use Turnos\Core\service\IClienteObraSocialService;

use Turnos\Core\model\Cliente;

use Turnos\Core\service\IPlanObraSocialService;

use Turnos\Core\dao\DAOFactory;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\utils\Logger;
use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
/**
 * servicio para ClienteObraSocial
 *  
 * @author bernardo
 * @since 28/04/2014
 *
 */
class ClienteObraSocialServiceImpl extends CrudService implements IClienteObraSocialService {
	
	protected function getDAO(){
		return DAOFactory::getClienteObraSocialDAO();
	}
	
	function validateOnAdd( $entity ){
	
	}
	
	function validateOnUpdate( $entity ){
	
		$this->validateOnAdd($entity);
	}
	
	function validateOnDelete( $oid ){
	
		//TODO que no esté asignado a ningún cliente.
	}

	
		
	/**
	 * Retorna true si existe un plan dado un nombre y obra social  
	 * @param string $nombre
	 * @param ObraSocial $obraSocial
	 * @param int $oid
	 */
	public function getByObraSocialPlan(Cliente $cliente,  ObraSocial $obraSocial=null, PlanObraSocial $planObraSocial=null, $nroObraSocial="", $tipoAfiliado=null ){
	/*
		$criteria = new ClienteObraSocialCriteria();
		$criteria->setCliente($cliente);
		$criteria->setObraSocial($obraSocial);
		$criteria->setPlanObraSocial($planObraSocial);
		$criteria->setNroObraSocial($nroObraSocial);
		$criteria->setTipoAfiliado($tipoAfiliado);
		
		$criteria->setObraSocialNull($obraSocial == null);
		$criteria->setPlanObraSocialNull($planObraSocial == null);
		$criteria->setTipoAfiliadoNull($tipoAfiliado == null);
		$criteria->setNroObraSocialEmpty( empty($nroObraSocial) );
		$criteria->setMaxResult(1);
		$cos = null;
		*/
		try{
			
			$obras = $this->getDAO()->getByObraSocialPlan($cliente, $obraSocial, $planObraSocial, $nroObraSocial, $tipoAfiliado);
			
			if(count($obras) >0){
				$cos = $obras[0];
				Logger::log( "encontramos esta " . $cos->getOid(), __CLASS__ );
			}
			
		}catch (ServiceNonUniqueResultException $ex){
			Logger::log( $ex->getMessage(), __CLASS__ );
		
		}catch (ServiceException $ex){
			Logger::log( $ex->getMessage(), __CLASS__ );
		
		}catch (\Exception $ex){
			Logger::log( $ex->getMessage(), __CLASS__ );
		}
		return $cos;
	}
	
	/**
	 * se obtienen las obras sociales del cliente.
	 * @param Cliente $cliente
	 */
	public function getObrasSociales( Cliente $cliente ){

		try {
			$dao = DAOFactory::getClienteObraSocialDAO();
			$criteria = new ClienteObraSocialCriteria();
			$criteria->setCliente($cliente);	
			$criteria->addOrder( "obraSocial.nombre", "ASC");
			$criteria->addOrder( "planObraSocial.nombre", "ASC");
			$obras = $dao->getList($criteria);
			return $obras;	
			
		} catch (DAOException $e) {

			throw new ServiceException( $e->getMessage() );
			
		} catch (Exception $e) {
				
			throw new ServiceException( $e->getMessage() );
		}
		
	}	
	
	public function chequearObraSocial( ClienteObraSocial $clienteOS ){
	
		//busco un clienteobrasocial con los mismos datos
		//si no tiene creamos una.
		$osNueva = $clienteOS->getObraSocial();
		$cliente = $clienteOS->getCliente();

		$clienteOSResultado = null;
		
		if($osNueva!=null && (( $cliente!= null && $cliente->getOid()>0 ))){

			$cosExistente = $this->getByObraSocialPlan($cliente, $osNueva, $clienteOS->getPlanObraSocial(), $clienteOS->getNroObraSocial(), $clienteOS->getTipoAfiliado() );

			if($cosExistente!=null){ //ya existe, tomamos esta y la asignamos al turno.
				
				$clienteOSResultado = $cosExistente;
			
			}else{ 
				//es una nueva.
				$clienteOSResultado = $clienteOS;  
			}
		}else{
			$clienteOSResultado = null;
		}
		return $clienteOSResultado;
	}
}