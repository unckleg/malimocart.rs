<?php

class WorkshopController extends Zend_Controller_Action
{
    public function indexAction()
    {
        
    }
    public function individualAction()
    {
        //clients fetching
        $cmsWorkshopsDbTable = new Application_Model_DbTable_Admin_CmsWorkshops();        
        $workshopIndividual = $cmsWorkshopsDbTable->search(array(
            'filters' => array(
                'page' => Application_Model_DbTable_Admin_CmsWorkshops::PAGE_INDIVIDUAL
            ),
            'orders' => array(
                'order_number' => 'ASC'
            )
        ));
        
        $this->view->workshopindividual = $workshopIndividual;
    }
    public function groupAction()
    {
        //clients fetching
        $cmsWorkshopsDbTable = new Application_Model_DbTable_Admin_CmsWorkshops();
        $workshopGroup = $cmsWorkshopsDbTable->search(array(
            'filters' => array(
                'page' => Application_Model_DbTable_Admin_CmsWorkshops::PAGE_GROUP
            ),
            'orders' => array(
                'order_number' => 'ASC'
            )
        ));
        
        $this->view->workshopgroup = $workshopGroup;
    }
}

