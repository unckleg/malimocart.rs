<?php

class Zend_View_Helper_WorkshopImgUrl extends Zend_View_Helper_Abstract
{
	public function workshopImgUrl($workshop) {
		$workshopImgFileName = $workshop['id'] . '.jpg';
                
		$workshopImgFilePath = PUBLIC_PATH . '/uploads/workshop-images/' . $workshopImgFileName;
                
		if (is_file($workshopImgFilePath)) {
			return $this->view->baseUrl('/uploads/workshop-images/' . $workshopImgFileName);
		} else {
			return $this->view->baseUrl('/uploads/workshops-images/no-image.jpg');
		}
	}
}
