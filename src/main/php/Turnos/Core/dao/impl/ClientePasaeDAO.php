<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\dao\helper\PasaeAPI;

use Turnos\Core\model\Cliente;

use Turnos\Core\dao\IClienteDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;
use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * DAO para Cliente (PASAE)
 *  
 * @author bernardo
 * @since 11/03/2014
 */
class ClientePasaeDAO implements IClienteDAO{
	
	/**
	 * se agrega una nueva entity
	 * @param entity entity a agregar.
	 * @throws DAOException
	 */
	function add( $entity ){
		throw new DAOException("TODO");
	}
	
	/**
	 * se modifica una entity
	 * @param entity entity a modificar.
	 * @throws DAOException
	 */
	function update( $entity ){
		throw new DAOException("TODO ClientePasaeDAO>>update");
		
		$oid = $entity->getOid();
		
		$params = array();
		$params["nombre"]= $entity->getNombre();
		
		$pasaeAPI = new PasaeAPI();
		
		$clientesREST = $pasaeAPI->post("/clientes/update/$oid", $params);

		$clienteJSON = json_decode( $clientesREST->responseText );

		$cliente = $this->buildCliente($clienteJSON) ;
		
		return $cliente;
		
		
		
	}
	
	/**
	 * se elimina una entity
	 * @param oid identificador de la entity a eliminar.
	 * @throws DAOException
	 */
	function delete( $oid ){
		throw new DAOException("TODO");
	}
	
	/**
	 * obtiene la entity dado su identificador
	 * @param oid identificador de la entity a buscar.
	 * @return
	 * @throws DAOException
	 */
	function get( $oid ){
		//throw new DAOException("TODO ClientePasaeDAO>>get");
		
		if( empty($oid) )
			return null;
		
		$pasaeAPI = new PasaeAPI();
		
		$clientesREST = $pasaeAPI->get("/clientes/get/$oid");

		$clienteJSON = json_decode( $clientesREST->responseText );

		$cliente = $this->buildCliente($clienteJSON) ;
		
		return $cliente;
		
		
	}
	
	/**
	 * obtiene el listado de entities dado un criterio de b�squeda.
	 * @param ICriteria criteria criterio de b�squeda.
	 * @return listado de entities
	 * @throws DAOException
	 */
	function getList( $criteria ){

		//throw new DAOException("get clientes por REST");
		
		$pasaeAPI = new PasaeAPI();
		
		
		$params = array();
		$params["nombre"]=$criteria->getNombre();
		
		$params["offset"] = $criteria->getOffset();
		$params["maxResult"] = $criteria->getMaxResult();
		
		$clientesREST = $pasaeAPI->get("/clientes", $params);
		
		$clientesJSON = json_decode( $clientesREST->responseText );

		$clientes = array();
		
		foreach ($clientesJSON as $clienteJSON) {
			$clientes[] = $this->buildCliente($clienteJSON) ;
		}
		
		return $clientes;
		
	}
	
	/**
	 * obtiene la cantidad de entities dado un criterio de búsqueda.
	 * @param ICriteria criteria criterio de búsqueda.
	 * @return int cantidad
	 * @throws DAOException
	 */
	function getCount( $criteria ){
		//throw new DAOException("TODO");

		$criteria->setOffset(1);
		$criteria->setMaxResult(null);
		return count( $this->getList($criteria) );
		
	}
	
	/**
	 * obtiene una entity dado un criterio de b�squeda.
	 * @param ICriteria criteria criterio de b�squeda.
	 * @return entity
	 * @throws DAOException
	 */
	function getSingleResult( $criteria ){
		throw new DAOException("TODO");
	}

	/**
	 * agrega varias entities en modo batch
	 * @param array $entities
	 * @param integer $batchSize
	 */
	function addEntities( $entities, $batchSize=1000 ){
		throw new DAOException("TODO");
	}
	
	
	public function buildCliente($next) {
    	
    	$cliente = new Cliente();
    	
        $cliente->setOid($next->oid);
		$cliente->setNombre($next->nombre);
        
        return $cliente;
    }
}