<?php

class Application_Model_DbTable_Front_FrontRegister extends Zend_Db_Table_Abstract
{
	const PARENT_REGISTERED = 0;
	const PARENT_CHECKED = 1;
	
	protected $_name = 'cms_parents';
        
        /**
         * @param int $id
         * @return null|array Associative array with keys as cms_parents table columns 
         * Or NULL if parent not found by id
         */
        public function getParentById($id)
        {
		$select = $this->select();
		$select->where('id = ?', $id);
                        
		$row = $this->fetchRow($select);
		
                if ($row instanceof Zend_Db_Table_Row) {
                    return $row->toArray();
                } else {
                    return null;
                }
                
		if (count($foundParents) <= 0) {
                    throw new Zend_Controller_Router_Exception('No parent is found for id: ' . $id, 404);
		} 
		
		$parent = $foundParents[0];
        }
        
        /**
         * 
         * @param int $id
         * @param array Associative array with keys as column names and values as column new values
         */
        public function updateParent($id, $parent)
        {
            if(isset($parent['id'])) {
                //Forbid changing of user id
                unset($parent['id']);
            }
            
            $this->update($parent, 'id = ' . $id);
        }
        
        /**
	 * 
	 * @param array $parent Associative array with keys as column names and values as coumn new values
	 * @return int The ID of new parent (autoincrement)
	 * 
	 */
	public function insertParent($parent) {
		//fetch order number for new parent
		
		$select = $this->select();
		
		//Sort rows by order_number DESCENDING and fetch one row from the top
		// with biggest order_number
		$select->order('order_number DESC');
		
		$parentWithBiggestOrderNumber = $this->fetchRow($select);
		
		if ($parentWithBiggestOrderNumber instanceof Zend_Db_Table_Row) {
			
			$parent['order_number'] = $parentWithBiggestOrderNumber['order_number'] + 1;
		} else {
			// table was empty, we are inserting first parent
			$parent['order_number'] = 1;
		}
		
		$id = $this->insert($parent);
		
		return $id;
	}
        
        /**
         * 
         * @param int $id ID of parent to delete
         */
        public function deleteParent($id)
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
         * @param int $id ID of parent to delete
         */
        public function disableParent($id)
        {
            $this->update(array(
                'status' => self::STATUS_DISABLED
            ), 'id = ' . $id);
        }
        /**
         * 
         * @param int $id ID of parent to delete
         */
        public function statusRead()
        {
            $this->update(array(
                'status' => self::PARENT_CHECKED
            ), 'status = 0');
        }
        /**
         * 
         * @param int $id ID of parent to delete
         */
        public function updateParentOrder($sortedIds)
        {
            foreach($sortedIds as $orderNumber => $id) {
                
                $this->update(array(
                'order_number' => $orderNumber + 1 //Parent order number starts from number 1
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
                        case 'order_number':
                        case 'status':
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
                        case 'status':
                        if(is_array($value)) {
                            $select->where($field . ' IN (?)', $value);
                        } else {
                            $select->where($field . ' = ?', $value);
                        } 
                        break;
                    case 'status_search':
                        $select->where('status LIKE ?', '%' . $value . '%');
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