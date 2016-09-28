<?php

class Application_Model_DbTable_Admin_CmsBlog extends Zend_Db_Table_Abstract
{
	const POST_VISIBLE = 1;
	const POST_HIDDEN = 0;
	
	protected $_name = 'cms_blog';
        
        /**
         * @param int $id
         * @return null|array Associative array with keys as cms_posts table columns 
         * Or NULL if post not found by id
         */
        public function getPostById($id)
        {
		$select = $this->select();
		$select->where('id = ?', $id);
                        
		$row = $this->fetchRow($select);
		
                if ($row instanceof Zend_Db_Table_Row) {
                    return $row->toArray();
                } else {
                    return null;
                }
                
		if (count($foundPosts) <= 0) {
                    throw new Zend_Controller_Router_Exception('No post is found for id: ' . $id, 404);
		} 
		
		$post = $foundPosts[0];
        }
        
        /**
         * 
         * @param int $id
         * @param array Associative array with keys as column names and values as column new values
         */
        public function updatePost($id, $post)
        {
            if(isset($post['id'])) {
                //Forbid changing of user id
                unset($post['id']);
            }
            
            $this->update($post, 'id = ' . $id);
        }
        
        /**
         * @param array $post
         * @param array Associative array with keys as column names and values as column new values
         * @return int  $id of new created post (Autoincrement)
         */
        public function insertPost($post) 
        //fetch order number for new post 
        {
		$id = $this->insert($post);
		
		return $id;
        }
        /**
         * 
         * @param int $id ID of post to delete
         */
        public function deletePost($id)
        {
            /*Get WORKSHOP ID ORDER NUMBER*/
            $select = $this->select();
		$select->where('id = ?', $id);
		$row = $this->fetchRow($select);
                if ($row instanceof Zend_Db_Table_Row) {
                    $rowId = $row->toArray();
                } else {
                    return NULL;
                }
                $rowIdNum = $rowId['order_number'];
            /* var_dump($rowIdNum); die(); */
                
            $this->delete('id = ' . $id);

            $this->update(array( 
                'order_number' => new Zend_Db_Expr('order_number - 1')), 
                'order_number > ' . $rowIdNum );
        }
        /**
         * 
         * @param int $id ID of post to delete
         */
        public function disablePost($id)
        {
            $this->update(array(
                'status' => self::STATUS_DISABLED
            ), 'id = ' . $id);
        }
        /**
         * 
         * @param int $id ID of post to delete
         */
        public function enablePost($id)
        {
            $this->update(array(
                'status' => self::STATUS_ENABLED
            ), 'id = ' . $id);
        }
        /**
         * 
         * @param int $id ID of post to delete
         */
        public function updatePostOrder($sortedIds)
        {
            foreach($sortedIds as $orderNumber => $id) {
                
                $this->update(array(
                'order_number' => $orderNumber + 1 //Post order number starts from number 1
            ), 'id = ' . $id);
        }
    }
        
        public function search($parameters = array())
        {
            $select = $this->select();
            if (isset($parameters['filters'])) {
                $filters = $parameters['filters'];
                
                /*
                 * Calling function from function/switchcase proccessFIlters
                 */
                $this->processFilters($filters, $select);
                
            }
            if (isset($parameters['orders'])) {
                $orders = $parameters['orders'];
                foreach ($orders as $field => $orderDirection ) {
                    switch ($field) 
                    {
                        case 'id':
                        case 'title':
                        case 'description':
                        case 'page':
                        case 'date_published':
                            if ($orderDirection === 'DESC') {
                                $select->order($field . ' DESC');
                            } else {
                                //By default selecting ASC
                                $select->order($field);
                            }
                            break;
                    }
                }
            }
            if (isset($parameters['limit'])) {
                // page is set to limit by page
                if (isset($parameters['page'])){
                    $select->limitPage($parameters['page'], $parameters['limit']);
                } else {
                    //page is not set, just do regular limit
                    $select->limit($parameters['limit']);
                }
            }
            
            /* Debug and see query
             |
             | die($select->assemble());
             |
             */
            return $this->fetchAll($select)->toArray();
        }
        /**
         * See function search $parameters['filters']
         * @param array $filters
         * @return int Count of rows that match $filters 
         */
        public function count(array $filters = array())
        {
            $select = $this->select();
            
            /*
            * Calling function from function/switchcase proccessFIlters
            */
           $this->processFilters($filters, $select);
            
            //Zend reset previously set columns
            //Also we can reset all queries LIKE:
            // WHERE, COLUMNS.
            $select->reset('columns');
            
            //set one column/field to fetch and it is function
            $select->from($this->_name,'COUNT(*) AS total');
            
            //Fetch/GET just one row from DB table
            $row =  $this->fetchRow($select)->toArray();
            
            return $row['total'];
        }
        
        /**
         * Fill $select object with WHERE  conditions
         * @param array $filters
         * @param Zend_Db_Select $select
         */
        protected function processFilters(array $filters, Zend_Db_Select $select)
        {
            /* 
             * Select object will be modified outside this function
             * Objects are alywas passedd by reference
            */
            foreach ($filters as $field => $value) {
                switch ($field) 
                {
                    case 'id':
                        case 'title':
                        case 'description':
                        case 'page':
                        case 'order_number':
                        if(is_array($value)) {
                            $select->where($field . ' IN (?)', $value);
                        } else {
                            $select->where($field . ' = ?', $value);
                        } 
                        break;
                    case 'title_search':
                        $select->where('title LIKE ?', '%' . $value . '%');
                        break;
                     case 'description_search':
                        $select->where('description LIKE ?', '%' . $value . '%');
                        break;
                    case 'page_search':
                        $select->where('page LIKE ?', '%' . $value . '%');
                        break;
                    case 'id_exclude':
                        if (is_array($value)) {
                            $select->where('id NOT IN (?)', $value);
                        } else {
                            $select->where('id != ?', $value);
                        }
                        break;
                } /*ENDSWITCH*/ 
                } /*ENDFOREACH*/;
        }
}