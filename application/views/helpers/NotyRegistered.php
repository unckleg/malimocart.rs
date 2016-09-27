<?php

class Zend_View_Helper_NotyRegistered extends Zend_View_Helper_Abstract
{
    protected $registeredCount;
    protected function getRegisteredCount()
    {
        if(!$this->registeredCount) 
        {
            $this->registeredCount = new Application_Model_DbTable_Front_FrontRegister();
        }
        return $this->registeredCount;
    }
    
    public function notyRegistered()
    { 
        $modelParents = $this->getRegisteredCount();
        // Message counters
        $count = $modelParents->count(array('status' => 0,)); 
        $parents = $modelParents->search(array('filters' => array('status' => 0,), 'orders' => array('date_registered' => 'DESC')));?>

        <li class="dropdown dropdown-fuse">
        <div class="navbar-btn btn-group">
           <button class="dropdown-toggle btn btn-hover-effects" data-toggle="dropdown">
           <span class="fa fa-plus fs20 text-danger"></span>
           <?php if (!empty($count)) {?>
            <span class="fs14 visible-xl">
                <?php echo $count;?>
            </span>
           <?php };?>
           </button>
            <div class="navbar-activity dropdown-menu keep-dropdown w375" role="menu">
                 <div class="panel mbn">
                    <div class="panel-menu">
                       <div class="btn-group btn-group-justified btn-group-nav" role="tablist">
                          <a href="" data-toggle="tab" class="btn btn-sm active">Пријаве</a>
                       </div>
                    </div>
                    <div class="panel-body pn">
                       <div class="tab-content br-n pn">
                          <div id="nav-tab1" class="tab-pane active" role="tabpanel">
                             <ul class="media-list" role="menu">
                                <?php foreach ($parents as $parent):?>
                                    <li class="media">
                                       <a class="media-left" href="#">
                                       <img src="" class="br3" alt="пријављени">
                                       </a>
                                       <div class="media-body">
                                          <h5 class="media-heading">Најновије
                                             <span class="text-muted">- <?= date('Y-m-D', strtotime($parent['date_registered']));?></span>
                                          </h5>
                                          Нови пријављени
                                          <a class="" href="#"><?= $parent['parent_name'] ." ". $parent['parent_surname'];?> </a>
                                       </div>
                                    </li>
                                <?php endforeach; ?>    
                             </ul>
                          </div>
                       </div>
                    </div>
                    <div class="panel-footer text-center">
                       <a href="<?= $this->view->url(array('controller' => 'admin_registered', 'action' => 'index'),'default',true);?>" class="btn btn-warning"> Погледај све </a>
                    </div>
                 </div>
            </div>
        </div>
     </li>

<?php }
}