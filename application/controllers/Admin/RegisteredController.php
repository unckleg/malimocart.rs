<?php

class Admin_RegisteredController extends Zend_Controller_Action
{
    public function indexAction()
    {
     
        $modelParents = new Application_Model_DbTable_Front_FrontRegister();
        $allParents = $modelParents->search(array(
            'filters' => array(
            ),
            'orders' => array(
                'order_number' => ASC
            )
        ));
        if (empty($allParents)) {
            //throw new Zend_Exception('');
        }
        $modelParents->statusRead();
        
        $this->view->parents = $allParents;
    }
}