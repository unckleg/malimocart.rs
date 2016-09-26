<?php

class Zend_View_Helper_SystemMessagesHtml extends Zend_View_Helper_Abstract
{
	public function systemMessagesHtml($systemMessages) {
		
		//reset placeholder
		$this->view->placeholder('systemMessagesHtml')->exchangeArray(array());
		if (!empty($systemMessages['success'])) {
			foreach ($systemMessages['success'] as $message) {
				$this->view->placeholder('systemMessagesHtml')->captureStart();
				?>
                                <div class="nicdark_alerts nicdark_bg_green nicdark_radius nicdark_shadow" style="margin-bottom: 15px;">
                                    <p class="white nicdark_size_medium"><i class="icon-cancel-circled-outline iconclose"></i>&nbsp;&nbsp;&nbsp;
                                        <strong>ЧЕСТИТАМО:</strong>&nbsp;&nbsp;&nbsp;<?php echo $this->view->escape($message);?></p>
                                    <i class="icon-ok-outline nicdark_iconbg right medium green"></i>
                                </div>
				<?php
				$this->view->placeholder('systemMessagesHtml')->captureEnd();
			}
		}
		if (!empty($systemMessages['errors'])) {
			foreach ($systemMessages['errors'] as $message) {
				$this->view->placeholder('systemMessagesHtml')->captureStart();
				?>
				<div class="nicdark_alerts nicdark_bg_red nicdark_radius nicdark_shadow" style="margin-bottom: 15px;">
                                    <p class="white nicdark_size_medium"><i class="icon-cancel-circled-outline iconclose"></i>&nbsp;&nbsp;&nbsp;
                                        <strong>ГРЕШКА:</strong>&nbsp;&nbsp;&nbsp;<?php echo $this->view->escape($message);?></p>
                                    <i class="icon-cancel-outline nicdark_iconbg right medium red"></i>
                                </div>
				<?php
				$this->view->placeholder('systemMessagesHtml')->captureEnd();
			}
		}
		return $this->view->placeholder('systemMessagesHtml')->toString();
	}
}