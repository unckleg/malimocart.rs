<?php

class Admin_MailController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $flashMessenger = $this->getHelper('FlashMessenger');
        $systemMessages = array(
            'success' => $flashMessenger->getMessages('success'),
            'errors' => $flashMessenger->getMessages('errors'),
        );
        
        $modelMail = new Application_Model_DbTable_Front_FrontContact();
        $messages = $modelMail->search(array(
            'filters' => array(
              ''  
            ),
            'orders' => array(
                'date_sended' => 'DESC'
            )
        ));
        
        $modelMail->statusRead();
        
        $this->view->systemMessages = $systemMessages;
        $this->view->messages = $messages;
    }
}