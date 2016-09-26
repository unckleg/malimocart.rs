<?php

class Application_Plugin_Admin extends Zend_Controller_Plugin_Abstract
{
	public function routeShutdown(Zend_Controller_Request_Abstract $request) {
		
		$controllerName = $request->getControllerName();
		
		$actionName = $request->getActionName();
		
		if( preg_match('/^admin_/', $controllerName )) {
			
			Zend_Layout::getMvcInstance()->setLayout('admin');
			
			// provera da li korisnik nije ulogovan
			if (
				!Zend_Auth::getInstance()->hasIdentity()
				&& $controllerName != 'admin_login'
			) {
				$flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
				$flashMessenger->addMessage('МОРАТЕ СЕ ПРВО ПРИЈАВИТИ!', 'errors');
				
				$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
				
				$redirector->setExit(true)
					->gotoRoute(array(
						'controller' => 'admin_login',
						'action' => 'login'
					), 	'default', true);
				
			}
			
		}
	}
}