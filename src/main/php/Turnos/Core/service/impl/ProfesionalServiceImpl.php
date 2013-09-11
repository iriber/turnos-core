<?php
namespace Turnos\Core\service\impl;

use Turnos\Core\dao\DAOFactory, 
	Turnos\Core\service\IProfesionalService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\Security\model\User;

use Cose\exception\DAOException;
use Cose\exception\ServiceException;

/**
 * servicio para Profesional
 *  
 * @author bernardo
 *
 */
class ProfesionalServiceImpl extends CrudService implements IProfesionalService {
	
	protected function getDAO(){
		return DAOFactory::getProfesionalDAO();
	}
	
	function validateOnAdd( $entity ){}
	
	function validateOnUpdate( $entity ){}
	
	function validateOnDelete( $oid ){}
	
	function getProfesionalByUser(User $user){
		
		try {
			
			$p = $this->getDAO()->getProfesionalByUser($user);
			return $p;	
			
		} catch (DAOException $e) {

			throw new ServiceException( $e->getMessage() );
			
		} catch (Exception $e) {
				
			throw new ServiceException( $e->getMessage() );
		}
		
	}
	
	
}