<?php

class Admin_LoginController extends Zend_Controller_Action
{
    public function indexAction() 
    {
        // check if user is logged-in
        // if is logged-in redirect to network_home
        if (Zend_Auth::getInstance()->hasIdentity()) {
                $redirector = $this->getHelper('Redirector');
                $redirector instanceof Zend_Controller_Action_Helper_Redirector;
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_dashboard',
                            'action' => 'index'
                         ), 'default', true);
        } else {
                // user is not logged-in
                // redirect to login-page
                $redirector = $this->getHelper('Redirector');
                $redirector instanceof Zend_Controller_Action_Helper_Redirector;

                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_login',
                            'action' => 'login'
                         ), 'default', true);
        }	
    }
	
    public function loginAction() 
    {
        // initialisation of form class
        $loginForm = new Application_Form_Login();
        // get elements from POST 
        $request = $this->getRequest();
        $request instanceof Zend_Controller_Request_Http;
        // initialisation of flashMessenger
        $flashMessenger = $this->getHelper('FlashMessenger');
        // message types
        $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors')
        );
        // login-form validation and proccessing
        if ($request->isPost() && $request->getPost('task') === 'login') {
            
            if ($loginForm->isValid($request->getPost())) {
                
                    // initialisation of Zend_Db_Table class
                    $authAdapter = new Zend_Auth_Adapter_DbTable();
                    $authAdapter->setTableName('users')
                            ->setIdentityColumn('username')
                            ->setCredentialColumn('password')
                            ->setCredentialTreatment('MD5(?)');

                    $authAdapter->setIdentity($loginForm->getValue('username'));
                    $authAdapter->setCredential($loginForm->getValue('password'));
                    
                    $auth = Zend_Auth::getInstance();

                    $result = $auth->authenticate($authAdapter);
                    
                    // if user is successfully logged-in
                    if ($result->isValid()) {
                            // sending row from db table users as identification
                            // that user is logged-in and saving to
                            // Zend Session Storage
                            $user = (array) $authAdapter->getResultRowObject();
                            $auth->getStorage()->write($user);
                            // redirect to 
                            $redirector = $this->getHelper('Redirector');
                            $redirector instanceof Zend_Controller_Action_Helper_Redirector;
                            $redirector->setExit(true)
                                    ->gotoRoute(array(
                                            'controller' => 'admin_dashboard',
                                            'action' => 'index'
                                         ), 'default', true);
                    } else {
                        // logged-in credentials are incorrect
                        // show the message and dont let user
                        // to pass to dashboard
                        $systemMessages['errors'][] = 'ПОГРЕШНО КОРИСНИЧКО ИМЕ ИЛИ ЛОЗИНКА.';
                    }
                // user tried to access
                // without username and password
                } else {
                    //show the message and dont let user to pass to dashboard
                    $systemMessages['errors'][] = 'КОРИСНИЧКО ИМЕ И ЛОЗИНКА СУ ОБАВЕЗНИ.';
                }
        }
        // sending systemMessages method as variable 
        // to View logic
        $this->view->systemMessages = $systemMessages;
    }

    public function logoutAction() 
    {
        $auth = Zend_Auth::getInstance();
        // remove indication of
        // logged-in user
        $auth->clearIdentity();
        // get message helper
        $flashMessenger = $this->getHelper('FlashMessenger');
        // show message after success action
        $flashMessenger->addMessage('УСПЕШНО СТЕ СЕ ОДЈАВИЛИ!', 'success');

        // Ovde ide redirect na login stranu
        $redirector = $this->getHelper('Redirector');
        $redirector instanceof Zend_Controller_Action_Helper_Redirector;
        $redirector->setExit(true)
                ->gotoRoute(array(
                        'controller' => 'admin_login',
                        'action' => 'login'
                     ), 'default', true);
    }
}