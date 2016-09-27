<?php

class ContactController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $flashMessenger = $this->getHelper('FlashMessenger');

        $form = new Application_Form_Contact();

        $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors')
        );

        if ($request->isPost() && $request->getPost('task') === 'contact') {

                try {
                        //check form is valid
                        if (!$form->isValid($request->getPost())) {
                                throw new Application_Model_Exception_InvalidInput('Невалидне информације прослеђене путем форме.');
                        }

                        //get form data
                        $formData = $form->getValues();
                        $formData['date_sended'] = date('Y-m-d H-i-s');
                        $modelContact = new Application_Model_DbTable_Front_FrontContact();
                        $mail = $modelContact->insertMail($formData);

                        //set system message
                        $flashMessenger->addMessage('Ваша порука је успешно послата.', 'success');

                        //redirect to same or another page
                        $redirector = $this->getHelper('Redirector');
                        $redirector->setExit(true)
                                ->gotoRoute(array(
                                        'controller' => 'contact',
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