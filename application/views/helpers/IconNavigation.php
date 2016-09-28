<?php

class Zend_View_Helper_IconNavigation extends Zend_View_Helper_Abstract
{
	public function iconNavigation() { ?> 
    <div id="topbar-dropmenu-wrapper" class="topbar-dropmenu-open" style="display: block; padding:10px !important;">
        <div class="topbar-menu row col-lg-12">
            <div class="col-xs-4 col-sm-2">
               <a href="<?= $this->view->url(array('controller' => 'admin_pages', 'action' => 'index'), 'default', true);?>" class="service-box bg-danger">
                <span class="fa fa-list-alt"></span>
                <span class="service-title">Странице</span>
               </a>
            </div>
            <div class="col-xs-4 col-sm-2">
               <a href="#" class="service-box bg-success">
               <span class="fa fa-picture-o"></span>
               <span class="service-title">Галерије</span>
               </a>
            </div>
            <div class="col-xs-4 col-sm-2">
               <a href="<?= $this->view->url(array('controller' => 'admin_blog', 'action' => 'index'),'default',true);?>" class="service-box bg-primary">
               <span class="fa fa-pencil-square-o"></span>
               <span class="service-title">Блог</span>
               </a>
            </div>
            <div class="col-xs-4 col-sm-2">
               <a href="<?= $this->view->url(array('controller' => 'admin_mail', 'action' => 'index'),'default',true);?>" class="service-box bg-alert">
               <span class="fa fa-envelope"></span>
               <span class="service-title">Поруке</span>
               </a>
            </div>
            <div class="col-xs-4 col-sm-2">
               <a href="<?= $this->view->url(array('controller' => 'admin_registered', 'action' => 'index'), 'default', true);?>" class="service-box bg-system">
               <span class="fa fa-users"></span>
               <span class="service-title">Пријаве</span>
               </a>
            </div>
            <div class="col-xs-4 col-sm-2">
               <a href="#" class="service-box bg-dark">
               <span class="fa fa-cog"></span>
               <span class="service-title">Подешавања</span>
               </a>
            </div>
        </div>
    </div>
<?php 
   }
}
?>