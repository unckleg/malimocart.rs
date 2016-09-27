<?php

class Application_Form_Contact extends Zend_Form
{
	public function init() {
		
		$name = new Zend_Form_Element_Text('from_name');
		$name->addFilter('StringTrim')
			->addValidator('StringLength', false, array('min' => 2, 'max' => 255))
			->setRequired(true);
		$this->addElement($name);
                
		$email = new Zend_Form_Element_Text('from_email');
		$email->addFilter('StringTrim')
			->addValidator('EmailAddress', false, array('domain' => false))
			->setRequired(true);
		$this->addElement($email);
                
                $subject = new Zend_Form_Element_Textarea('message_text');
		$subject->addFilter('StringTrim')
			->setRequired(true);
		$this->addElement($subject);
                
                $body = new Zend_Form_Element_Textarea('useragent');
		$body->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($body);
                
                $dateSubscribed = new Zend_Form_Element_Text('ip');
		$dateSubscribed->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($dateSubscribed);
                
                $datesended = new Zend_Form_Element_Text('date_sended');
		$datesended->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($datesended);
                
	}
}