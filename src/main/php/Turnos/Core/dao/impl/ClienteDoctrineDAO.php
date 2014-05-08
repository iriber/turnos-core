<?php
namespace Turnos\Core\dao\impl;

use Turnos\Core\dao\helper\LikeWrapper;

use Turnos\Core\model\Cliente;

use Turnos\Core\dao\IClienteDAO;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Doctrine\ORM\QueryBuilder;

/**
 * dto para Cliente
 *  
 * @author bernardo
 *
 */
class ClienteDoctrineDAO extends CrudDAO implements IClienteDAO{
	
	protected function getClazz(){
		return get_class( new Cliente() );
	}
	
	
	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
		
		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "c.oid <> $oid");
		}
		
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			
			LikeWrapper::wrapp($queryBuilder, "c.nombre", $nombre);
			//$queryBuilder->andWhere("c.nombre like '%$nombre%'");
		}

		$nombreEq = $criteria->getNombreEqual();
		if( !empty($nombreEq) ){
			$queryBuilder->andWhere("c.nombre = '$nombreEq'");
		}
		
		$nro = $criteria->getNroHistoriaClinica();
		if( !empty($nro) ){
			$queryBuilder->andWhere("c.nroHistoriaClinica = '$nro'");
		}
		
		$afiliado = $criteria->getNroObraSocial();
		if( !empty($afiliado) ){
			$queryBuilder->andWhere("cos.nroObraSocial = '$afiliado'");
		}
		
		$obraSocial = $criteria->getObraSocialNombre();
		if( !empty($obraSocial) ){
			LikeWrapper::wrapp($queryBuilder, "os.nombre", $obraSocial);
		}

		$domicilio = $criteria->getDomicilio();
		if( !empty($domicilio) ){
			$queryBuilder->andWhere("c.domicilio like '%$domicilio%'");
		}

		$nroDocumento = $criteria->getNroDocumento();
		if( !empty($nroDocumento) ){
			$queryBuilder->andWhere("c.nroDocumento = '$nroDocumento'");
		}

		$tipoDocumento = $criteria->getTipoDocumento();
		if( !empty($tipoDocumento) ){
			$queryBuilder->andWhere("c.tipoDocumento = '$tipoDocumento'");
		}
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('c', 'cos')->from( $this->getClazz() , 'c')
								->leftJoin('c.clienteObraSocial', 'cos')
								->leftJoin('cos.obraSocial', 'os');
								
		return $queryBuilder;
	}
	
	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(c.oid)')->from( $this->getClazz() , 'c')
								->leftJoin('c.clienteObraSocial', 'cos')
								->leftJoin('cos.obraSocial', 'os');
								
		return $queryBuilder;
	}
	
	protected function getFieldName($name){
		
		$hash = array();
		$hash["obraSocial.nombre"] = "cos.obraSocial.nombre";
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "c.$name";	
		}	
		
	}
}