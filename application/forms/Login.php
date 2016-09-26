<?php

class Application_Form_Login extends Zend_Form
{
	public function init() {
		// creating element for view logic
                // the constructor value username is field from
                // database: taskapp, table: users, entity: username
		$username = new Zend_Form_Element_Text('username');
		$username->addFilter('StringTrim')
			->addFilter('StringToLower')
                        // element is required
			->setRequired(true);
		$this->addElement($username);
		
		$password = new Zend_Form_Element_Password('password');
		$password->setRequired(true);
		$this->addElement($password);
	}
}