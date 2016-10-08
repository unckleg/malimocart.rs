<?php

class SignController extends Zend_Controller_Action
{
    public function indexAction()
    {   
        $request = $this->getRequest();
        $flashMessenger = $this->getHelper('FlashMessenger');

        $form = new Application_Form_Register();

        $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors')
        );

        if ($request->isPost() && $request->getPost('task') === 'register') {

                try {
                        //check form is valid
                        if (!$form->isValid($request->getPost())) {
                                throw new Application_Model_Exception_InvalidInput('Невалидне информације прослеђене путем форме.');
                        }

                        //get form data
                        $formData = $form->getValues();
                        $formData['date_registered'] = date('Y-m-d H-i-s');
                        $modelRegister = new Application_Model_DbTable_Front_FrontRegister();
                        $parent = $modelRegister->insertParent($formData);

                        //set system message
                        $flashMessenger->addMessage('Успешно сте се пријавили', 'success');

                        //redirect to same or another page
                        $redirector = $this->getHelper('Redirector');
                        $redirector->setExit(true)
                                ->gotoRoute(array(
                                        'controller' => 'index',
                                        'action' => 'index'
                                )    , 'default', true);

                } catch (Application_Model_Exception_InvalidInput $ex) {
                        $systemMessages['errors'][] = $ex->getMessage();
                }
        }

        $this->view->systemMessages = $systemMessages;
        $this->view->form = $form;
    }
}
