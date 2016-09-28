<?php

class Application_Form_Blog_PostAdd extends Zend_Form
{
	public function init() {
            
		$postTitle = new Zend_Form_Element_Text('title');
		$postTitle->addFilter('StringTrim')
			->addValidator('StringLength', false, array('min' => 3, 'max' => 255))
			->setRequired(true);
		$this->addElement($postTitle);
                
                $postTags = new Zend_Form_Element_Text('tags');
		$postTags->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($postTags);
                
		$postText = new Zend_Form_Element_Textarea('text');
                $postText->setRequired(false);
		$this->addElement($postText);
                
                $authorId = new Zend_Form_Element_Hidden('author_id');
		$authorId->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($authorId);
                
                $postTime = new Zend_Form_Element_Hidden('date_published');
		$postTime->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($postTime);
	
                $postPhoto = new Zend_Form_Element_File('post_photo');
                $postPhoto->addValidator('Count', true, 1)
                    ->addValidator('MimeType', true, array('image/jpeg', 'image/gif', 'image/png'))
                    ->addValidator('ImageSize', false, array(
                        'minwidth' => 100,
                        'minheight' => 100,
                        'maxwidth' => 3000,
                        'maxheight' => 3000,
                    ))
                    ->addValidator('FilesSize', false, array(
                        'max' => '4MB'
                    ))
                    //disable moving file to destination when calling method getValues()
                    ->setValueDisabled(true)
                    ->setRequired(false);
                $this->addElement($postPhoto);
                
                $categoryGeneral = new Zend_Form_Element_Text('category_general');
		$categoryGeneral->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($categoryGeneral);
                
                $categoryAnnouncements = new Zend_Form_Element_Text('category_announcements');
		$categoryAnnouncements->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($categoryAnnouncements);
                
                $categoryNews = new Zend_Form_Element_Text('category_news');
		$categoryNews->addFilter('StringTrim')
			->setRequired(false);
		$this->addElement($categoryNews);
	}
}