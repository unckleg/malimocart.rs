<?php

class Admin_BlogController extends Zend_Controller_Action
{
    
    public function indexAction()
    {
        $modelBlog = new Application_Model_DbTable_Admin_CmsBlog();
        $posts = $modelBlog->search(array(
            'orders' => array(
                'date_published' => 'DESC'
            )
        ));
        $this->view->posts = $posts;
    }
    
    public function createAction()
    {
        $request = $this->getRequest();
        $flashMessenger = $this->getHelper('FlashMessenger');

        $form = new Application_Form_Blog_PostAdd();

        $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors')
        );

        if ($request->isPost() && $request->getPost('task') === 'create') {

                try {
                        //check form is valid
                        if (!$form->isValid($request->getPost())) {
                                throw new Application_Model_Exception_InvalidInput('Невалидне информације прослеђене путем форме.');
                        }

                        //get form data
                        $formData = $form->getValues();
                        unset($formData['post_photo']);             
                        
                        $formData['date_published'] = date('Y-m-d H-i-s');
                        $request->getPost('category_general') ? $formData['category_general'] = 1 : $formData['category_general'] = 0;
                        $request->getPost('category_news') ? $formData['category_news'] = 1 : $formData['category_news'] = 0;
                        $request->getPost('category_announcements') ? $formData['category_announcements'] = 1 : $formData['category_announcements'] = 0;
                        
                        $modelBlog = new Application_Model_DbTable_Admin_CmsBlog();
                        $post = $modelBlog->insertPost($formData);

                        if($form->getElement('post_photo')->isUploaded()) {
                            $fileInfos = $form->getElement('post_photo')->getFileInfo('post_photo');
                            $fileInfo = $fileInfos['post_photo'];
                            try
                            {
                                $postPhoto = Intervention\Image\ImageManagerStatic::make($fileInfo['tmp_name']);
                                $postPhoto->fit(800, 600);
                                $postPhoto->save(PUBLIC_PATH . '/uploads/blog-photos/' . $post['id'] . '.jpg');
                            } catch (Exception $ex)
                            {
                                throw new Application_Model_Exception_InvalidInput('Дошло је до грешке приликом процесовања фотографије.');
                            }
                        }
                        
                        
                        //set system message
                        $flashMessenger->addMessage('Успешно сте унели нову објаву.', 'success');

                        //redirect to same or another page
                        $redirector = $this->getHelper('Redirector');
                        $redirector->setExit(true)
                                ->gotoRoute(array(
                                        'controller' => 'admin_dashboard',
                                        'action' => 'index'
                                )    , 'default', true);

                } catch (Application_Model_Exception_InvalidInput $ex) {
                        $systemMessages['errors'][] = $ex->getMessage();
                }
        }

        $this->view->systemMessages = $systemMessages;
        $this->view->form = $form;
    }
    
    public function editAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $flashMessenger = $this->getHelper('FlashMessenger');

        $form = new Application_Form_Blog_PostAdd();
        
        $systemMessages = array(
                'success' => $flashMessenger->getMessages('success'),
                'errors' => $flashMessenger->getMessages('errors')
        );
        
        $modelBlog = new Application_Model_DbTable_Admin_CmsBlog();
        $post = $modelBlog->getPostById($id);
        $form->populate($post);
        if ($request->isPost() && $request->getPost('task') === 'create') {

                try {
                        //check form is valid
                        if (!$form->isValid($request->getPost())) {
                                throw new Application_Model_Exception_InvalidInput('Невалидне информације прослеђене путем форме.');
                        }

                        //get form data
                        $formData = $form->getValues();
                        unset($formData['post_photo']);             
                        
                        $formData['date_published'] = date('Y-m-d H-i-s');
                        $request->getPost('category_general') ? $formData['category_general'] = 1 : $formData['category_general'] = 0;
                        $request->getPost('category_news') ? $formData['category_news'] = 1 : $formData['category_news'] = 0;
                        $request->getPost('category_announcements') ? $formData['category_announcements'] = 1 : $formData['category_announcements'] = 0;
                        
                        $post = $modelBlog->insertPost($formData);

                        if($form->getElement('post_photo')->isUploaded()) {
                            $fileInfos = $form->getElement('post_photo')->getFileInfo('post_photo');
                            $fileInfo = $fileInfos['post_photo'];
                            try
                            {
                                $postPhoto = Intervention\Image\ImageManagerStatic::make($fileInfo['tmp_name']);
                                $postPhoto->fit(800, 600);
                                $postPhoto->save(PUBLIC_PATH . '/uploads/blog-photos/' . $post['id'] . '.jpg');
                            } catch (Exception $ex)
                            {
                                throw new Application_Model_Exception_InvalidInput('Дошло је до грешке приликом процесовања фотографије.');
                            }
                        }
                        
                        
                        //set system message
                        $flashMessenger->addMessage('Успешно сте унели нову објаву.', 'success');

                        //redirect to same or another page
                        $redirector = $this->getHelper('Redirector');
                        $redirector->setExit(true)
                                ->gotoRoute(array(
                                        'controller' => 'admin_dashboard',
                                        'action' => 'index'
                                )    , 'default', true);

                } catch (Application_Model_Exception_InvalidInput $ex) {
                        $systemMessages['errors'][] = $ex->getMessage();
                }
        }
        $this->view->post = $post;
        $this->view->systemMessages = $systemMessages;
        $this->view->form = $form;
    }
    
    public function deleteAction()
    {
        
    }
    
}