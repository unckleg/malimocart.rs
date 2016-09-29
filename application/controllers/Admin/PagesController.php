<?php


class Admin_PagesController extends Zend_Controller_Action
{
    public function indexAction()
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
        $workshopIndividual = $cmsWorkshopsDbTable->search(array(
            'filters' => array(
                'page' => Application_Model_DbTable_Admin_CmsWorkshops::PAGE_INDIVIDUAL
            ),
            'orders' => array(
                'order_number' => 'ASC'
            )
        ));
        
        $this->view->workshopindividual = $workshopIndividual;
        $this->view->workshopgroup = $workshopGroup;
    }
    public function editAction()
    {
        $request = $this->getRequest();
        // INT convert param to int
        $id = (int) $request->getParam('id');
        if ($id <= 0) {
            //Stop program executing and show "Page not found 404
            throw new Zend_Controller_Router_Exception('Неисправан редни број елемента:', 404);
        }

        $cmsWorkshopsDbTable = new Application_Model_DbTable_Admin_CmsWorkshops();

        $workshop = $cmsWorkshopsDbTable->getWorkshopById($id);

        if (empty($workshop)) {
            throw new Zend_Controller_Router_Exception('Елемент са редним бројем: ' . $id . ' не постоји.' . 'exist', 404);
        }
        
        $flashMessenger = $this->getHelper('FlashMessenger');
        $systemMessages = array(
            'success' => $flashMessenger->getMessages('success'),
            'errors' => $flashMessenger->getMessages('errors'),
        );

        $form = new Application_Form_WorkshopEdit();
        //default form data
        $form->populate($workshop);

        if ($request->isPost() && $request->getPost('task') === 'update') {
            try {
                //check form is valid
                if (!$form->isValid($request->getPost())) {
                    $error = $form->getMessages();
                }

                //get form data
                $formData = $form->getValues();
                unset($formData['workshop_photo']);

                if($form->getElement('workshop_photo')->isUploaded()) {
                    $fileInfos = $form->getElement('workshop_photo')->getFileInfo('workshop_photo');
                    $fileInfo = $fileInfos['workshop_photo'];
                    try
                    {
                        $workshopPhoto = Intervention\Image\ImageManagerStatic::make($fileInfo['tmp_name']);
                        $workshopPhoto->fit(380, 200);
                        $workshopPhoto->save(PUBLIC_PATH . '/uploads/workshop-images/' . $id . '.jpg');
                    } catch (Exception $ex)
                    {
                        throw new Application_Model_Exception_InvalidInput('Дошло је до грешке приликом процесовања фотографије.');
                    }
                }
                //Save update to database Success
                $cmsWorkshopsDbTable->updateWorkshop($id, $formData);
                //set system message
                $flashMessenger->addMessage('Елемент је успешно измењен!', 'success');
                //redirect to same or another page
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                    ->gotoRoute(array(
                        'controller' => 'admin_pages',
                        'action' => 'index'
                    ), 'default', true);
            } catch (Application_Model_Exception_InvalidInput $ex) {
                $systemMessages['errors'][] = $ex->getMessage();
            }
        }
        $this->view->systemMessages = $systemMessages;
        $this->view->form = $form;
        $this->view->workshop = $workshop;
    }
}
