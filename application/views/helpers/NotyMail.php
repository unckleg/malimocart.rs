<?php

class Zend_View_Helper_NotyMail extends Zend_View_Helper_Abstract
{
    protected $mailCount;
    protected function getMailCount()
    {
        if(!$this->mailCount) 
        {
            $this->mailCount = new Application_Model_DbTable_Front_FrontContact();
        }
        return $this->mailCount;
    }
    
    public function notyMail()
    {
        $modelMail = $this->getMailCount();
        // Message counters
        $count = $modelMail->count(array('status' => 0,)); 
        $mails  = $modelMail->search(array('filters' => array('status' => 0,),'limit' => 4));?>
        
        <li class="dropdown dropdown-fuse">
           <div class="navbar-btn btn-group">
              <button class="dropdown-toggle btn btn-hover-effects" data-toggle="dropdown">
              <span class="fa fa-envelope fs20 text-info-darker"></span>
              <?php if (!empty($count)) {?>
                <span class="fs14 visible-xl">
                    <?php echo $count;?>
                </span>
               <?php };?>
              </button>
              <div class="navbar-activity dropdown-menu keep-dropdown w375" role="menu">
                 <div class="panel mbn">
                    <div class="panel-menu">
                       <div class="btn-group btn-group-nav" role="tablist">
                          <a href="" data-toggle="tab" class="btn btn-primary btn-sm active">Поруке</a>
                       </div>
                       <button class="btn btn-xs" type="button"><i class="fa fa-refresh"></i>
                       </button>
                    </div>
                    <div class="panel-body pn">
                       <div class="tab-content br-n pn">
                          <div id="nav-tab4" class="tab-pane active" role="tabpanel">
                             <ol class="timeline-list">
                                <?php foreach ($mails as $mail):?> 
                                    <li class="timeline-item">
                                       <div class="timeline-icon light">
                                          <span class="fa fa-envelope"></span>
                                       </div>
                                       <div class="timeline-desc">
                                          <b><?= $mail['from_name'];?> <span></span> <span class="timeline-date"><?= date('d-m-y', strtotime($mail['date_sended']));?></span></b>
                                          Послао/ла Вам је поруку.
                                          <a href="<?= $this->view->url(array('controller' => 'admin_mail', 'action' => 'index'),'default',true);?>">
                                              Погледај све
                                          </a>
                                       </div>
                                    </li>
                                <?php endforeach;?>
                             </ol>
                          </div>
                       </div>
                    </div>
                    <div class="panel-footer text-center">
                       <a href="<?= $this->view->url(array('controller' => 'admin_mail', 'action' => 'index'),'default',true);?>" class="btn btn-warning btn-sm"> Погледај све </a>
                    </div>
                 </div>
              </div>
           </div>
        </li>
<?php }
    
}