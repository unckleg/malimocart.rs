<?php

class Application_Form_WorkshopEdit extends Zend_Form
{
	public function init() {
            
		$title = new Zend_Form_Element_Text('title');
		$title->addFilter('StringTrim')
			->addValidator('StringLength', false, array('min' => 3, 'max' => 500))
			->setRequired(false);
		$this->addElement($title);
		
		$shortDesc = new Zend_Form_Element_Textarea('short_description');
		$shortDesc->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($shortDesc);
		
		$fullDesc = new Zend_Form_Element_Textarea('description');
		$fullDesc->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($fullDesc);

                
                $workshopPhoto = new Zend_Form_Element_File('workshop_photo');
                $workshopPhoto->addValidator('Count', true, 1)
                    ->addValidator('MimeType', true, array('image/jpeg', 'image/gif', 'image/png'))
                    ->addValidator('ImageSize', false, array(
                        'minwidth' => 100,
                        'minheight' => 100,
                        'maxwidth' => 3000,
                        'maxheight' => 3000,
                    ))
                    ->addValidator('FilesSize', false, array(
                        'max' => '8MB'
                    ))
                    //disable moving file to destination when calling method getValues()
                    ->setValueDisabled(true)
                    ->setRequired(false);
                $this->addElement($workshopPhoto);
	}
}