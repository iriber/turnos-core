<?php

namespace Turnos\Core\Test\profesionales;


include_once dirname(__DIR__). '/conf/init.php';

use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Cose\Security\service\ServiceFactory;
use Cose\Security\criteria\UserCriteria;


class ListUsersTest extends GenericTest{
	
	
	public function test(){

		$securityContext =  SecurityContext::getInstance();
		
		$service = ServiceFactory::getUserService();
		
		$this->log("getUserByUsername", __CLASS__);
		
		$users = $service->getList( new UserCriteria() );
		
		foreach ($users as $user) {
			$this->log("getUserByUsername", __CLASS__);
			$this->log( "User: " . $user->getUsername() . "/" . $user->getPassword(), __CLASS__);
			$this->log( "Groups: ", __CLASS__);
			foreach ($user->getGroups() as $group) {
				$this->log( "	group: " . $group->getName(), __CLASS__);
			}
		}
		
		
	}
}
?>