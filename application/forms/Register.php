<?php

class Application_Form_Register extends Zend_Form
{
	public function init() {
            
		$parentName = new Zend_Form_Element_Text('parent_name');
		$parentName->addFilter('StringTrim')
			->addValidator('StringLength', false, array('min' => 3, 'max' => 255))
			->setRequired(true);
		$this->addElement($parentName);
		
		$parentSurname = new Zend_Form_Element_Text('parent_surname');
		$parentSurname->addFilter('StringTrim')
			->setRequired(true);
		$this->addElement($parentSurname);
		
		$firstLastChild = new Zend_Form_Element_Text('first_last_child');
		$firstLastChild->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($firstLastChild);

                $email = new Zend_Form_Element_Text('email');
		$email->addFilter('StringTrim')
			->addValidator('EmailAddress', false, array('domain' => false))
			->setRequired(true);
		$this->addElement($email);
                
                $phone = new Zend_Form_Element_Text('phone');
		$phone->addFilter('StringTrim')
			->setRequired(true);
		$this->addElement($phone);
                
                $date = new Zend_Form_Element_Text('date_registered');
		$date->addFilter('StringTrim')
			->setRequired(true);
		$this->addElement($date);
	}
}