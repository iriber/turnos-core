<?php
namespace Turnos\Core\dao;

use Cose\exception\DAOException;

use Cose\Crud\dao\ICrudDAO;

use Cose\Security\model\User;

/**
 * Interface del DAO de Profesional
 *  
 * @author bernardo
 *
 */
interface IProfesionalDAO extends ICrudDAO {

	function getProfesionalByUser(User $user);

}
