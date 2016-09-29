<?php

class BlogController extends Zend_Controller_Action
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
    
    public function detailsAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        
        $modelBlog = new Application_Model_DbTable_Admin_CmsBlog();
        $post = $modelBlog->getPostById($id);
        
        $this->view->post = $post;
    }
}

